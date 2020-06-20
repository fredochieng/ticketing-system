<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateIssueSubcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('issue_subcategories', function(Blueprint $table)
		{
			$table->bigInteger('issue_subcategory_id', true)->unsigned();
			$table->bigInteger('issue_id')->unsigned()->index('issue_subcategories_issue_id_foreign');
			$table->string('issue_subcategory_name', 191);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('issue_subcategories');
	}

}
