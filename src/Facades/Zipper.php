<?php

namespace Gnarhard\Zipper\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see Gnarhard\Zipper\Zipper
 */
class Zipper extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'zipper';
    }
}
