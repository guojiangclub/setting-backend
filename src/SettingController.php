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
     * show interface.
     *
     * @param $id
     *
     * @return Content
     */
    public function show($id)
    {
        return redirect()->route('setting.edit', ['id' => $id]);
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
            $settings = SystemSetting::find($id);
            $content->body($this->form($settings)->edit($id));
        });
    }

    /**
     * @return Form
     */
    public function form($settings = null)
    {
        return Admin::form(SystemSetting::class, function (Form $form) use ($settings) {

            $type = request()->input('type') ? request()->input('type') : 0;
            $value_edit = request()->input('value_edit') ? request()->input('value_edit') : '';
            $value = request()->input('value') ? request()->input('value') : '';
            $form->ignore(['type', 'value_edit']);
            $form->display('id', 'ID');
            $form->text('key')->rules('required');

            if (!$settings) {
                $form->textarea('value')->rules('required');

            } else {
                $value_old = $settings->value;

                if (is_array($settings->value)) {
                    $type = 1;
                    $value_old = json_encode($value_old, true);
                }

                $form->textarea('value_edit', 'Value')->rules('required')->value($value_old);
            }

            $input_value = $value_edit ? $value_edit : $value;

            $form->radio('type', 'Type')
                ->options(['1' => 'array', '0' => 'string'])->default($type);

            $form->display('created_at');
            $form->display('updated_at');

            $form->saved(function (Form $form) use ($input_value) {
                $key = $form->input('key');
                if (request()->input('type') == 1) {
                    $input_value = json_decode($input_value, true);
                }

                settings([$key => $input_value]);
            });

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
