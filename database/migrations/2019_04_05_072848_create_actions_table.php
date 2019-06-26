<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateActionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('actions', function(Blueprint $table)
		{
			$table->string('action_code', 100)->unique('action_code');
			$table->string('action_module', 100)->nullable();
			$table->string('action_name', 191);
			$table->text('action_description', 65535)->nullable();
			$table->string('action_link', 100)->nullable();
			$table->string('action_controller', 100)->nullable();
			$table->string('action_function', 100)->nullable();
			$table->integer('action_sort')->nullable()->default(0);
			$table->enum('action_visible', array('0','1'))->nullable()->default('1');
			$table->enum('action_enable', array('0','1'))->nullable()->default('1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('actions');
	}

}
