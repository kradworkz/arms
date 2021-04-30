<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->engine = 'InnoDB';$table->engine = 'InnoDB';
            $table->smallIncrements('id');
            $table->string('code')->unique();
            $table->string('name',200);
            $table->integer('quantity')->unsigned()->default(1);
            $table->string('image',100)->default('default.jpg');
            $table->smallInteger('mm_id')->unsigned()->index();
            $table->foreign('mm_id')->references('id')->on('member_municipalities')->onDelete('cascade');     
            $table->tinyInteger('category_id')->unsigned()->index();
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->tinyInteger('storage_id')->unsigned()->index();
            $table->foreign('storage_id')->references('id')->on('storages')->onDelete('cascade');
            $table->tinyInteger('status_id')->unsigned()->index();
            $table->foreign('status_id')->references('id')->on('statuses')->onDelete('cascade');
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
