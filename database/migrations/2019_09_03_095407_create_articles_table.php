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
            $table->integerIncrements('id')->unsigned();
            $table->string('title');
            $table->tinyInteger('format');
            $table->integer('topic_id');
            $table->text('annotation');
            $table->integer('source_id');
            $table->string('link')->default('');
            $table->string('authors_string')->default('');
            $table->year('year');
            $table->integer('file_id')->nullable()->default(null);
            $table->string('img')->nullable();
            $table->mediumText('html')->nullable();
            $table->integer('content_type_id');
            $table->integer('magazine_id')->nullable();
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
