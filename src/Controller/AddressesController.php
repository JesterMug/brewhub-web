<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Datasource\Exception\RecordNotFoundException;

/**
 * Addresses Controller
 *
 * @property \App\Model\Table\AddressesTable $Addresses
 */
class AddressesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Frontend customer context
        $this->viewBuilder()->setLayout('frontend');
        // Require authentication for managing addresses
        $this->Authentication->addUnauthenticatedActions([]);
    }

    /**
     * Index method (admin-style list retained if needed)
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Addresses->find()->contain(['Users']);
        $addresses = $this->paginate($query);
        $this->set(compact('addresses'));
    }

    /**
     * View method
     *
     * @param string|null $id Address id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $address = $this->Addresses->get($id, contain: ['Users', 'Orders']);
        $this->set(compact('address'));
    }

    /**
     * Add method — customer adds own address.
     */
    public function add()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $address = $this->Addresses->newEmptyEntity();
        if ($this->request->is('post')) {
            $data = $this->request->getData();
            // Force ownership and default active if not set
            $data['user_id'] = (int)$identity->id;
            if (!isset($data['is_active'])) { $data['is_active'] = true; }

            $address = $this->Addresses->patchEntity($address, $data, [
                'accessibleFields' => ['user_id' => true],
            ]);
            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('Address saved.'));
                return $this->redirect(['controller' => 'Profile', 'action' => 'addresses']);
            }
            $this->Flash->error(__('The address could not be saved. Please, check details and try again.'));
        }
        $this->set(compact('address'));
    }

    /**
     * Edit method — only owner can edit.
     *
     * @param string|int|null $id Address id.
     */
    public function edit($id = null)
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $address = $this->Addresses->find()
            ->where(['Addresses.id' => (int)$id, 'Addresses.user_id' => (int)$identity->id])
            ->first();
        if (!$address) {
            throw new RecordNotFoundException('Address not found.');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // Never allow changing ownership
            $address = $this->Addresses->patchEntity($address, $data, [
                'accessibleFields' => ['user_id' => false],
            ]);
            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('Address updated.'));
                return $this->redirect(['controller' => 'Profile', 'action' => 'addresses']);
            }
            $this->Flash->error(__('The address could not be saved. Please, check details and try again.'));
        }
        $this->set(compact('address'));
    }

    /**
     * Delete method — only owner can delete but softly.
     */
    public function delete($id = null)
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        $address = $this->Addresses->find()
            ->where(['Addresses.id' => (int)$id, 'Addresses.user_id' => (int)$identity->id])
            ->first();
        if (!$address) {
            $this->Flash->error(__('Address not found.'));
            return $this->redirect(['controller' => 'Profile', 'action' => 'addresses']);
        }
        // Soft delete: mark as inactive instead of removing the record because order will store them,
        $address->is_active = false;
        if ($this->Addresses->save($address)) {
            $this->Flash->success(__('The address has been deleted.'));
        } else {
            $this->Flash->error(__('The address could not be deleted. Please, try again.'));
        }
        return $this->redirect(['controller' => 'Profile', 'action' => 'addresses']);
    }
}
