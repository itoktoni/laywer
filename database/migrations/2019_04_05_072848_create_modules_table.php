<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modules', function(Blueprint $table)
		{
			$table->string('module_code', 100)->primary();
			$table->string('module_name', 191);
			$table->text('module_description', 65535)->nullable();
			$table->string('module_link', 100);
			$table->integer('module_sort')->nullable()->default(0);
			$table->integer('module_single')->nullable()->default(0);
			$table->string('module_controller', 100)->nullable();
			$table->string('module_filters', 191)->nullable();
			$table->enum('module_visible', array('0','1'))->nullable()->default('1');
			$table->enum('module_enable', array('0','1'))->nullable()->default('1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('modules');
	}

}
