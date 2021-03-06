<?php

namespace Sirius\Builder\Controllers;

use Sirius\Builder\Auth\Database\Menu;
use Sirius\Builder\Auth\Database\Role;
use Sirius\Builder\Facades\Admin;
use Sirius\Builder\Form;
use Sirius\Builder\Layout\Column;
use Sirius\Builder\Layout\Content;
use Sirius\Builder\Layout\Row;
use Sirius\Builder\Tree;
use Sirius\Builder\Widgets\Box;
use Illuminate\Routing\Controller;

class MenuController extends Controller
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
            $content->header(lang('admin.menu'));
            $content->description(lang('admin.list'));

            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());

                $row->column(6, function (Column $column) {
                    $form = new \Sirius\Builder\Widgets\Form();
                    $form->action(admin_base_path('auth/menu'));

                    $form->select('parent_id', lang('admin.parent_id'))->options(Menu::selectOptions());
                    $form->text('title', lang('admin.title'))->rules('required');
                    $form->icon('icon', lang('admin.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
                    $form->text('uri', lang('admin.uri'));
                    $form->multipleSelect('roles', lang('admin.roles'))->options(Role::all()->pluck('name', 'id'));

                    $column->append((new Box(lang('admin.new'), $form))->style('success'));
                });
            });
        });
    }

    /**
     * Redirect to edit page.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function show($id)
    {
        return redirect()->route('menu.edit', ['id' => $id]);
    }

    /**
     * @return \Sirius\Builder\Tree
     */
    protected function treeView()
    {
        return Menu::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "<i class='fa {$branch['icon']}'></i>&nbsp;<strong>{$branch['title']}</strong>";

                if (!isset($branch['children'])) {
                    if (url()->isValidUrl($branch['uri'])) {
                        $uri = $branch['uri'];
                    } else {
                        $uri = admin_base_path($branch['uri']);
                    }

                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * Edit interface.
     *
     * @param string $id
     *
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {
            $content->header(lang('admin.menu'));
            $content->description(lang('admin.edit'));

            $content->row($this->form()->edit($id));
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    public function form()
    {
        return Menu::form(function (Form $form) {
            $form->display('id', 'ID');

            $form->select('parent_id', lang('admin.parent_id'))->options(Menu::selectOptions());
            $form->text('title', lang('admin.title'))->rules('required');
            $form->icon('icon', lang('admin.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
            $form->text('uri', lang('admin.uri'));
            $form->multipleSelect('roles', lang('admin.roles'))->options(Role::all()->pluck('name', 'id'));

            $form->display('created_at', lang('admin.created_at'));
            $form->display('updated_at', lang('admin.updated_at'));
        });
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
