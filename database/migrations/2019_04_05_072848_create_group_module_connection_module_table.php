<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupModuleConnectionModuleTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_module_connection_module', function(Blueprint $table)
		{
			$table->string('conn_gm_group_module', 191);
			$table->string('conn_gm_module', 191)->index('group_module_connection_module_code_module_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_module_connection_module');
	}

}
