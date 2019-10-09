<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticleRegionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('article_region', function (Blueprint $table) {
            $table->integer('article_id')->unsigned();
            $table->foreign('article_id')->references('id')
                ->on('articles')->onDelete('cascade');

            $table->integer('region_id')->unsigned();
            $table->foreign('region_id')->references('id')
                ->on('regions')->onDelete('cascade');

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
        Schema::dropIfExists('article_region');
    }
}
