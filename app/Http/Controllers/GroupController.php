<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Sentry;

class GroupController extends Controller {

	//创建分组
	public function Create() {
		try {
			// 创建分组
			$group = Sentry::createGroup(array(
						'name' => 'admin',
						'permissions' => array(
							'admin.index' => 1,
							'users.index' => 1,
						),
			));
		} catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
			echo '分组名称必须存在';
		} catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
			echo '分组已经存在';
		}
	}

}
