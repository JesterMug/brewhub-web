<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
use Cake\Http\Exception\NotFoundException;

class ShopController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Allow unauthenticated access to shop listing and product view
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
    }

    public function index()
    {
        $productsTable = TableRegistry::getTableLocator()->get('Products');
        $products = $productsTable->find('all', [
            'contain' => ['ProductImages' => function($q) {
                return $q->orderByAsc('ProductImages.id'); // first image first
            }, 'ProductVariants']
        ]);

        // Segmented type filter (default to coffee)
        $type = (string)$this->request->getQuery('type');
        if (!in_array($type, ['coffee', 'merch'], true)) {
            $type = 'coffee';
        }
        if ($type === 'coffee') {
            $products->innerJoinWith('ProductCoffee');
        } else {
            $products->innerJoinWith('ProductMerchandise');
        }

        // Apply search filter if provided
        $q = trim((string)$this->request->getQuery('q'));
        if ($q !== '') {
            $products->where([
                'OR' => [
                    'Products.name LIKE' => "%$q%",
                    'Products.description LIKE' => "%$q%",
                    'Products.category LIKE' => "%$q%",
                ]
            ]);
        }

        $this->set(compact('products', 'q', 'type'));
        $this->viewBuilder()->setLayout('default'); // your user-facing layout
    }

    // Product details
    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException('Product ID missing.');
        }

        $productsTable = TableRegistry::getTableLocator()->get('Products');
        $product = $productsTable->get($id, finder: [
            'contain' => ['ProductImages', 'ProductVariants'],
        ]);

        $this->set(compact('product'));
        $this->viewBuilder()->setLayout('default'); // or 'shop' layout
    }
}
