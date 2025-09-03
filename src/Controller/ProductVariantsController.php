<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProductVariants Controller
 *
 * @property \App\Model\Table\ProductVariantsTable $ProductVariants
 */
class ProductVariantsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ProductVariants->find()
            ->contain(['Products']);
        $productVariants = $this->paginate($query);

        $this->set(compact('productVariants'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Variant id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productVariant = $this->ProductVariants->get($id, contain: ['Products', 'CartItems', 'InventoryTransactions', 'OrderProductVariants']);
        $this->set(compact('productVariant'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productVariant = $this->ProductVariants->newEmptyEntity();
        if ($this->request->is('post')) {
            $productVariant = $this->ProductVariants->patchEntity($productVariant, $this->request->getData());
            if ($this->ProductVariants->save($productVariant)) {
                $this->Flash->success(__('The product variant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product variant could not be saved. Please, try again.'));
        }
        $products = $this->ProductVariants->Products->find('list', limit: 200)->all();
        $this->set(compact('productVariant', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Variant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productVariant = $this->ProductVariants->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productVariant = $this->ProductVariants->patchEntity($productVariant, $this->request->getData());
            if ($this->ProductVariants->save($productVariant)) {
                $this->Flash->success(__('The product variant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product variant could not be saved. Please, try again.'));
        }
        $products = $this->ProductVariants->Products->find('list', limit: 200)->all();
        $this->set(compact('productVariant', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Variant id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productVariant = $this->ProductVariants->get($id);
        if ($this->ProductVariants->delete($productVariant)) {
            $this->Flash->success(__('The product variant has been deleted.'));
        } else {
            $this->Flash->error(__('The product variant could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
