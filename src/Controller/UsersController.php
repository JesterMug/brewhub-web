<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->checkAdminAuth();
    }

    public function password($id = null)
    {
        $user = $this->Users->get($id);
        if ($this->request->is(['post', 'put', 'patch'])) {
            $data = (array)$this->request->getData();
            $password = $data['password'] ?? '';
            $confirm = $data['confirm_password'] ?? '';
            if ($password === '' || $confirm === '') {
                $this->Flash->error(__('Please enter and confirm the new password.'));
            } elseif ($password !== $confirm) {
                $this->Flash->error(__('Passwords do not match.'));
            } else {
                // Only patch the password field to avoid unintended changes
                $user = $this->Users->patchEntity($user, ['password' => $password]);
                if ($this->Users->save($user)) {
                    $this->Flash->success(__('Password updated successfully.'));
                    return $this->redirect(['action' => 'view', $user->id]);
                }
                $this->Flash->error(__('The password could not be updated. Please, try again.'));
            }
        }
        $this->set(compact('user'));
    }

    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);
        $this->set(compact('users'));
    }

    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['Addresses', 'Orders']);
        $this->set(compact('user'));
    }

    public function add()
    {
        $this->checkSuperuserAuth();
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    public function delete($id = null)
    {
        $this->checkSuperuserAuth();
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }
        return $this->redirect(['action' => 'index']);
    }


    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $identity = $this->Authentication->getIdentity();
            if (in_array($identity->user_type, ['admin','superuser'], true)) {
                return $this->redirect(['controller' => 'Pages', 'action' => 'dashboard']);
            }
            return $this->redirect('/');
        }
        if ($this->request->is('post')) {
            $this->Flash->error(__('Email address and/or Password is incorrect. Please try again.'));
        }
    }


    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect('/');
    }
}
