<?php
/**
 * Created by PhpStorm.
 * User: fengyan
 * Date: 18-9-11
 * Time: 下午3:08
 */

namespace App\Http\Controllers\Manage;


use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Helper\Helper;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
//    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * 自定义跳转路径
     * @return string
     */
    protected function redirectTo()
    {
        return Auth::guard('web-manage')->user();
    }

    /**
     * 登录验证字段
     * @return string
     */
    public function username()
    {
        return 'email';
    }

    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('web-manage');
    }

    /**
     * @param Request $request
     * @param $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    protected function authenticated(Request $request, $user)
    {
        $user->csrf_token = csrf_token();

        return $this->success('登录成功', ['userInfo' => $user]);
    }
}