<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentry;
use Mail;
use App\User;

class RegisterController extends Controller
{
    //注册页面
	public function Index() {
		return view('user.register');
	}
	
	//提交注册
	public function Register(Request $request) {
		try {
			// 从表单收集的数据 注册用户
			$user = Sentry::register(array(
						'email' => $request->get('email'),
						'nickname' => $request->get('nickname'),
						'password' => $request->get('password'),
			));
			//注册失败
			if (empty($user)) {
				return redirect()->back()->withErrors('注册失败');
			}

			// 获取此用户的激活码 并发送激活邮件
			$activationCode = $user->getActivationCode();

			Mail::send('emails.activation', ['user' => $user, 'code' => $activationCode], function ($m) use ($user){
				$m->subject('激活账户邮件');
				$m->to($user->email, $user->nickname);
			});

			return $this->dispatchJump('恭喜您，注册成功！请登录您的邮箱进行激活。', 1);
		} catch (\Cartalyst\Sentry\Users\LoginRequiredException $e) {
			return redirect()->back()->withErrors('字段不能为空');
		} catch (\Cartalyst\Sentry\Users\PasswordRequiredException $e) {
			return redirect()->back()->withErrors('没有输入密码');
		} catch (\Cartalyst\Sentry\Users\UserExistsException $e) {
			return redirect()->back()->withErrors('用户已存在');
		} catch (\Cartalyst\Sentry\Users\WrongPasswordException $e) {
			return redirect()->back()->withErrors('密码错误');
		}
	}

	//激活用户
	public function Activation(Request $request) {
		try {
			// 根据 email 查询用户
			$user = Sentry::findUserByLogin($request->get('email'));

			// 使用激活码激活用户
			if ($user->attemptActivation($request->get('code'))) {
				// 用户激活成功
				return $this->dispatchJump('用户激活成功，请重新登录！', 1);
			} else {
				return $this->dispatchJump('用户激活失败！', 0);
			}
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
			return $this->dispatchJump('用户不存在！', 0);
		} catch (Cartalyst\Sentry\Users\UserAlreadyActivatedException $e) {
			return $this->dispatchJump('用户已经被激活，不能重复激活！', 0);
		}
	}

	//跳转页面
	protected function dispatchJump($message, $status = 1, $jumpUrl = '') {
		$waitSecond = 5;
		if ($status) {
			empty($jumpUrl) && $jumpUrl = '/';
		} else {
			empty($jumpUrl) && $jumpUrl = 'javascript:history.back(-1);';
		}
		return view('user.redirect', ['message' => $message, 'status' => $status, 'jumpUrl' => $jumpUrl, 'waitSecond' => $waitSecond]);
	}
}
