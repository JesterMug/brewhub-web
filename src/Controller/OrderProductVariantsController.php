<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * OrderProductVariants Controller
 *
 * @property \App\Model\Table\OrderProductVariantsTable $OrderProductVariants
 */
class OrderProductVariantsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->OrderProductVariants->find()
            ->contain(['Orders', 'ProductVariants']);
        $orderProductVariants = $this->paginate($query);

        $this->set(compact('orderProductVariants'));
    }

    /**
     * View method
     *
     * @param string|null $id Order Product Variant id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $orderProductVariant = $this->OrderProductVariants->get($id, contain: ['Orders', 'ProductVariants']);
        $this->set(compact('orderProductVariant'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $orderProductVariant = $this->OrderProductVariants->newEmptyEntity();
        if ($this->request->is('post')) {
            $orderProductVariant = $this->OrderProductVariants->patchEntity($orderProductVariant, $this->request->getData());
            if ($this->OrderProductVariants->save($orderProductVariant)) {
                $this->Flash->success(__('The order product variant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order product variant could not be saved. Please, try again.'));
        }
        $orders = $this->OrderProductVariants->Orders->find('list', limit: 200)->all();
        $productVariants = $this->OrderProductVariants->ProductVariants->find('list', limit: 200)->all();
        $this->set(compact('orderProductVariant', 'orders', 'productVariants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Order Product Variant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $orderProductVariant = $this->OrderProductVariants->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $orderProductVariant = $this->OrderProductVariants->patchEntity($orderProductVariant, $this->request->getData());
            if ($this->OrderProductVariants->save($orderProductVariant)) {
                $this->Flash->success(__('The order product variant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The order product variant could not be saved. Please, try again.'));
        }
        $orders = $this->OrderProductVariants->Orders->find('list', limit: 200)->all();
        $productVariants = $this->OrderProductVariants->ProductVariants->find('list', limit: 200)->all();
        $this->set(compact('orderProductVariant', 'orders', 'productVariants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Order Product Variant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $orderProductVariant = $this->OrderProductVariants->get($id);
        if ($this->OrderProductVariants->delete($orderProductVariant)) {
            $this->Flash->success(__('The order product variant has been deleted.'));
        } else {
            $this->Flash->error(__('The order product variant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
