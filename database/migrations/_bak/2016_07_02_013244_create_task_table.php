<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
	 * -- ----------------------------
		-- Table structure for task
		-- ----------------------------
		DROP TABLE IF EXISTS `task`;
		CREATE TABLE `task` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(21) unsigned NOT NULL COMMENT '用户id',
		  `project_id` int(21) NOT NULL DEFAULT '0' COMMENT '项目id',
		  `action` smallint(1) NOT NULL DEFAULT '0' COMMENT '0全新上线，2回滚',
		  `status` smallint(1) NOT NULL DEFAULT '0' COMMENT '状态0：新建提交，1审核通过，2审核拒绝，3上线完成，4上线失败',
		  `title` varchar(100) DEFAULT '' COMMENT '上线的软链号',
		  `link_id` varchar(20) DEFAULT '' COMMENT '上线的软链号',
		  `ex_link_id` varchar(20) DEFAULT '' COMMENT '上一次上线的软链号',
		  `commit_id` varchar(100) DEFAULT '' COMMENT 'git commit id',
		  `created_at` datetime DEFAULT NULL COMMENT '创建时间',
		  `updated_at` datetime DEFAULT NULL COMMENT '修改时间',
		  `branch` varchar(100) DEFAULT 'master' COMMENT '选择上线的分支',
		  `file_list` text COMMENT '文件列表，svn上线方式可能会产生',
		  `enable_rollback` int(1) NOT NULL DEFAULT '1' COMMENT '能否回滚此版本0no 1yes',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8;
     */
    public function up()
    {
		Schema::create('task', function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id', false, true);
			$table->integer('project_id')->default(0);
			$table->smallInteger('action')->default(0);
			$table->smallInteger('status')->default(0);
			$table->string('title', 100)->default('');
			$table->string('link_id', 20)->default('');
			$table->string('ex_link_id', 20)->default('');
			$table->string('commit_id', 100)->default('');
			$table->integer('created_at')->default(0);
			$table->integer('update_at')->default(0);
			$table->string('branch', 100)->default('master');
			$table->text('file_list');
			$table->tinyInteger('enable_rollback')->default(1);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('task');
    }
}
