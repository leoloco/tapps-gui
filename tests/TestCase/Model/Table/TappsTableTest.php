<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\TappsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\TappsTable Test Case
 */
class TappsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\TappsTable
     */
    public $Tapps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.tapps',
        'app.users',
        'app.ownerships',
        'app.devices'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('Tapps') ? [] : ['className' => 'App\Model\Table\TappsTable'];
        $this->Tapps = TableRegistry::get('Tapps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Tapps);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test isOwnedBy method
     *
     * @return void
     */
    public function testIsOwnedBy()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
