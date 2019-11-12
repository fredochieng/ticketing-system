<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssueSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issue_subcategories', function (Blueprint $table) {
            $table->bigIncrements('issue_subcategory_id');
            $table->unsignedBigInteger('issue_id');
            $table->string('issue_subcategory_name');
            $table->foreign('issue_id')
                ->references('issue_id')->on('issues_categories')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::dropIfExists('issue_subcategories');
    }
}
