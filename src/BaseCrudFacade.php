<?php

namespace TWGroupCL\BaseCrud;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Twgroupcl\BaseCrud\Skeleton\SkeletonClass
 */
class BaseCrudFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'basecrud';
    }
}
