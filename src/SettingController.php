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

use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use iBrand\Component\Setting\Models\SystemSetting;

/**
 * Class SettingController
 * @package iBrand\Setting\Backend
 */
class SettingController
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {
            $content->header('Setting');
            $content->description('Setting list..');
            $content->body($this->grid());
        });
    }

    /**
     * @return Grid
     */
    public function grid()
    {
        return Admin::grid(SystemSetting::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->key()->display(function ($key) {
                return "<a tabindex=\"0\" class=\"btn btn-xs btn-twitter\" role=\"button\"
 data-toggle=\"popover\" data-html=true title=\"Usage\" data-content=\"<code>settings('$key');</code>\">$key</a>";
            });
            $grid->value();
            $grid->created_at();
            $grid->updated_at();
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->like('key');
                $filter->like('value');
            });
        });
    }

    /**
     * Edit interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header('header');
            $content->description('description');
            $content->body($this->form()->edit($id));
        });
    }

    /**
     * @return Form
     */
    public function form()
    {
        return Admin::form(SystemSetting::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->text('key')->rules('required');
            $form->textarea('value')->rules('required');
            $form->display('created_at');
            $form->display('updated_at');
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {
            $content->header('header');
            $content->description('description');
            $content->body($this->form());
        });
    }
}
