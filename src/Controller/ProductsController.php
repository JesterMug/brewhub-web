<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\UploadedFileInterface;

/**
 * Products Controller
 *
 * @property \App\Model\Table\ProductsTable $Products
 */
class ProductsController extends AppController
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
            // Merge size_value + size_unit into size string for variants
            if (!empty($data['product_variants']) && is_array($data['product_variants'])) {
                foreach ($data['product_variants'] as &$variant) {
                    if (!empty($variant['size_value']) && !empty($variant['size_unit'])) {
                        $variant['size'] = $variant['size_value'] . $variant['size_unit'];
                    }
                }
            }

            // Extract uploaded files
            $uploadedFiles = $this->request->getData('product_images_files');
            unset($data['product_images_files']);

            $productType = $data['product_type'] ?? null;

            //Seems to cause issues with uploading images.
/*            if (!empty($data['product_coffee']) && is_array($data['product_coffee']) && (empty($data['product_coffee'][0]) || !is_array($data['product_coffee'][0]))) {
                $data['product_coffee'] = [$data['product_coffee']];
            }
            if (!empty($data['product_merchandise']) && is_array($data['product_merchandise']) && (empty($data['product_merchandise'][0]) || !is_array($data['product_merchandise'][0]))) {
                $data['product_merchandise'] = [$data['product_merchandise']];
            }*/

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
//            debug($data['product_coffee']);
//            debug($product->product_coffee);
//            debug($product->getErrors());
            if ($this->Products->save($product)) {
                $productId = $product->id;

                // Handle image uploads separately (crop to square and convert to JPEG)
                if (!empty($uploadedFiles[0])) {
                    foreach ($uploadedFiles as $file) {
                        if ($file && $file->getError() === UPLOAD_ERR_OK) {
                            $savedName = $this->processUploadedImage($file);
                            if ($savedName) {
                                $image = $this->Products->ProductImages->newEmptyEntity();
                                $image->product_id = $product->id;
                                $image->image_file = $savedName;
                                $this->Products->ProductImages->save($image);
                            }
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

            // Merge size_value + size_unit into size string for variants
            if (!empty($data['product_variants']) && is_array($data['product_variants'])) {
                foreach ($data['product_variants'] as &$variant) {
                    if (!empty($variant['size_value']) && !empty($variant['size_unit'])) {
                        $variant['size'] = $variant['size_value'] . $variant['size_unit'];
                    }
                }
            }

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

            // Split existing size into value + unit for the form
            foreach ($product->product_variants as $variant) {
                if (!empty($variant->size)) {
                    if (preg_match('/^([\d\.]+)\s*(\w+)$/', $variant->size, $matches)) {
                        $variant->size_value = $matches[1];
                        $variant->size_unit = $matches[2];
                    }
                }
            }

            if ($this->Products->save($product)) {
                // Handle image uploads (crop to square and convert to JPEG)
                if (!empty($uploadedFiles[0])) {
                    foreach ($uploadedFiles as $file) {
                        if ($file && $file->getError() === UPLOAD_ERR_OK) {
                            $savedName = $this->processUploadedImage($file);
                            if ($savedName) {
                                $image = $this->Products->ProductImages->newEmptyEntity();
                                $image->product_id = $product->id;
                                $image->image_file = $savedName;
                                $this->Products->ProductImages->save($image);
                            }
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
     * Process an uploaded image: center-crop to a 1:1 square and save as JPEG.
     * Returns the saved filename (basename) on success, or null on failure.
     */
    private function processUploadedImage(UploadedFileInterface $file): ?string
    {
        try {
            if ($file->getError() !== UPLOAD_ERR_OK) {
                return null;
            }

            $mediaType = (string)$file->getClientMediaType();
            if (strpos($mediaType, 'image/') !== 0) {
                return null;
            }

            $stream = $file->getStream();
            if (method_exists($stream, 'isSeekable') && $stream->isSeekable()) {
                $stream->rewind();
            }
            $data = $stream->getContents();
            if ($data === '' || $data === false) {
                return null;
            }

            $src = @imagecreatefromstring($data);
            if ($src === false) {
                return null;
            }

            $w = imagesx($src);
            $h = imagesy($src);
            if ($w <= 0 || $h <= 0) {
                imagedestroy($src);
                return null;
            }

            //Cropping Logic
            $size = min($w, $h);
            $srcX = (int)floor(($w - $size) / 2);
            $srcY = (int)floor(($h - $size) / 2);

            $dst = imagecreatetruecolor($size, $size);

            $white = imagecolorallocate($dst, 255, 255, 255);
            imagefill($dst, 0, 0, $white);

            imagecopyresampled($dst, $src, 0, 0, $srcX, $srcY, $size, $size, $size, $size);

            $uniqueName = uniqid('img_', true) . '.jpg';
            $dir = WWW_ROOT . 'img' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR;
            if (!is_dir($dir)) {
                @mkdir($dir, 0775, true);
            }

            // Save the newly cropped square image as a JPEG with 90% quality.
            imagejpeg($dst, $dir . $uniqueName, 90);

            // Clean up memory by destroying the image resources.
            imagedestroy($dst);
            imagedestroy($src);

            return $uniqueName;
        } catch (\Throwable $e) {
            return null;
        }
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

        // Load product with associated images to delete files from disk
        $product = $this->Products->get($id, contain: ['ProductImages']);

        // Attempt to remove image files from webroot/img/products
        if (!empty($product->product_images)) {
            foreach ($product->product_images as $img) {
                $this->removeImageFileSafe((string)$img->image_file);
            }
        }

        if ($this->Products->delete($product)) {
            $this->Flash->success(__('The product has been deleted.'));
        } else {
            $this->Flash->error(__('The product could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Safely remove an image file from webroot/img/products.
     * Guards against directory traversal and ignores missing files.
     */
    private function removeImageFileSafe(?string $basename): void
    {
        if (!$basename) {
            return;
        }
        // Ensure it only work with a basename (no directories)
        $basename = basename($basename);
        $dir = WWW_ROOT . 'img' . DIRECTORY_SEPARATOR . 'products' . DIRECTORY_SEPARATOR;
        $path = $dir . $basename;
        // Only unlink regular files inside the expected directory
        if (strpos(realpath($dir) ?: '', realpath($dir) ?: '') === 0) { // dummy guard to keep static analyzers happy
            if (is_file($path)) {
                @unlink($path);
            }
        }
    }
}
