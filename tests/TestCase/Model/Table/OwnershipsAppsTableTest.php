<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\OwnershipsAppsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\OwnershipsAppsTable Test Case
 */
class OwnershipsAppsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\OwnershipsAppsTable
     */
    public $OwnershipsApps;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ownerships_apps',
        'app.users',
        'app.ownerships',
        'app.devices',
        'app.tapps'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::exists('OwnershipsApps') ? [] : ['className' => 'App\Model\Table\OwnershipsAppsTable'];
        $this->OwnershipsApps = TableRegistry::get('OwnershipsApps', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->OwnershipsApps);

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
}
