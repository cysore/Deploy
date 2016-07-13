<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentry;
use Mail;
use App\User;

class LoginController extends Controller
{
    //登录页面
	public function Index() {
		return view('user.login');
	}

	//登录
	public function Login(Request $request) {
		$cred = array(
			'email' => $request->get('email'),
			'password' => $request->get('password'),
		);
		$remember = (Boolean) $request->get('remember');
		try {
			$user = Sentry::authenticate($cred, $remember);
			if ($user) {
				return redirect()->to('/');
			}
		} catch (\Exception $e) {
			return redirect()->back()->withErrors($e->getMessage());
		}
	}

	//退出
	public function logout() {
		Sentry::logout();
		return redirect()->to('/');
	}
}
