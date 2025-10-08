<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\Http\Exception\ForbiddenException;

/**
 * Addresses Controller
 *
 * @property \App\Model\Table\AddressesTable $Addresses
 */
class AddressesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Require authentication for all address actions (customer-owned)
        $this->Authentication->addUnauthenticatedActions([]);
        // Use the frontend site layout
        $this->viewBuilder()->setLayout('frontend');
    }

    /**
     * Index method (customer's own addresses)
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $addresses = $this->Addresses->find()
            ->where(['user_id' => (int)$identity->id])
            ->orderByDesc('id');

        $this->set(compact('addresses'));
    }

    /**
     * View a single address (must belong to the logged-in user)
     */
    public function view($id = null)
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        $address = $this->Addresses->get($id);
        if ((int)$address->user_id !== (int)$identity->id) {
            throw new ForbiddenException('You are not allowed to view this address.');
        }
        $this->set(compact('address'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
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
            // Force ownership to logged-in user; ignore any incoming user_id
            $data['user_id'] = (int)$identity->id;
            $address = $this->Addresses->patchEntity($address, $data);
            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('The address has been saved.'));
                return $this->redirect(['controller' => 'Profile', 'action' => 'addresses']);
            }
            $this->Flash->error(__('The address could not be saved. Please, check the details and try again.'));
        }
        $this->set(compact('address'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Address id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     */
    public function edit($id = null)
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $address = $this->Addresses->get($id);
        if ((int)$address->user_id !== (int)$identity->id) {
            throw new ForbiddenException('You are not allowed to edit this address.');
        }

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            $data['user_id'] = (int)$identity->id; // ensure ownership remains
            $address = $this->Addresses->patchEntity($address, $data);
            if ($this->Addresses->save($address)) {
                $this->Flash->success(__('The address has been saved.'));
                return $this->redirect(['controller' => 'Profile', 'action' => 'addresses']);
            }
            $this->Flash->error(__('The address could not be saved. Please, check the details and try again.'));
        }
        $this->set(compact('address'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Address id.
     * @return \Cake\Http\Response|null Redirects to profile addresses.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }
        $address = $this->Addresses->get($id);
        if ((int)$address->user_id !== (int)$identity->id) {
            throw new ForbiddenException('You are not allowed to delete this address.');
        }
        if ($this->Addresses->delete($address)) {
            $this->Flash->success(__('The address has been deleted.'));
        } else {
            $this->Flash->error(__('The address could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Profile', 'action' => 'addresses']);
    }
}
