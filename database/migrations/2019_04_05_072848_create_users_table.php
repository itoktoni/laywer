<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->string('user_id', 50)->index('user_id');
			$table->string('nik', 191)->nullable();
			$table->string('name', 191);
			$table->string('email', 191)->unique();
			$table->string('password', 191)->nullable();
			$table->string('username', 191)->nullable();
			$table->string('photo', 191)->nullable();
			$table->boolean('active')->nullable();
			$table->string('group_user', 191)->nullable();
			$table->string('remember_token', 100)->nullable();
			$table->timestamps();
			$table->string('warehouse', 191)->nullable();
			$table->string('site_id', 191)->nullable();
			$table->float('target', 10, 0)->nullable();
			$table->float('pencapaian', 10, 0)->nullable();
			$table->string('gender', 1)->nullable();
			$table->text('address', 65535)->nullable();
			$table->date('birth')->nullable();
			$table->string('place_birth', 191)->nullable();
			$table->text('biografi', 65535)->nullable();
			$table->string('handphone', 191)->nullable();
			$table->string('no_tax', 191)->nullable();
			$table->string('created_by', 191)->nullable();
			$table->string('sales_responsible', 191)->nullable();
			$table->integer('status')->nullable();
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
