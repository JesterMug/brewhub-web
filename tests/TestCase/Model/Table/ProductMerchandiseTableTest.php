<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ProductMerchandiseTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ProductMerchandiseTable Test Case
 */
class ProductMerchandiseTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ProductMerchandiseTable
     */
    protected $ProductMerchandise;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.ProductMerchandise',
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
        $config = $this->getTableLocator()->exists('ProductMerchandise') ? [] : ['className' => ProductMerchandiseTable::class];
        $this->ProductMerchandise = $this->getTableLocator()->get('ProductMerchandise', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ProductMerchandise);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\ProductMerchandiseTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\ProductMerchandiseTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
