<?php

namespace Sirius\Builder\Controllers;

use Sirius\Builder\Auth\Database\Permission;
use Sirius\Builder\Facades\Admin;
use Sirius\Builder\Form;
use Sirius\Builder\Grid;
use Sirius\Builder\Layout\Content;
use Illuminate\Routing\Controller;
use Sirius\Support\Str;

class PermissionController extends Controller
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
            $content->header(lang('admin.permissions'));
            $content->description(lang('admin.list'));
            $content->body($this->grid()->render());
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
            $content->header(lang('admin.permissions'));
            $content->description(lang('admin.edit'));
            $content->body($this->form()->edit($id));
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
            $content->header(lang('admin.permissions'));
            $content->description(lang('admin.create'));
            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Permission::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->slug(lang('admin.slug'));
            $grid->name(lang('admin.name'));

            $grid->http_path(lang('admin.route'))->display(function ($path) {
                return collect(explode("\r\n", $path))->map(function ($path) {
                    $method = $this->http_method ?: ['ANY'];

                    if (Str::contains($path, ':')) {
                        list($method, $path) = explode(':', $path);
                        $method = explode(',', $method);
                    }

                    $method = collect($method)->map(function ($name) {
                        return strtoupper($name);
                    })->map(function ($name) {
                        return "<span class='label label-primary'>{$name}</span>";
                    })->implode('&nbsp;');

                    $path = '/'.trim(config('admin.route.prefix'), '/').$path;

                    return "<div style='margin-bottom: 5px;'>$method<code>$path</code></div>";
                })->implode('');
            });

            $grid->created_at(lang('admin.created_at'));
            $grid->updated_at(lang('admin.updated_at'));

            $grid->tools(function (Grid\Tools $tools) {
                $tools->batch(function (Grid\Tools\BatchActions $actions) {
                    $actions->disableDelete();
                });
            });
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Admin::form(Permission::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('slug', lang('admin.slug'))->rules('required');
            $form->text('name', lang('admin.name'))->rules('required');

            $form->multipleSelect('http_method', lang('admin.http.method'))
                ->options($this->getHttpMethodsOptions())
                ->help(lang('admin.all_methods_if_empty'));
            $form->textarea('http_path', lang('admin.http.path'));

            $form->display('created_at', lang('admin.created_at'));
            $form->display('updated_at', lang('admin.updated_at'));
        });
    }

    /**
     * Get options of HTTP methods select field.
     *
     * @return array
     */
    protected function getHttpMethodsOptions()
    {
        return array_combine(Permission::$httpMethods, Permission::$httpMethods);
    }
}
