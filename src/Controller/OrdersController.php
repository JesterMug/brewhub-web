<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Orders Controller
 *
 * @property \App\Model\Table\OrdersTable $Orders
 */
class OrdersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Orders->find()
            ->contain(['Addresses']);
        $orders = $this->paginate($query);

        $this->set(compact('orders'));
    }

    /**
     * Admin Index method (Admin dashboard view)
     *
     * Lists all orders in a DataTable-like view similar to products/index.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function adminIndex()
    {
        // Restrict to admin/superuser similar to ProductsController
        $this->checkAdminAuth();

        $query = $this->Orders->find()
            ->contain(['Users', 'Addresses'])
            ->orderByDesc('Orders.order_date');

        $orders = $this->paginate($query);

        $this->set(compact('orders'));
        $this->viewBuilder()->setTemplate('admin_index');
    }

    /**
     * Admin Preorders method
     *
     * Lists orders that contain at least one preorder item and are not shipped.
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function adminPreorders()
    {
        // Restrict to admin/superuser
        $this->checkAdminAuth();

        // Build an aggregated list of preorder items across all unshipped orders
        $opvTable = $this->Orders->OrderProductVariants;
        $sum = $opvTable->find()->func()->sum('OrderProductVariants.quantity');

        $query = $opvTable->find()
            ->select([
                'product_variant_id' => 'OrderProductVariants.product_variant_id',
                'total_quantity' => $sum,
                'orders_count' => 'COUNT(DISTINCT OrderProductVariants.order_id)'
            ])
            ->contain([
                'ProductVariants' => ['Products']
            ])
            ->innerJoinWith('Orders', function ($q) {
                return $q->where(['Orders.shipping_status !=' => 'shipped']);
            })
            ->where(['OrderProductVariants.is_preorder' => true])
            ->group(['OrderProductVariants.product_variant_id'])
            ->orderBy(['total_quantity' => 'DESC']);

        $preorderItems = $query->all();

        $variantIds = [];
        foreach ($preorderItems as $row) {
            $vid = (int)($row->get('product_variant_id') ?? 0);
            if ($vid > 0) { $variantIds[$vid] = true; }
        }
        if (!empty($variantIds)) {
            $variants = $opvTable->ProductVariants->find()
                ->where(['ProductVariants.id IN' => array_keys($variantIds)])
                ->contain(['Products'])
                ->all()
                ->indexBy('id')
                ->toArray();

            // Attach variants and filter out items that no longer require purchase
            $filtered = [];
            foreach ($preorderItems as $row) {
                $vid = (int)($row->get('product_variant_id') ?? 0);
                if ($vid > 0 && isset($variants[$vid])) {
                    $variant = $variants[$vid];
                    $row->set('product_variant', $variant);

                    $totalQty = (int)($row->get('total_quantity') ?? 0);
                    $stock = (int)($variant->stock ?? 0);
                    if ($totalQty > $stock) {
                        $filtered[] = $row; // still a shortage; keep in preorders list
                    }
                }
            }
            $preorderItems = $filtered;
        }

        $this->set(compact('preorderItems'));
        $this->viewBuilder()->setTemplate('admin_preorders');
    }

    /**
     * View method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $order = $this->Orders->get($id, contain: [
            'Addresses',
            'Invoices',
            'OrderProductVariants' => ['ProductVariants' => ['Products']],
        ]);
        $this->set(compact('order'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $order = $this->Orders->newEmptyEntity();
        if ($this->request->is('post')) {
            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', limit: 200)->all();
        $addresses = $this->Orders->Addresses->find('list', limit: 200)->all();
        $this->set(compact('order', 'users', 'addresses'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $order = $this->Orders->get($id, contain: []);
        $originalStatus = $order->shipping_status;
        if ($this->request->is(['patch', 'post', 'put'])) {
            $incomingStatus = (string)($this->request->getData('shipping_status') ?? $order->shipping_status);

            // If attempting to set to shipped, ensure preorder items have sufficient stock
            if ($incomingStatus === 'shipped') {
                $orderWithItems = $this->Orders->get($id, contain: [
                    'OrderProductVariants' => ['ProductVariants']
                ]);
                $insufficient = false;
                foreach ($orderWithItems->order_product_variants ?? [] as $opv) {
                    if (!empty($opv->is_preorder)) {
                        $variant = $opv->product_variant ?? null;
                        $variantStock = (int)($variant->stock ?? 0);
                        $qty = (int)($opv->quantity ?? 0);
                        if ($variantStock < $qty) {
                            $insufficient = true;
                            break;
                        }
                    }
                }
                if ($insufficient) {
                    $this->Flash->error(__('Cannot mark as shipped. Not enough stock available to fulfill one or more preorder items.'));
                    return $this->redirect(['action' => 'view', $id]);
                }
            }

            $order = $this->Orders->patchEntity($order, $this->request->getData());
            if ($this->Orders->save($order)) {
                // If shipping status transitioned to shipped, process preorder shipment deductions
                if (($originalStatus !== 'shipped') && ($order->shipping_status === 'shipped')) {
                    try {
                        $identity = $this->request->getAttribute('identity');
                        $actor = $identity->email ?? $identity->username ?? 'system';
                        $this->Orders->processPreorderShipment((int)$order->id, (string)$actor);
                    } catch (\Throwable $e) {
                        \Cake\Log\Log::error('Failed to process preorder shipment for order ' . $order->id . ': ' . $e->getMessage());
                        $this->Flash->warning(__('Order marked as shipped, but inventory deduction for preorder items may have failed. Please review inventory.'));
                    }
                }

                $this->Flash->success(__('The order has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order could not be saved. Please, try again.'));
        }
        $users = $this->Orders->Users->find('list', limit: 200)->all();
        $addresses = $this->Orders->Addresses->find('list', limit: 200)->all();
        $this->set(compact('order', 'users', 'addresses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $order = $this->Orders->get($id);
        if ($this->Orders->delete($order)) {
            $this->Flash->success(__('The order has been deleted.'));
        } else {
            $this->Flash->error(__('The order could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
