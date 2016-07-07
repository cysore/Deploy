<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
	 -- ----------------------------
		-- Table structure for project
		-- ----------------------------
		DROP TABLE IF EXISTS `project`;
		CREATE TABLE `project` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(21) unsigned NOT NULL COMMENT '添加项目的用户id',
		  `name` varchar(100) DEFAULT 'master' COMMENT '项目名字',
		  `level` smallint(1) NOT NULL COMMENT '项目环境1：测试，2：仿真，3：线上',
		  `status` smallint(1) NOT NULL DEFAULT '1' COMMENT '状态0：无效，1有效',
		  `version` varchar(32) DEFAULT NULL COMMENT '线上当前版本，用于快速回滚',
		  `repo_url` varchar(200) DEFAULT '' COMMENT 'git地址',
		  `repo_username` varchar(50) DEFAULT '' COMMENT '版本管理系统的用户名，一般为svn的用户名',
		  `repo_password` varchar(100) DEFAULT '' COMMENT '版本管理系统的密码，一般为svn的密码',
		  `repo_mode` varchar(50) DEFAULT 'branch' COMMENT '上线方式：branch/tag',
		  `repo_type` varchar(10) DEFAULT 'git' COMMENT '上线方式：git/svn',
		  `deploy_from` varchar(200) NOT NULL COMMENT '宿主机存放clone出来的文件',
		  `excludes` text COMMENT '要排除的文件',
	 * 
		  `release_user` varchar(50) NOT NULL COMMENT '目标机器用户',
		  `release_to` varchar(200) NOT NULL COMMENT '目标机器的目录，相当于nginx的root，可直接web访问',
		  `release_library` varchar(200) NOT NULL COMMENT '目标机器版本发布库',
		  `hosts` text COMMENT '目标机器列表',
		  `pre_deploy` text COMMENT '部署前置任务',
		  `post_deploy` text COMMENT '同步之前任务',
		  `pre_release` text COMMENT '同步之前目标机器执行的任务',
		  `post_release` text COMMENT '同步之后目标机器执行的任务',
		  `audit` smallint(1) DEFAULT '0' COMMENT '是否需要审核任务0不需要，1需要',
		  `keep_version_num` int(3) NOT NULL DEFAULT '20' COMMENT '线上版本保留数',
		  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
		  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
     */
    public function up()
    {
		Schema::create('project', function(Blueprint $table){
			$table->increments('id');
			$table->string('name', 100)->default('master');
			$table->smallInteger('level');
			$table->smallInteger('status')->default(1);
			$table->string('version', 32)->default('NULL');
			$table->string('repo_url', 200)->default('');
			$table->string('repo_username', 50)->default('');
			$table->string('repo_password', 100)->default('');
			$table->string('repo_mode', 50)->default('branch');
			$table->string('repo_type', 10)->default('git');
			$table->string('deploy_from', 200);
			$table->text('excludes');
			$table->string('release_user', 50);
			$table->string('release_to', 200);
			$table->string('release_library', 200);
			$table->text('hosts');
			$table->text('pre_deploy');
			$table->text('post_deploy');
			$table->text('pre_release');
			$table->text('post_release');
			$table->smallInteger('audit')->default(0);
			$table->integer('keep_version_num')->default(20);
			$table->integer('created_at')->default(0);
			$table->integer('updated_at')->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('project');
    }
}
