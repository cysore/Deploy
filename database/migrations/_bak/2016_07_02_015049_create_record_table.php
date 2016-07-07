<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
	 * -- ----------------------------
		-- Table structure for record
		-- ----------------------------
		DROP TABLE IF EXISTS `record`;
		CREATE TABLE `record` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `user_id` int(21) unsigned NOT NULL COMMENT '用户id',
		  `task_id` bigint(21) NOT NULL COMMENT '任务id',
		  `status` smallint(1) NOT NULL DEFAULT '1' COMMENT '状态1：成功，0失败',
		  `action` int(3) unsigned DEFAULT '10' COMMENT '任务执行到的阶段',
		  `command` text COMMENT '运行命令',
		  `duration` int(10) DEFAULT '0' COMMENT '耗时，单位ms',
		  `memo` text COMMENT '日志/备注',
		  `created_at` int(10) DEFAULT '0' COMMENT '创建时间',
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=370 DEFAULT CHARSET=utf8;
     */
    public function up()
    {
		Schema::create('record', function(Blueprint $table){
			$table->increments('id');
			$table->integer('user_id', false, true);
			$table->bigInteger('task_id');
			$table->smallInteger('status')->default(1);
			$table->integer('action', false, true)->default(10);
			$table->text('command');
			$table->integer('duration')->default(0);
			$table->text('memo');
			$table->integer('created_at')->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('record');
    }
}
