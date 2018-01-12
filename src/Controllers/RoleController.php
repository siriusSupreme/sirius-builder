<?php

namespace Sirius\Builder\Controllers;

use Sirius\Builder\Auth\Database\Permission;
use Sirius\Builder\Auth\Database\Role;
use Sirius\Builder\Facades\Admin;
use Sirius\Builder\Form;
use Sirius\Builder\Grid;
use Sirius\Builder\Layout\Content;
use Illuminate\Routing\Controller;

class RoleController extends Controller
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
            $content->header(lang('admin.roles'));
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
            $content->header(lang('admin.roles'));
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
            $content->header(lang('admin.roles'));
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
        return Admin::grid(Role::class, function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->slug(lang('admin.slug'));
            $grid->name(lang('admin.name'));

            $grid->permissions(lang('admin.permission'))->pluck('name')->label();

            $grid->created_at(lang('admin.created_at'));
            $grid->updated_at(lang('admin.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->row->slug == 'administrator') {
                    $actions->disableDelete();
                }
            });

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
        return Admin::form(Role::class, function (Form $form) {
            $form->display('id', 'ID');

            $form->text('slug', lang('admin.slug'))->rules('required');
            $form->text('name', lang('admin.name'))->rules('required');
            $form->listbox('permissions', lang('admin.permissions'))->options(Permission::all()->pluck('name', 'id'));

            $form->display('created_at', lang('admin.created_at'));
            $form->display('updated_at', lang('admin.updated_at'));
        });
    }
}
