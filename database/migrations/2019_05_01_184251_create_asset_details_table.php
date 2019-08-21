<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAssetDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedBigInteger('os_id');
            $table->unsignedBigInteger('systsem_type_id');
            $table->unsignedBigInteger('ram_id');
            $table->unsignedBigInteger('hdd_id');
            $table->unsignedBigInteger('office_id');
            $table->unsignedBigInteger('windows_licence_id');
            $table->timestamps();
            $table->foreign('asset_id')
                ->references('id')->on('assets')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_details');
    }
}