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
    public function index()
    {
        $forms = $this->Forms->find();

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
                $this->Flash->success(__('The form has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The form could not be saved. Please, try again.'));
        }
        $this->set(compact('form'));
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
