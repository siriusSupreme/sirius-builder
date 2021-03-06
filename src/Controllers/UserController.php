<?php

namespace Sirius\Builder\Controllers;

use Sirius\Builder\Auth\Database\Administrator;
use Sirius\Builder\Auth\Database\Permission;
use Sirius\Builder\Auth\Database\Role;
use Sirius\Builder\Facades\Admin;
use Sirius\Builder\Form;
use Sirius\Builder\Grid;
use Sirius\Builder\Layout\Content;
use Illuminate\Routing\Controller;

class UserController extends Controller
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
            $content->header(lang('admin.administrator'));
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
            $content->header(lang('admin.administrator'));
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
            $content->header(lang('admin.administrator'));
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
        return Administrator::grid(function (Grid $grid) {
            $grid->id('ID')->sortable();
            $grid->username(lang('admin.username'));
            $grid->name(lang('admin.name'));
            $grid->roles(lang('admin.roles'))->pluck('name')->label();
            $grid->created_at(lang('admin.created_at'));
            $grid->updated_at(lang('admin.updated_at'));

            $grid->actions(function (Grid\Displayers\Actions $actions) {
                if ($actions->getKey() == 1) {
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
        return Administrator::form(function (Form $form) {
            $form->display('id', 'ID');

            $form->text('username', lang('admin.username'))->rules('required');
            $form->text('name', lang('admin.name'))->rules('required');
            $form->image('avatar', lang('admin.avatar'));
            $form->password('password', lang('admin.password'))->rules('required|confirmed');
            $form->password('password_confirmation', lang('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->ignore(['password_confirmation']);

            $form->multipleSelect('roles', lang('admin.roles'))->options(Role::all()->pluck('name', 'id'));
            $form->multipleSelect('permissions', lang('admin.permissions'))->options(Permission::all()->pluck('name', 'id'));

            $form->display('created_at', lang('admin.created_at'));
            $form->display('updated_at', lang('admin.updated_at'));

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });
        });
    }
}
