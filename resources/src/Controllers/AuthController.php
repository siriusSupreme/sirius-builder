<?php

namespace Sirius\Builder\Controllers;

use Sirius\Builder\Auth\Database\Administrator;
use Sirius\Builder\Facades\Admin;
use Sirius\Builder\Form;
use Sirius\Builder\Layout\Content;
use Sirius\Http\Request;
use Sirius\Routing\Controller;
use Sirius\Support\Facades\Auth;
use Sirius\Support\Facades\Lang;
use Sirius\Support\Facades\Redirect;
use Sirius\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login page.
     *
     * @return \Sirius\Contracts\View\Factory|Redirect|\Sirius\View\View
     */
    public function getLogin()
    {
        if (!Auth::guard('admin')->guest()) {
            return redirect(config('admin.route.prefix'));
        }

        return view('admin::login');
    }

    /**
     * @param Request $request
     *
     * @return mixed
     */
    public function postLogin(Request $request)
    {
        $credentials = $request->only(['username', 'password']);

        $validator = Validator::make($credentials, [
            'username' => 'required', 'password' => 'required',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        if (Auth::guard('admin')->attempt($credentials)) {
            admin_toastr(trans('admin.login_successful'));

            return redirect()->intended(config('admin.route.prefix'));
        }

        return Redirect::back()->withInput()->withErrors(['username' => $this->getFailedLoginMessage()]);
    }

    /**
     * User logout.
     *
     * @return Redirect
     */
    public function getLogout()
    {
        Auth::guard('admin')->logout();

        session()->forget('url.intented');

        return redirect(config('admin.route.prefix'));
    }

    /**
     * User setting page.
     *
     * @return mixed
     */
    public function getSetting()
    {
        return Admin::content(function (Content $content) {
            $content->header(trans('admin.user_setting'));
            $content->body($this->settingForm()->edit(Admin::user()->id));
        });
    }

    /**
     * Update user setting.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function putSetting()
    {
        return $this->settingForm()->update(Admin::user()->id);
    }

    /**
     * Model-form for user setting.
     *
     * @return Form
     */
    protected function settingForm()
    {
        return Administrator::form(function (Form $form) {
            $form->display('username', trans('admin.username'));
            $form->text('name', trans('admin.name'))->rules('required');
            $form->image('avatar', trans('admin.avatar'));
            $form->password('password', trans('admin.password'))->rules('confirmed|required');
            $form->password('password_confirmation', trans('admin.password_confirmation'))->rules('required')
                ->default(function ($form) {
                    return $form->model()->password;
                });

            $form->setAction(admin_base_path('auth/setting'));

            $form->ignore(['password_confirmation']);

            $form->saving(function (Form $form) {
                if ($form->password && $form->model()->password != $form->password) {
                    $form->password = bcrypt($form->password);
                }
            });

            $form->saved(function () {
                admin_toastr(trans('admin.update_succeeded'));

                return redirect(admin_base_path('auth/setting'));
            });
        });
    }

    /**
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getFailedLoginMessage()
    {
        return Lang::has('auth.failed')
            ? trans('auth.failed')
            : 'These credentials do not match our records.';
    }
}
