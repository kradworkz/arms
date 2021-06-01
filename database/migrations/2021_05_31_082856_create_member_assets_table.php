<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberAssetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_assets', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->bigInteger('asset_id')->unsigned()->index();
            $table->foreign('asset_id')->references('id')->on('asset_lists')->onDelete('cascade');  
            $table->smallInteger('borrowed_to')->unsigned()->index();
            $table->foreign('borrowed_to')->references('id')->on('member_municipalities')->onDelete('cascade');  
            $table->smallInteger('borrowed_by')->unsigned()->index();
            $table->foreign('borrowed_by')->references('id')->on('member_municipalities')->onDelete('cascade');
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('dropdowns')->onDelete('cascade');
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
        Schema::dropIfExists('member_assets');
    }
}
