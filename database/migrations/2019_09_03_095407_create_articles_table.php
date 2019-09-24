<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->tinyInteger('format');
            $table->integer('topic_id');
            $table->text('annotation');
            $table->integer('author_id');
            $table->integer('source_id');
            $table->integer('organisation_id');
            $table->string('link')->default('');
            $table->year('year');
            $table->integer('region_id');
            $table->integer('file_id')->nullable()->default(null);
            $table->string('img');
            $table->integer('content_type_id');
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
        Schema::dropIfExists('articles');
    }
}
