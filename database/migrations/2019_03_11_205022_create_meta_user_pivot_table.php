<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaUserPivotTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meta_user', function (Blueprint $table) {
            $table->unsignedInteger('meta_id');
            $table->unsignedInteger('user_id');
            $table->text('value')->nullable();
            $table->timestamps();

            $table->unique(['meta_id', 'user_id']);

            $table->foreign('meta_id')->references('id')->on('metas')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meta_user');
    }
}
