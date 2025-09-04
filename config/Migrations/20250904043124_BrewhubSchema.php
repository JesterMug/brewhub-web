<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class BrewhubSchema extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     *
     * @return void
     */
    public function change(): void
    {
        // ---------------------
        // Users
        // ---------------------
        $this->table('users')
            ->addColumn('first_name', 'string', ['limit' => 63, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 63, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('password', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('user_type', 'enum', ['values' => ['customer', 'admin', 'superuser'], 'null' => false])
            ->addColumn('nonce', 'string', ['limit' => 255, 'null' => true, 'default' => null])
            ->addColumn('nonce_expiry', 'datetime', ['null' => true, 'default' => null])
            ->addColumn('date_created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('date_modified', 'datetime', ['null' => true, 'default' => null])
            ->addIndex(['email'], ['unique' => true])
            ->create();

        // ---------------------
        // Addresses
        // ---------------------
        $this->table('addresses')
            ->addColumn('label', 'string', ['limit' => 63, 'null' => true])
            ->addColumn('recipient_full_name', 'string', ['limit' => 127, 'null' => false])
            ->addColumn('recipient_phone', 'string', ['limit' => 23, 'null' => false])
            ->addColumn('property_type', 'enum', ['values' => ['house', 'apartment', 'business'], 'null' => false])
            ->addColumn('street', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('building', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('city', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('state', 'enum', ['values' => ['NS', 'NT', 'QL', 'SA', 'TS', 'VI', 'WA'], 'null' => false])
            ->addColumn('postcode', 'smallinteger', ['null' => false])
            ->addColumn('is_active', 'boolean', ['default' => true])
            ->addColumn('user_id', 'integer', ['null' => false])
            ->addIndex(['user_id'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Products
        // ---------------------
        $this->table('products')
            ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('category', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('description', 'text', ['null' => true])
            ->addColumn('date_created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('date_modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->create();

        // ---------------------
        // Product Images
        // ---------------------
        $this->table('product_images')
            ->addColumn('product_id', 'integer', ['null' => false])
            ->addColumn('image_file', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('date_created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['product_id'])
            ->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Product Coffee
        // ---------------------
        $this->table('product_coffee')
            ->addColumn('product_id', 'integer', ['null' => false])
            ->addColumn('roast_level', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('brew_type', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('bean_type', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('processing_method', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('caffeine_level', 'string', ['limit' => 50, 'null' => false])
            ->addColumn('origin_country', 'string', ['limit' => 100, 'null' => false])
            ->addColumn('certifications', 'string', ['limit' => 255, 'null' => false])
            ->addIndex(['product_id'])
            ->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Product Variants
        // ---------------------
        $this->table('product_variants')
            ->addColumn('product_id', 'integer', ['null' => false])
            ->addColumn('size', 'string', ['limit' => 16, 'null' => false])
            ->addColumn('price', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => false])
            ->addColumn('stock', 'integer', ['null' => false])
            ->addColumn('date_created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('date_modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addColumn('sku', 'string', ['limit' => 100, 'null' => false])
            ->addIndex(['product_id'])
            ->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Carts
        // ---------------------
        $this->table('carts')
            ->addColumn('user_id', 'integer', ['null' => false])
            ->addColumn('address_id', 'integer', ['null' => false])
            ->addColumn('status', 'enum', ['values' => ['active', 'ordered'], 'default' => 'active'])
            ->addColumn('date_created', 'datetime', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('date_modified', 'datetime', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['user_id'])
            ->addIndex(['address_id'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('address_id', 'addresses', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Cart Items
        // ---------------------
        $this->table('cart_items')
            ->addColumn('cart_id', 'integer', ['null' => false])
            ->addColumn('product_variant_id', 'integer', ['null' => false])
            ->addColumn('quantity', 'integer', ['default' => 1])
            ->addColumn('is_preorder', 'boolean', ['null' => false])
            ->addColumn('date_added', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('date_modified', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['cart_id'])
            ->addIndex(['product_variant_id'])
            ->addForeignKey('cart_id', 'carts', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('product_variant_id', 'product_variants', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Forms
        // ---------------------
        $this->table('forms')
            ->addColumn('first_name', 'string', ['limit' => 63, 'null' => false])
            ->addColumn('last_name', 'string', ['limit' => 63, 'null' => false])
            ->addColumn('email', 'string', ['limit' => 255, 'null' => false])
            ->addColumn('message', 'text', ['null' => false])
            ->addColumn('replied_status', 'boolean', ['default' => false])
            ->addColumn('date_created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('date_replied', 'timestamp', ['null' => true, 'default' => null])
            ->create();

        // ---------------------
        // Orders
        // ---------------------
        $this->table('orders')
            ->addColumn('user_id', 'integer', ['null' => false])
            ->addColumn('address_id', 'integer', ['null' => true])
            ->addColumn('order_date', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('shipping_status', 'enum', ['values' => ['pending', 'failed', 'shipped', 'completed', 'cancelled'], 'default' => 'pending'])
            ->addIndex(['user_id'])
            ->addIndex(['address_id'])
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->addForeignKey('address_id', 'addresses', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Order Product Variants
        // ---------------------
        $this->table('order_product_variants')
            ->addColumn('order_id', 'integer', ['null' => false])
            ->addColumn('product_variant_id', 'integer', ['null' => false])
            ->addColumn('quantity', 'integer', ['default' => 1])
            ->addColumn('is_preorder', 'boolean', ['default' => false])
            ->addIndex(['order_id'])
            ->addIndex(['product_variant_id'])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])
            ->addForeignKey('product_variant_id', 'product_variants', 'id', ['delete' => 'RESTRICT', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Inventory Transactions
        // ---------------------
        $this->table('inventory_transactions')
            ->addColumn('product_variant_id', 'integer', ['null' => false])
            ->addColumn('change_type', 'enum', ['values' => ['purchase', 'return', 'adjustment'], 'null' => false])
            ->addColumn('quantity_change', 'integer', ['null' => false])
            ->addColumn('note', 'string', ['limit' => 255, 'null' => true])
            ->addColumn('created_by', 'string', ['limit' => 50, 'default' => ''])
            ->addColumn('date_created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addIndex(['product_variant_id'])
            ->addForeignKey('product_variant_id', 'product_variants', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Invoices
        // ---------------------
        $this->table('invoices')
            ->addColumn('order_id', 'integer', ['null' => false])
            ->addColumn('payment_method', 'string', ['limit' => 63, 'null' => false])
            ->addColumn('transaction_number', 'string', ['limit' => 63, 'null' => false])
            ->addColumn('paid_amount', 'decimal', ['precision' => 10, 'scale' => 2, 'null' => false])
            ->addIndex(['order_id'])
            ->addForeignKey('order_id', 'orders', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        // ---------------------
        // Product Merchandise
        // ---------------------
        $this->table('product_merchandise')
            ->addColumn('product_id', 'integer', ['null' => false])
            ->addColumn('material', 'string', ['limit' => 100, 'null' => true])
            ->addIndex(['product_id'])
            ->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'RESTRICT'])
            ->create();

        $this->execute("
                    DELIMITER $$
                    CREATE TRIGGER trg_carts_convert AFTER UPDATE ON carts FOR EACH ROW
                    BEGIN
                        DECLARE new_order_id INT;
                        IF NEW.status = 'ordered' AND OLD.status = 'active' THEN
                            INSERT INTO orders (user_id, status, address_id, order_date)
                            VALUES (NEW.user_id, 'pending', NEW.address_id, NOW());
                            SET new_order_id = LAST_INSERT_ID();

                            INSERT INTO order_product_variants (order_id, product_variant_id, quantity, is_preorder)
                            SELECT new_order_id, product_variant_id, quantity, is_preorder
                            FROM cart_items
                            WHERE cart_id = NEW.id;
                        END IF;
                    END$$
                    DELIMITER ;
                ");

        // Trigger: Cart items check stock before insert
        $this->execute("
                    DELIMITER $$
                    CREATE TRIGGER trg_cart_items_check_stock BEFORE INSERT ON cart_items FOR EACH ROW
                    BEGIN
                        DECLARE current_stock INT;
                        SELECT stock INTO current_stock FROM product_variants WHERE id = NEW.product_variant_id;
                        IF NEW.quantity > current_stock THEN
                            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Not enough stock available for this product variant';
                        END IF;
                    END$$
                    DELIMITER ;
                ");

        // Trigger: Cart items check stock before update
        $this->execute("
                    DELIMITER $$
                    CREATE TRIGGER trg_cart_items_update_stock_check BEFORE UPDATE ON cart_items FOR EACH ROW
                    BEGIN
                        DECLARE current_stock INT;
                        SELECT stock INTO current_stock FROM product_variants WHERE id = NEW.product_variant_id;
                        IF NEW.quantity > current_stock THEN
                            SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Not enough stock available to increase cart quantity';
                        END IF;
                    END$$
                    DELIMITER ;
                ");
    }
}
