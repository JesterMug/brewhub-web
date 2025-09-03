<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductCoffeeTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductCoffeeTable Test Case
 */
class ProductCoffeeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductCoffeeTable
     */
    protected $ProductCoffee;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ProductCoffee',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ProductCoffee') ? [] : ['className' => ProductCoffeeTable::class];
        $this->ProductCoffee = $this->getTableLocator()->get('ProductCoffee', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductCoffee);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProductCoffeeTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ProductCoffeeTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
