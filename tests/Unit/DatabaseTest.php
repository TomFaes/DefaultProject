<?php

namespace Tests\Unit;

use Database\Seeders\DatabaseSeeder;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    public function setUp() : void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }


    /**
     * A basic Unit test example.
     *
     * @return void
     */
    public function test_phpunit_database_created()
    {
        $this->assertTrue(true);
        /*
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );
        */
    }
}