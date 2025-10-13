<?php
declare(strict_types=1);

namespace App\Controller;

use Psr\Http\Message\UploadedFileInterface;
use Throwable;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $query = $this->Products->find('withStock');
        $products = $this->paginate($query);

        // Default low stock threshold = 50
        $threshold = (int)$this->request->getQuery('threshold', 50);

        $this->set(compact('products', 'threshold'));
    }

    /**
     * Generate Stock Report (PDF)
     */
    public function report()
    {
        $threshold = 50;

        $products = $this->Products
            ->find('withStock')
            ->contain(['ProductVariants' => function ($q) {
                return $q->select(['id', 'product_id', 'size', 'stock', 'price', 'sku'])
                    ->orderAsc('size');
            }])
            ->orderAsc('Products.name')
            ->all();

        // Disable layout to prevent the error
        $this->viewBuilder()->disableAutoLayout();
        $this->set(compact('products', 'threshold'));

        // Render HTML for PDF
        $response = $this->render('report');
        $html = (string)$response->getBody();

        // Setup Dompdf
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = 'stock-report-' . date('Ymd-His') . '.pdf';

        // Return as downloadable PDF
        return $this->response
            ->withType('application/pdf')
            ->withStringBody($dompdf->output())
            ->withDownload($filename);
    }

    /**
     * View method
     */
    public function view(?string $id = null)
    {
        $product = $this->Products->get($id, contain: ['ProductCoffee', 'ProductImages', 'ProductMerchandise', 'ProductVariants']);
        $this->set(compact('product'));
    }

    /**
     * Add method
     */
    public function add()
    {
        $product = $this->Products->newEmptyEntity();

        if ($this->request->is('post')) {
            $data = $this->request->getData();

            if (!empty($data['product_variants']) && is_array($data['product_variants'])) {
                foreach ($data['product_variants'] as &$variant) {
                    if (!empty($variant['size_value']) && !empty($variant['size_unit'])) {
                        $variant['size'] = $variant['size_value'] . $variant['size_unit'];
                    }
                }
            }

            $uploadedFiles = $this->request->getData('product_images_files');
            unset($data['product_images_files']);

            $productType = $data['product_type'] ?? null;
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
     * Feature method
     */
    public function feature(?string $id = null)
    {
        $this->request->allowMethod(['post', 'feature']);

        $this->Products->updateAll(['is_featured' => 0], []);

        $product = $this->Products->get($id);
        $product->is_featured = 1;

        if ($this->Products->save($product)) {
            $this->Flash->success(__('{0} is featured now', $product->name));
        } else {
            $this->Flash->error(__('{0} could not be featured.', $product->name));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Edit method
     */
    public function edit(?string $id = null)
    {
        $product = $this->Products->get($id, contain: ['ProductCoffee', 'ProductImages', 'ProductMerchandise', 'ProductVariants']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $data = $this->request->getData();

            if (!empty($data['product_variants'])) {
                foreach ($data['product_variants'] as &$variant) {
                    if (!empty($variant['size_value']) && !empty($variant['size_unit'])) {
                        $variant['size'] = $variant['size_value'] . $variant['size_unit'];
                    }
                }
            }

            $uploadedFiles = $this->request->getData('product_images_files');
            unset($data['product_images_files']);

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
     * Process image upload
     */
    private function processUploadedImage(UploadedFileInterface $file): ?string
    {
        try {
            if ($file->getError() !== UPLOAD_ERR_OK) {
                return null;
            }

            $mediaType = (string)$file->getClientMediaType();
            if (!str_starts_with($mediaType, 'image/')) {
                return null;
            }

            $stream = $file->getStream();
            if ($stream->isSeekable()) {
                $stream->rewind();
            }
            $data = $stream->getContents();
            $src = @imagecreatefromstring($data);
            if (!$src) {
                return null;
            }

            $w = imagesx($src);
            $h = imagesy($src);
            $size = min($w, $h);
            $dst = imagecreatetruecolor($size, $size);
            $white = imagecolorallocate($dst, 255, 255, 255);
            imagefill($dst, 0, 0, $white);
            imagecopyresampled($dst, $src, 0, 0, ($w - $size) / 2, ($h - $size) / 2, $size, $size, $size, $size);

            $uniqueName = uniqid('img_', true) . '.jpg';
            $dir = WWW_ROOT . 'img/products/';
            if (!is_dir($dir)) {
                mkdir($dir, 0775, true);
            }

            imagejpeg($dst, $dir . $uniqueName, 90);
            imagedestroy($dst);
            imagedestroy($src);

            return $uniqueName;
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * Delete method
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $product = $this->Products->get($id, contain: ['ProductImages']);

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




    private function removeImageFileSafe(?string $basename): void
    {
        if (!$basename) return;
        $basename = basename($basename);
        $dir = WWW_ROOT . 'img/products/';
        $path = $dir . $basename;
        if (is_file($path)) {
            @unlink($path);
        }
    }
}
