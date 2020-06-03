<?php

namespace TWGroupCL\Basecrud\Tests;

use Orchestra\Testbench\TestCase;
use TWGroupCL\BaseCrud\BaseCrud;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [BaseCrud::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
