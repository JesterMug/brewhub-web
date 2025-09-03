<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OrderProductVariantsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OrderProductVariantsTable Test Case
 */
class OrderProductVariantsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\OrderProductVariantsTable
     */
    protected $OrderProductVariants;

    /**
     * Fixtures
     *
     * @var list<string>
     */
    protected array $fixtures = [
        'app.OrderProductVariants',
        'app.Orders',
        'app.ProductVariants',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('OrderProductVariants') ? [] : ['className' => OrderProductVariantsTable::class];
        $this->OrderProductVariants = $this->getTableLocator()->get('OrderProductVariants', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->OrderProductVariants);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @link \App\Model\Table\OrderProductVariantsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @link \App\Model\Table\OrderProductVariantsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
