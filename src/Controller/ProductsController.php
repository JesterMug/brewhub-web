<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Products->find();
        $products = $this->paginate($query);

        $this->set(compact('products'));
    }

    /**
     * View method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $product = $this->Products->get($id, contain: ['ProductCoffee', 'ProductImages', 'ProductMerchandise', 'ProductVariants']);
        $this->set(compact('product'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            // Extract uploaded files
            $uploadedFiles = $this->request->getData('product_images_files');
            unset($data['product_images_files']);

            // Determine product type and normalize associated payloads
            $productType = $data['product_type'] ?? null;

            // Normalize nested associated data from singular form fields to hasMany arrays
            if (!empty($data['product_coffee']) && is_array($data['product_coffee']) && (empty($data['product_coffee'][0]) || !is_array($data['product_coffee'][0]))) {
                $data['product_coffee'] = [$data['product_coffee']];
            }
            if (!empty($data['product_merchandise']) && is_array($data['product_merchandise']) && (empty($data['product_merchandise'][0]) || !is_array($data['product_merchandise'][0]))) {
                $data['product_merchandise'] = [$data['product_merchandise']];
            }

            // Only keep the associated data relevant to the chosen product type
            $associated = ['ProductVariants'];
            if ($productType === 'coffee') {
                unset($data['product_merchandise']);
                $associated[] = 'ProductCoffee';
            } elseif ($productType === 'merchandise') {
                unset($data['product_coffee']);
                $associated[] = 'ProductMerchandise';
            } else {
                // If no product_type provided, remove both to avoid validation failures
                unset($data['product_coffee'], $data['product_merchandise']);
            }

            $product = $this->Products->patchEntity($product, $data, [
                'associated' => $associated,
            ]);

            if ($this->Products->save($product)) {
                $productId = $product->id;

                //Handle image uploads separately
                if (!empty($uploadedFiles[0])) {
                    foreach ($uploadedFiles as $file) {
                        if ($file && $file->getError() === UPLOAD_ERR_OK) {
                            $originalName = preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientFilename());
                            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                            $uniqueName = uniqid('img_', true) . '.' . strtolower($extension);

                            $file->moveTo(WWW_ROOT . 'img/products/' . $uniqueName);

                            $image = $this->Products->ProductImages->newEmptyEntity();
                            $image->product_id = $product->id;
                            $image->image_file = $uniqueName;
                            $this->Products->ProductImages->save($image);
                        }
                    }
                }

                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'index']);
            }

            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }

        $this->set(compact('product'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $product = $this->Products->get($id, contain: ['ProductCoffee', 'ProductImages', 'ProductMerchandise', 'ProductVariants']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            // Extract uploaded files (additional images)
            $uploadedFiles = $this->request->getData('product_images_files');
            unset($data['product_images_files']);

            // Normalize nested associated data from singular form fields to hasMany arrays
            if (!empty($data['product_coffee']) && is_array($data['product_coffee']) && (empty($data['product_coffee'][0]) || !is_array($data['product_coffee'][0]))) {
                $data['product_coffee'] = [$data['product_coffee']];
            }
            if (!empty($data['product_merchandise']) && is_array($data['product_merchandise']) && (empty($data['product_merchandise'][0]) || !is_array($data['product_merchandise'][0]))) {
                $data['product_merchandise'] = [$data['product_merchandise']];
            }

            // Determine associations to patch based on product_type
            $productType = $data['product_type'] ?? $product->product_type ?? null;
            $associated = ['ProductVariants'];
            if ($productType === 'coffee') {
                unset($data['product_merchandise']);
                $associated[] = 'ProductCoffee';
            } elseif ($productType === 'merchandise') {
                unset($data['product_coffee']);
                $associated[] = 'ProductMerchandise';
            } else {
                unset($data['product_coffee'], $data['product_merchandise']);
            }

            $product = $this->Products->patchEntity($product, $data, [
                'associated' => $associated,
            ]);

            if ($this->Products->save($product)) {
                // Handle image uploads
                if (!empty($uploadedFiles[0])) {
                    foreach ($uploadedFiles as $file) {
                        if ($file && $file->getError() === UPLOAD_ERR_OK) {
                            $originalName = preg_replace('/[^A-Za-z0-9._-]/', '_', $file->getClientFilename());
                            $extension = pathinfo($originalName, PATHINFO_EXTENSION);
                            $uniqueName = uniqid('img_', true) . '.' . strtolower($extension);
                            $file->moveTo(WWW_ROOT . 'img/products/' . $uniqueName);

                            $image = $this->Products->ProductImages->newEmptyEntity();
                            $image->product_id = $product->id;
                            $image->image_file = $uniqueName;
                            $this->Products->ProductImages->save($image);
                        }
                    }
                }

                $this->Flash->success(__('The product has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The product could not be saved. Please, try again.'));
        }
        $this->set(compact('product'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Product id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id);
        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
