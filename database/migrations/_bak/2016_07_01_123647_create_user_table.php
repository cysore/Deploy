<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
	 * 
	 * -- ----------------------------
		-- Table structure for user
		-- ----------------------------
		DROP TABLE IF EXISTS `user`;
		CREATE TABLE `user` (
		  `id` int(11) NOT NULL AUTO_INCREMENT,
		  `username` varchar(255) NOT NULL,
		  `is_email_verified` tinyint(1) NOT NULL DEFAULT '0',
		  `auth_key` varchar(32) NOT NULL,
		  `password_hash` varchar(255) NOT NULL,
		  `password_reset_token` varchar(255) DEFAULT NULL,
		  `email_confirmation_token` varchar(255) DEFAULT NULL,
		  `email` varchar(255) NOT NULL,
		  `avatar` varchar(100) DEFAULT 'default.jpg' COMMENT '头像图片地址',
		  `role` smallint(6) NOT NULL DEFAULT '10',
		  `status` smallint(6) NOT NULL DEFAULT '10',
		  `created_at` datetime NOT NULL,
		  `updated_at` datetime NOT NULL,
		  `realname` varchar(32) NOT NULL,
		  PRIMARY KEY (`id`)
		) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;
     */
    public function up()
    {
		Schema::create('user', function(Blueprint $table){
			$table->increments('id');
			$table->string('username');
			$table->string('realname', 32);
			$table->tinyInteger('is_email_verified')->default(0);
			$table->string('auth_key', 32);
			$table->string('password_hash');
			$table->string('password_reset_token')->default('NULL');
			$table->string('email_confirmation_token')->default('NULL');
			$table->string('email');
			$table->string('avatar', 100)->default('default.jpg');
			$table->smallInteger('role')->default(10);
			$table->smallInteger('status')->default(10);
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
		Schema::drop('users');
    }
}
