<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetInformationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_information', function (Blueprint $table) {
            $table->engine = 'InnoDB';$table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->string('brand',150);
            $table->string('serial_no',150);
            $table->string('model',150);
            $table->longText('description');
            $table->smallInteger('asset_id')->unsigned()->index();
            $table->foreign('asset_id')->references('id')->on('assets')->onDelete('cascade');
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
        Schema::dropIfExists('asset_information');
    }
}
