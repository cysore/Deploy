<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentry;
use Mail;
use App\User;

class PasswordController extends Controller
{
	public function Index(){
		return view('user.password');
	}
    //重置发送邮件
	public function ResetAndEmail(Request $request) {
		try {
			// 根据 email 查找用户
			$user = Sentry::findUserByLogin($request->get('email'));
			
			// 获取重置代码
			$resetCode = $user->getResetPasswordCode();

			// 重置代码，通过 email 发送给用户
			Mail::send('emails.resetPassword', ['user' => $user, 'token' => $resetCode], function ($m) use ($user) {
				$m->subject('找回密码邮件');
				$m->to($user->email, $user->nickname);
			});
			
			return $this->dispatchJump('请登录您的邮箱进行验证！', 1);
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
			return redirect()->back()->withErrors('该用户不存在');
		}
	}
	
	//重置页面
	public function ResetPassword(Request $request){
		try{
			$token = $request->get('token');
			$id = $request->get('id');

			//查询用户
			$user = Sentry::findUserById($id);

			if($user->checkResetPasswordCode($token)){
				return view('user.resetPassword', ['user' => $user, 'token' => $token]);
			}else{
				return $this->dispatchJump('该用户不存在！', 0, '/');
			}
		} catch (\Exception $ex) {
			return $this->dispatchJump('该用户不存在！', 0, '/');
		}
	}

	//验证并修改密码
	public function CheckResetPassword(Request $request) {
		try {
			$restCode = $request->get('token');
			$newPassword = $request->get('password');
			
			// 查询用户
			$user = Sentry::findUserById($request->get('id'));
			
			// 检查重置密码的代码是否有效
			if ($user->checkResetPasswordCode($restCode)) {
				// 重置用户密码
				if ($user->attemptResetPassword($restCode, $newPassword)) {
					// 密码重置通过
					return $this->dispatchJump('修改密码成功，请重新登陆！', 1);
				} else {
					// 密码重置失败
					return $this->dispatchJump('修改密码失败，请重试或联系管理员', 0);
				}
			} else {
				// 所提供的密码重置代码是无效的
				return $this->dispatchJump('校验失败，请重试或联系管理员', 0);
			}
		} catch (Cartalyst\Sentry\Users\UserNotFoundException $e) {
			return $this->dispatchJump('用户不存在！', 0);
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
