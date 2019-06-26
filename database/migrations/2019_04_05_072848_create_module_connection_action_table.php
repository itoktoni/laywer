<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModuleConnectionActionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('module_connection_action', function(Blueprint $table)
		{
			$table->string('conn_ma_module', 191);
			$table->string('conn_ma_action', 191)->index('module_connection_action_code_action_foreign');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('module_connection_action');
	}

}
