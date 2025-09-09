<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class Initial extends BaseMigration
{
    /**
     * Up Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-up-method
     *
     * @return void
     */
    public function up(): void
    {
        $this->table('addresses')
            ->addColumn('label', 'string', [
                'default' => null,
                'limit' => 63,
                'null' => true,
            ])
            ->addColumn('recipient_full_name', 'string', [
                'default' => null,
                'limit' => 127,
                'null' => false,
            ])
            ->addColumn('recipient_phone', 'string', [
                'default' => null,
                'limit' => 23,
                'null' => false,
            ])
            ->addColumn('property_type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('street', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('building', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addColumn('city', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('state', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('postcode', 'smallinteger', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('is_active', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addIndex(
                $this->index('user_id')
                    ->setName('user_id')
            )
            ->create();

        $this->table('cart_items')
            ->addColumn('cart_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('product_variant_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('quantity', 'integer', [
                'default' => '1',
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('is_preorder', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_added', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                $this->index('cart_id')
                    ->setName('fk_carts_cart_items')
            )
            ->addIndex(
                $this->index('product_variant_id')
                    ->setName('fk_variants_cart_items')
            )
            ->create();

        $this->table('carts')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('address_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('status', 'string', [
                'default' => 'active',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                $this->index('user_id')
                    ->setName('fk_users_carts')
            )
            ->addIndex(
                $this->index('address_id')
                    ->setName('fk_addresses_carts')
            )
            ->create();

        $this->table('content_blocks')
            ->addColumn('parent', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('slug', 'string', [
                'default' => null,
                'limit' => 128,
                'null' => false,
            ])
            ->addColumn('label', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('type', 'string', [
                'default' => null,
                'limit' => 32,
                'null' => false,
            ])
            ->addColumn('value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('previous_value', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('forms')
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 63,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 63,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('message', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('replied_status', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_replied', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('inventory_transactions')
            ->addColumn('product_variant_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('change_type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('quantity_change', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('note', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created_by', 'string', [
                'default' => '',
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('date_created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                $this->index('product_variant_id')
                    ->setName('fk_product_variant_inventory_transactions')
            )
            ->create();

        $this->table('invoices')
            ->addColumn('order_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('payment_method', 'string', [
                'default' => null,
                'limit' => 63,
                'null' => false,
            ])
            ->addColumn('transaction_number', 'string', [
                'default' => null,
                'limit' => 63,
                'null' => false,
            ])
            ->addColumn('paid_amount', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addIndex(
                $this->index('order_id')
                    ->setName('fk_orders_invoices')
            )
            ->create();

        $this->table('order_product_variants')
            ->addColumn('order_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('product_variant_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('quantity', 'integer', [
                'default' => '1',
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('is_preorder', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                $this->index('order_id')
                    ->setName('fk_orders_order_product_variants')
            )
            ->addIndex(
                $this->index('product_variant_id')
                    ->setName('fk_product_variants_order_product_variants')
            )
            ->create();

        $this->table('orders')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('address_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => true,
                'signed' => true,
            ])
            ->addColumn('order_date', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('shipping_status', 'string', [
                'default' => 'pending',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                $this->index('user_id')
                    ->setName('fk_users_orders')
            )
            ->addIndex(
                $this->index('address_id')
                    ->setName('fk_addresses_orders')
            )
            ->create();

        $this->table('product_coffee')
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('roast_level', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('brew_type', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('bean_type', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('processing_method', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('caffeine_level', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('origin_country', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('certifications', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addIndex(
                $this->index('product_id')
                    ->setName('fk_product_coffee_products')
            )
            ->create();

        $this->table('product_images')
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('image_file', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('date_created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                $this->index('product_id')
                    ->setName('fk_images_products')
            )
            ->create();

        $this->table('product_merchandise')
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('material', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => true,
            ])
            ->addIndex(
                $this->index('product_id')
                    ->setName('fk_product_merchandise_products')
            )
            ->create();

        $this->table('product_variants')
            ->addColumn('product_id', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('size', 'string', [
                'default' => null,
                'limit' => 16,
                'null' => false,
            ])
            ->addColumn('price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 10,
                'scale' => 2,
                'signed' => true,
            ])
            ->addColumn('stock', 'integer', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => true,
            ])
            ->addColumn('date_created', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_modified', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('sku', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addIndex(
                $this->index('product_id')
                    ->setName('fk_products_product_variants')
            )
            ->create();

        $this->table('products')
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('category', 'string', [
                'default' => null,
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('date_created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->create();

        $this->table('users')
            ->addColumn('first_name', 'string', [
                'default' => null,
                'limit' => 63,
                'null' => false,
            ])
            ->addColumn('last_name', 'string', [
                'default' => null,
                'limit' => 63,
                'null' => false,
            ])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('user_type', 'string', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('nonce', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('nonce_expiry', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('date_created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('date_modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                $this->index('email')
                    ->setName('email')
                    ->setType('unique')
            )
            ->create();

        $this->table('addresses')
            ->addForeignKey(
                $this->foreignKey('user_id')
                    ->setReferencedTable('users')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_users_addresses')
            )
            ->update();

        $this->table('cart_items')
            ->addForeignKey(
                $this->foreignKey('cart_id')
                    ->setReferencedTable('carts')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_carts_cart_items')
            )
            ->addForeignKey(
                $this->foreignKey('product_variant_id')
                    ->setReferencedTable('product_variants')
                    ->setReferencedColumns('id')
                    ->setOnDelete('RESTRICT')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_variants_cart_items')
            )
            ->update();

        $this->table('carts')
            ->addForeignKey(
                $this->foreignKey('address_id')
                    ->setReferencedTable('addresses')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_addresses_carts')
            )
            ->addForeignKey(
                $this->foreignKey('user_id')
                    ->setReferencedTable('users')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_users_carts')
            )
            ->update();

        $this->table('inventory_transactions')
            ->addForeignKey(
                $this->foreignKey('product_variant_id')
                    ->setReferencedTable('product_variants')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_product_variant_inventory_transactions')
            )
            ->update();

        $this->table('invoices')
            ->addForeignKey(
                $this->foreignKey('order_id')
                    ->setReferencedTable('orders')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_orders_invoices')
            )
            ->update();

        $this->table('order_product_variants')
            ->addForeignKey(
                $this->foreignKey('order_id')
                    ->setReferencedTable('orders')
                    ->setReferencedColumns('id')
                    ->setOnDelete('RESTRICT')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_orders_order_product_variants')
            )
            ->addForeignKey(
                $this->foreignKey('product_variant_id')
                    ->setReferencedTable('product_variants')
                    ->setReferencedColumns('id')
                    ->setOnDelete('RESTRICT')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_product_variants_order_product_variants')
            )
            ->update();

        $this->table('orders')
            ->addForeignKey(
                $this->foreignKey('address_id')
                    ->setReferencedTable('addresses')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_addresses_orders')
            )
            ->addForeignKey(
                $this->foreignKey('user_id')
                    ->setReferencedTable('users')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_users_orders')
            )
            ->update();

        $this->table('product_coffee')
            ->addForeignKey(
                $this->foreignKey('product_id')
                    ->setReferencedTable('products')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_product_coffee_products')
            )
            ->update();

        $this->table('product_images')
            ->addForeignKey(
                $this->foreignKey('product_id')
                    ->setReferencedTable('products')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_images_products')
            )
            ->update();

        $this->table('product_merchandise')
            ->addForeignKey(
                $this->foreignKey('product_id')
                    ->setReferencedTable('products')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_product_merchandise_products')
            )
            ->update();

        $this->table('product_variants')
            ->addForeignKey(
                $this->foreignKey('product_id')
                    ->setReferencedTable('products')
                    ->setReferencedColumns('id')
                    ->setOnDelete('CASCADE')
                    ->setOnUpdate('RESTRICT')
                    ->setName('fk_products_product_variants')
            )
            ->update();
    }

    /**
     * Down Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-down-method
     *
     * @return void
     */
    public function down(): void
    {
        $this->table('addresses')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('cart_items')
            ->dropForeignKey(
                'cart_id'
            )
            ->dropForeignKey(
                'product_variant_id'
            )->save();

        $this->table('carts')
            ->dropForeignKey(
                'address_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('inventory_transactions')
            ->dropForeignKey(
                'product_variant_id'
            )->save();

        $this->table('invoices')
            ->dropForeignKey(
                'order_id'
            )->save();

        $this->table('order_product_variants')
            ->dropForeignKey(
                'order_id'
            )
            ->dropForeignKey(
                'product_variant_id'
            )->save();

        $this->table('orders')
            ->dropForeignKey(
                'address_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('product_coffee')
            ->dropForeignKey(
                'product_id'
            )->save();

        $this->table('product_images')
            ->dropForeignKey(
                'product_id'
            )->save();

        $this->table('product_merchandise')
            ->dropForeignKey(
                'product_id'
            )->save();

        $this->table('product_variants')
            ->dropForeignKey(
                'product_id'
            )->save();

        $this->table('addresses')->drop()->save();
        $this->table('cart_items')->drop()->save();
        $this->table('carts')->drop()->save();
        $this->table('content_blocks')->drop()->save();
        $this->table('forms')->drop()->save();
        $this->table('inventory_transactions')->drop()->save();
        $this->table('invoices')->drop()->save();
        $this->table('order_product_variants')->drop()->save();
        $this->table('orders')->drop()->save();
        $this->table('product_coffee')->drop()->save();
        $this->table('product_images')->drop()->save();
        $this->table('product_merchandise')->drop()->save();
        $this->table('product_variants')->drop()->save();
        $this->table('products')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
