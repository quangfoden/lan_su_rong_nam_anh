<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->string('source')->nullable();
            $table->longText('desc')->nullable();
            $table->longText('content');
            $table->string('image')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->tinyInteger('is_hot')->default(0);
            $table->date('publish_date')->nullable();
            $table->integer('created_by');
            $table->integer('like_number')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
