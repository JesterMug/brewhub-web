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

        $query = $this->Orders->find()
            ->contain(['Users', 'Addresses'])
            ->matching('OrderProductVariants', function ($q) {
                return $q->where(['OrderProductVariants.is_preorder' => true]);
            })
            ->where(function ($exp, $q) {
                // Exclude shipped orders
                return $exp->notEq('Orders.shipping_status', 'shipped');
            })
            ->select(['Orders.id', 'Orders.order_date', 'Orders.shipping_status', 'Orders.user_id', 'Orders.address_id'])
            ->distinct(['Orders.id'])
            ->orderByDesc('Orders.order_date');

        $orders = $this->paginate($query);

        $this->set(compact('orders'));
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
        if ($this->request->is(['patch', 'post', 'put'])) {
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
