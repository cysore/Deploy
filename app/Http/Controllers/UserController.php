<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Sentry;
use Mail;
use App\User;

class UserController extends Controller {

	//注册页面
	public function Index() {
		return view('user.register');
	}
	
	//测试用例
	public function demo(){
		return $this->dispatchJump('用户已经被激活，不能重复激活！', 0);
		die();
		// 从表单收集的数据 注册用户
		$user = Sentry::register(array(
					'email' => 'sdfxxxwwx@qq.com',
					'nickname' => 'nickname',
					'password' => '111111',
		));
		print_r($user);
		//Cartalyst\Sentry\Users\Eloquent\User Object ( [table:protected] => users [hidden:protected] => Array ( [0] => password [1] => reset_password_code [2] => activation_code [3] => persist_code ) [guarded:protected] => Array ( [0] => reset_password_code [1] => activation_code [2] => persist_code ) [hashableAttributes:protected] => Array ( [0] => password [1] => persist_code ) [allowedPermissionsValues:protected] => Array ( [0] => -1 [1] => 0 [2] => 1 ) [userGroups:protected] => [mergedPermissions:protected] => [connection:protected] => [primaryKey:protected] => id [keyType:protected] => int [perPage:protected] => 15 [incrementing] => 1 [timestamps] => 1 [attributes:protected] => Array ( [email] => sdfxxxwwx@qq.com [nickname] => nickname [password] => $2y$10$3OMjWHg1UxOg.6apc0XkQO/ohdiodFhR.bzMBYpwnYhnIxes3USvq [updated_at] => 2016-07-07 02:39:45 [created_at] => 2016-07-07 02:39:45 [id] => 11 ) [original:protected] => Array ( [email] => sdfxxxwwx@qq.com [nickname] => nickname [password] => $2y$10$3OMjWHg1UxOg.6apc0XkQO/ohdiodFhR.bzMBYpwnYhnIxes3USvq [updated_at] => 2016-07-07 02:39:45 [created_at] => 2016-07-07 02:39:45 [id] => 11 ) [relations:protected] => Array ( ) [visible:protected] => Array ( ) [appends:protected] => Array ( ) [fillable:protected] => Array ( ) [dates:protected] => Array ( ) [dateFormat:protected] => [casts:protected] => Array ( ) [touches:protected] => Array ( ) [observables:protected] => Array ( ) [with:protected] => Array ( ) [morphClass:protected] => [exists] => 1 [wasRecentlyCreated] => 1 )
		print_r($user->id);
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
			$this->sendEmailActivation($user->id, $activationCode);
			
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
	
	//发送注册码邮件
	protected function sendEmailActivation($id, $activationCode)
    {
		$user = User::find($id);

		try{
			Mail::send('emails.activation', ['user' => $user, 'code' => $activationCode], function ($m) use ($user) {
				//$m->from('liujun@taojinjia.com', 'Laravel');
				$m->to($user->email, $user->nickname);
			});
		} catch (\Exception $ex) {
			return $ex->getMessage();
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
	protected function dispatchJump($message, $status=1, $jumpUrl=''){
		$waitSecond = 5;
		if($status){
			empty($jumpUrl) && $jumpUrl = '/';
		}else{
			empty($jumpUrl) && $jumpUrl = 'javascript:history.back(-1);';
		}
		return view('user.redirect', ['message'=>$message, 'status'=>$status, 'jumpUrl'=>$jumpUrl, 'waitSecond'=>$waitSecond]);
	}

	//登录页面
	public function Login() {
		return view('user.login');
	}

	//登录
	public function toLogin(Request $request) {
		$cred = array(
			'email' => $request->get('email'),
			'password' => $request->get('password'),
		);
		$remember = (Boolean)$request->get('remember');
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
