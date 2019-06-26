<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_users', function(Blueprint $table)
		{
			$table->string('group_user_code', 191)->unique('group_user_code');
			$table->string('group_user_name', 191);
			$table->text('group_user_description', 65535)->nullable();
			$table->enum('group_user_visible', array('1','0'))->nullable()->default('1');
			$table->integer('group_user_level')->nullable();
			$table->string('group_user_dashboard', 191)->nullable();
			$table->timestamps();
			$table->string('created_by', 191)->nullable();
			$table->string('updated_by', 191)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_users');
	}

}
