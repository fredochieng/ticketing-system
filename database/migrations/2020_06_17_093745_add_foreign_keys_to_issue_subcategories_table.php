<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToIssueSubcategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('issue_subcategories', function(Blueprint $table)
		{
			$table->foreign('issue_id')->references('issue_id')->on('issues_categories')->onUpdate('CASCADE')->onDelete('CASCADE');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('issue_subcategories', function(Blueprint $table)
		{
			$table->dropForeign('issue_subcategories_issue_id_foreign');
		});
	}

}
