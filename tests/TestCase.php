<?php

namespace Cdebattista\LaravelPermission\Tests;

use Cdebattista\LaravelPermission\LaravelPermissionServiceProvider;

class TestCase extends \Orchestra\Testbench\TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelPermissionServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {

    }
}
