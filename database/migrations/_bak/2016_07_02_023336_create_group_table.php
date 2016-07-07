<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
	 * -- ----------------------------
	-- Table structure for group
	-- ----------------------------
	DROP TABLE IF EXISTS `group`;
	CREATE TABLE `group` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `project_id` int(2) unsigned NOT NULL COMMENT '项目id',
	  `user_id` int(32) NOT NULL COMMENT '用户id',
	  `type` smallint(1) DEFAULT '0' COMMENT '用户在项目中的关系类型 0普通用户， 1管理员',
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
     */
    public function up()
    {
		Schema::create('group', function(Blueprint $table){
			$table->increments('id');
			$table->integer('project_id', false, true);
			$table->integer('user_id');
			$table->smallInteger('type')->default(0);
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('group');
    }
}
