<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('asset_no');
            $table->unsignedInteger('category_id');
            $table->string('manufacturer');
            $table->string('model');
            $table->string('serial_no');
            $table->unsignedInteger('os_id');
            $table->unsignedInteger('system_type_id');
            $table->unsignedInteger('processor_id');
            $table->unsignedInteger('ram_id');
            $table->unsignedInteger('hdd_id');
            $table->unsignedInteger('office_id');
            $table->unsignedInteger('windows_licence_id');
            $table->unsignedInteger('user_id');
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
        Schema::dropIfExists('assets');
    }
}