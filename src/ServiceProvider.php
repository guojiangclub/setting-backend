<?php

/*
 * This file is part of ibrand/setting-backend.
 *
 * (c) iBrand <https://www.ibrand.cc>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace iBrand\Setting\Backend;

/**
 * Class ServiceProvider
 * @package iBrand\Setting\Backend
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot()
    {
        Setting::boot();
    }
}
