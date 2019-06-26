<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupUserConnectionGroupModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_user_connection_group_module', function(Blueprint $table)
		{
			$table->string('conn_gu_group_module', 191);
			$table->string('conn_gu_group_user', 191)->index('group_user_connection_group_module_code_group_user_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_user_connection_group_module');
	}

}
