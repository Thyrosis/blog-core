<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->UnsignedInteger('user_id')->nullable();
            $table->string('title')->index();
            $table->string('slug')->nullable();
            $table->text('summary')->nullable();
            $table->text('body')->nullable();
            $table->integer('views')->default(0);
            $table->boolean('commentable')->default(0);
            $table->integer('featured')->default(0);
            $table->boolean('published')->default(1);
            $table->timestamp('published_at')->nullable();
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
