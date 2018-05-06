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

use Encore\Admin\Admin;
use Encore\Admin\Extension;

/**
 * Class Setting
 * @package iBrand\Setting\Backend
 */
class Setting extends Extension
{
    /**
     * Bootstrap this package.
     */
    public static function boot()
    {
        static::registerRoutes();

        Admin::extend('ibrand-setting', __CLASS__);
    }

    /**
     * Register routes for laravel-admin.
     */
    protected static function registerRoutes()
    {
        parent::routes(function ($router) {
            /* @var \Illuminate\Routing\Router $router */
            $router->resource(
                config('admin.extensions.setting.name', 'setting'),
                config('admin.extensions.setting.controller', SettingController::class)
            );
        });
    }

    /**
     * {@inheritdoc}
     */
    public static function import()
    {
        parent::createMenu('Setting', 'setting', 'fa-toggle-on', 1);
        parent::createPermission('System Setting', 'ext.setting', 'setting*');
    }
}
