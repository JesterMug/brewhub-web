<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * ContentBlocks Controller
 *
 * @property \App\Model\Table\ContentBlocksTable $ContentBlocks
 */
class ContentBlocksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->ContentBlocks->find();
        $contentBlocks = $this->paginate($query);

        $this->set(compact('contentBlocks'));
    }

    /**
     * View method
     *
     * @param string|null $id Content Block id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $contentBlock = $this->ContentBlocks->get($id, contain: ['Phinxlog']);
        $this->set(compact('contentBlock'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $contentBlock = $this->ContentBlocks->newEmptyEntity();
        if ($this->request->is('post')) {
            $contentBlock = $this->ContentBlocks->patchEntity($contentBlock, $this->request->getData());
            if ($this->ContentBlocks->save($contentBlock)) {
                $this->Flash->success(__('The content block has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content block could not be saved. Please, try again.'));
        }
        $phinxlog = $this->ContentBlocks->Phinxlog->find('list', limit: 200)->all();
        $this->set(compact('contentBlock', 'phinxlog'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Content Block id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $contentBlock = $this->ContentBlocks->get($id, contain: ['Phinxlog']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $contentBlock = $this->ContentBlocks->patchEntity($contentBlock, $this->request->getData());
            if ($this->ContentBlocks->save($contentBlock)) {
                $this->Flash->success(__('The content block has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The content block could not be saved. Please, try again.'));
        }
        $phinxlog = $this->ContentBlocks->Phinxlog->find('list', limit: 200)->all();
        $this->set(compact('contentBlock', 'phinxlog'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Content Block id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $contentBlock = $this->ContentBlocks->get($id);
        if ($this->ContentBlocks->delete($contentBlock)) {
            $this->Flash->success(__('The content block has been deleted.'));
        } else {
            $this->Flash->error(__('The content block could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
