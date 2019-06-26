<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGroupModulesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('group_modules', function(Blueprint $table)
		{
			$table->string('group_module_code', 191)->unique('group_module_code');
			$table->string('group_module_name', 191);
			$table->text('group_module_description', 65535)->nullable();
			$table->string('group_module_link', 191)->nullable();
			$table->integer('group_module_sort')->nullable()->default(0);
			$table->enum('group_module_visible', array('1','0'))->nullable()->default('1');
			$table->enum('group_module_enable', array('1','0'))->nullable()->default('1');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('group_modules');
	}

}
