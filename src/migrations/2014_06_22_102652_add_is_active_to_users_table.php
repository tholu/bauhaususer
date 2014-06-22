<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIsActiveToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function ($table) {
			$table->tinyInteger('is_active')->after('last_name')->default(0);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function ($table) {
			$table->dropColumn('is_active');
		});
	}

}
