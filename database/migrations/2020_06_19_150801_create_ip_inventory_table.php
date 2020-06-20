<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpInventoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ip_inventory', function (Blueprint $table) {
            $table->increments('id');
            $table->string('server_name');
            $table->string('server_ip');
            $table->string('server_username');
            $table->string('server_password');
            $table->string('server_desc');
            $table->string('server_floor');
            $table->bigInteger('created_by')->unsigned();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ip_inventory');
    }
}
