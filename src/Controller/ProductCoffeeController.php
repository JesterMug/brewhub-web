<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProductCoffee Controller
 *
 * @property \App\Model\Table\ProductCoffeeTable $ProductCoffee
 */
class ProductCoffeeController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->checkAdminAuth();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ProductCoffee->find()
            ->contain(['Products']);
        $productCoffee = $this->paginate($query);

        $this->set(compact('productCoffee'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Coffee id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productCoffee = $this->ProductCoffee->get($id, contain: ['Products']);
        $this->set(compact('productCoffee'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productCoffee = $this->ProductCoffee->newEmptyEntity();
        if ($this->request->is('post')) {
            $productCoffee = $this->ProductCoffee->patchEntity($productCoffee, $this->request->getData());
            if ($this->ProductCoffee->save($productCoffee)) {
                $this->Flash->success(__('The product coffee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product coffee could not be saved. Please, try again.'));
        }
        $products = $this->ProductCoffee->Products->find('list', limit: 200)->all();
        $this->set(compact('productCoffee', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Coffee id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productCoffee = $this->ProductCoffee->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productCoffee = $this->ProductCoffee->patchEntity($productCoffee, $this->request->getData());
            if ($this->ProductCoffee->save($productCoffee)) {
                $this->Flash->success(__('The product coffee has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product coffee could not be saved. Please, try again.'));
        }
        $products = $this->ProductCoffee->Products->find('list', limit: 200)->all();
        $this->set(compact('productCoffee', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Coffee id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productCoffee = $this->ProductCoffee->get($id);
        if ($this->ProductCoffee->delete($productCoffee)) {
            $this->Flash->success(__('The product coffee has been deleted.'));
        } else {
            $this->Flash->error(__('The product coffee could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
