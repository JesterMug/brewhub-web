<?php
declare(strict_types=1);

namespace App\Controller;

use Cake\ORM\TableRegistry;

class ProfileController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        // Require authentication for all profile pages
        $this->Authentication->addUnauthenticatedActions([]);
        $this->viewBuilder()->setLayout('frontend');
    }

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->viewBuilder()->setLayout('frontend');
    }

    // Profile overview page
    public function index()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            // Redirect unauthenticated users to login
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->get((int)$identity->id, [
            'contain' => [
                'Addresses' => function($q) { return $q->where(['Addresses.is_active' => true]); },
                'Orders' => function($q) { return $q->orderDesc('Orders.id')->limit(5); },
            ]
        ]);

        $this->set(compact('user'));
    }

    // List user's addresses
    public function addresses()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $addressesTable = $this->fetchTable('Addresses');
        $addresses = $addressesTable->find()
            ->where(['user_id' => (int)$identity->id, 'is_active' => true])
            ->orderByDesc('id')
            ->all();

        $this->set(compact('addresses'));
    }

    // List user's orders
    public function orders()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $ordersTable = $this->fetchTable('Orders');
        $orders = $this->paginate(
            $ordersTable->find()
                ->where(['Orders.user_id' => (int)$identity->id])
                ->contain(['OrderProductVariants'])
                ->orderByDesc('Orders.order_date')
        );

        $this->set(compact('orders'));
    }

    // Edit own profile
    public function edit()
    {
        $identity = $this->request->getAttribute('identity');
        if (!$identity) {
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        $usersTable = $this->fetchTable('Users');
        $user = $usersTable->get((int)$identity->id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();
            // Allow only safe fields to be updated by the customer
            $allowed = ['first_name', 'last_name', 'email'];
            $filtered = array_intersect_key($data, array_flip($allowed));
            $user = $usersTable->patchEntity($user, $filtered, ['accessibleFields' => ['user_type' => false]]);
            if ($usersTable->save($user)) {
                $this->Flash->success('Your profile has been updated.');
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error('Could not update your profile. Please check the details and try again.');
        }

        $this->set(compact('user'));
    }
}
