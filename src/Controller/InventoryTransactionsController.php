<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * InventoryTransactions Controller
 *
 * @property \App\Model\Table\InventoryTransactionsTable $InventoryTransactions
 */
class InventoryTransactionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->InventoryTransactions->find()
            ->contain(['ProductVariants']);
        $inventoryTransactions = $this->paginate($query);

        $this->set(compact('inventoryTransactions'));
    }

    /**
     * View method
     *
     * @param string|null $id Inventory Transaction id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $inventoryTransaction = $this->InventoryTransactions->get($id, contain: ['ProductVariants']);
        $this->set(compact('inventoryTransaction'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $inventoryTransaction = $this->InventoryTransactions->newEmptyEntity();
        if ($this->request->is('post')) {
            $inventoryTransaction = $this->InventoryTransactions->patchEntity($inventoryTransaction, $this->request->getData());
            if ($this->InventoryTransactions->save($inventoryTransaction)) {
                $this->Flash->success(__('The inventory transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inventory transaction could not be saved. Please, try again.'));
        }
        $productVariants = $this->InventoryTransactions->ProductVariants->find('list', limit: 200)->all();
        $this->set(compact('inventoryTransaction', 'productVariants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Inventory Transaction id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $inventoryTransaction = $this->InventoryTransactions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $inventoryTransaction = $this->InventoryTransactions->patchEntity($inventoryTransaction, $this->request->getData());
            if ($this->InventoryTransactions->save($inventoryTransaction)) {
                $this->Flash->success(__('The inventory transaction has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The inventory transaction could not be saved. Please, try again.'));
        }
        $productVariants = $this->InventoryTransactions->ProductVariants->find('list', limit: 200)->all();
        $this->set(compact('inventoryTransaction', 'productVariants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Inventory Transaction id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $inventoryTransaction = $this->InventoryTransactions->get($id);
        if ($this->InventoryTransactions->delete($inventoryTransaction)) {
            $this->Flash->success(__('The inventory transaction has been deleted.'));
        } else {
            $this->Flash->error(__('The inventory transaction could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
