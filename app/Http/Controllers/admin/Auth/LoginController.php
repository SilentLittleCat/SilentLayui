<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = '/admin';

    public function showLoginForm()
    {
        return view('admin.auth.login');
    }

    public function username()
    {
        return 'phone';
    }

    protected function guard()
    {
        return Auth::guard('admin');
    }

    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect('/admin/login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            $this->username() => 'required|string',
            'password' => 'required|string'
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    public function showChangePasswordForm(Request $request)
    {
        return view('admin.auth.change-password');
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:6'
        ], [
            'password.required' => '密码必填',
            'password.confirmed' => '两次填写密码不一致',
            'password.min' => '密码长度不小于6位',
        ]);
        if($validator->fails()) {
            return back()->withErrors($validator);
        }

        $admin_user = Auth::guard('admin')->user();

        $admin_user->password = bcrypt($request->input('password'));
        if(!$admin_user->save()) {
            return back()->withErrors(['sg_error_info' => '数据库保存失败']);
        }
        return back()->with(['sg_success_info' => '更改成功']);
    }
}
