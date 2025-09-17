<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ProductMerchandise Controller
 *
 * @property \App\Model\Table\ProductMerchandiseTable $ProductMerchandise
 */
class ProductMerchandiseController extends AppController
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
        $query = $this->ProductMerchandise->find()
            ->contain(['Products']);
        $productMerchandise = $this->paginate($query);

        $this->set(compact('productMerchandise'));
    }

    /**
     * View method
     *
     * @param string|null $id Product Merchandise id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $productMerchandise = $this->ProductMerchandise->get($id, contain: ['Products']);
        $this->set(compact('productMerchandise'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $productMerchandise = $this->ProductMerchandise->newEmptyEntity();
        if ($this->request->is('post')) {
            $productMerchandise = $this->ProductMerchandise->patchEntity($productMerchandise, $this->request->getData());
            if ($this->ProductMerchandise->save($productMerchandise)) {
                $this->Flash->success(__('The product merchandise has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product merchandise could not be saved. Please, try again.'));
        }
        $products = $this->ProductMerchandise->Products->find('list', limit: 200)->all();
        $this->set(compact('productMerchandise', 'products'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product Merchandise id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $productMerchandise = $this->ProductMerchandise->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $productMerchandise = $this->ProductMerchandise->patchEntity($productMerchandise, $this->request->getData());
            if ($this->ProductMerchandise->save($productMerchandise)) {
                $this->Flash->success(__('The product merchandise has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product merchandise could not be saved. Please, try again.'));
        }
        $products = $this->ProductMerchandise->Products->find('list', limit: 200)->all();
        $this->set(compact('productMerchandise', 'products'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product Merchandise id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $productMerchandise = $this->ProductMerchandise->get($id);
        if ($this->ProductMerchandise->delete($productMerchandise)) {
            $this->Flash->success(__('The product merchandise has been deleted.'));
        } else {
            $this->Flash->error(__('The product merchandise could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
