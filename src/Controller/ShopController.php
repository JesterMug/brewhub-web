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
                return $q->orderAsc('ProductImages.id'); // first image first
            }, 'ProductVariants']
        ]);

        $this->set(compact('products'));
        $this->viewBuilder()->setLayout('default'); // your user-facing layout
    }

    // Product details
    public function view($id = null)
    {
        if (!$id) {
            throw new NotFoundException('Product ID missing.');
        }

        $productsTable = TableRegistry::getTableLocator()->get('Products');
        $product = $productsTable->get($id, [
            'contain' => ['ProductImages', 'ProductVariants'],
        ]);

        $this->set(compact('product'));
        $this->viewBuilder()->setLayout('default'); // or 'shop' layout
    }
}
