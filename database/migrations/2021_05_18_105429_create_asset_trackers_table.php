<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssetTrackersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asset_trackers', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->bigIncrements('id');
            $table->string('tracker_code',50)->unique();
            $table->string('asset_code',50)->unique();
            $table->json('coordinates')->nullable();
            $table->string('status',3)->nullable();
            $table->smallInteger('assetlist_id')->unsigned()->index();
            $table->foreign('assetlist_id')->references('id')->on('asset_lists')->onDelete('cascade');
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
        Schema::dropIfExists('asset_trackers');
    }
}
