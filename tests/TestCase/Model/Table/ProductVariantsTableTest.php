<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductVariantsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductVariantsTable Test Case
 */
class ProductVariantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductVariantsTable
     */
    protected $ProductVariants;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ProductVariants',
        'app.Products',
        'app.CartItems',
        'app.InventoryTransactions',
        'app.OrderProductVariants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductVariants') ? [] : ['className' => ProductVariantsTable::class];
        $this->ProductVariants = $this->getTableLocator()->get('ProductVariants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductVariants);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProductVariantsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ProductVariantsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
