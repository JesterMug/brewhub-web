<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Forms Controller
 *
 * @property \App\Model\Table\FormsTable $Forms
 */
class FormsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */

    public function initialize(): void
    {
        parent::initialize();
        $this->Authentication->allowUnauthenticated(['add']);
    }

    public function index()
    {
        $this->checkAdminAuth();
        $query = $this->Forms->find();
        $forms = $this->paginate($query);

        $this->set(compact('forms'));
    }

    /**
     * View method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $this->checkAdminAuth();
        $form = $this->Forms->get($id, contain: []);
        $this->set(compact('form'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $form = $this->Forms->newEmptyEntity();
        if ($this->request->is('post')) {
            $form = $this->Forms->patchEntity($form, $this->request->getData());
            if ($this->Forms->save($form)) {
                $this->Flash->success(__('Thank you for your message. We will get back to you shortly.'));
                return $this->redirect(['controller' => 'Pages', 'action' => 'display', 'home']);
            }
            $this->Flash->error(__('Your message could not be sent. Please, try again.'));
        }
        $this->set(compact('form'));
        $this->viewBuilder()->setLayout('frontend');
    }

    /**
     * Edit method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $this->checkAdminAuth();
        $form = $this->Forms->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $form = $this->Forms->patchEntity($form, $this->request->getData());
            if ($this->Forms->save($form)) {
                $this->Flash->success(__('The form has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The form could not be saved. Please, try again.'));
        }
        $this->set(compact('form'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Form id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->checkAdminAuth();
        $this->request->allowMethod(['post', 'delete']);
        $form = $this->Forms->get($id);
        if ($this->Forms->delete($form)) {
            $this->Flash->success(__('The form has been deleted.'));
        } else {
            $this->Flash->error(__('The form could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function mark(?string $id = null)
    {
        $this->checkAdminAuth();
        $form = $this->Forms->get($id);
        if ($form->replied_status) {
            $form->replied_status = false;
            if ($this->Forms->save($form)) {
                $this->Flash->success(__('The form has been unmarked.'));
            } else {
                $this->Flash->error(__('The form could not be unmarked. Please, try again.'));
            }
        } else {
            $form->replied_status = true;
            if ($this->Forms->save($form)) {
                $this->Flash->success(__('The form has been marked.'));
            } else {
                $this->Flash->error(__('The form could not be marked. Please, try again.'));
            }
        }

        return $this->redirect(['action' => 'view', $id]);
    }

}
