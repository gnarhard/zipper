<?php

namespace Gnarhard\Zipper\Tests;

use Orchestra\Testbench\TestCase as Orchestra;
use Gnarhard\Zipper\ZipperServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            ZipperServiceProvider::class,
        ];
    }
}