<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('likeable_id');
            $table->string('likeable_type');
            $table->unsignedInteger('owner_id');
            $table->string('owner_type');
            $table->enum('type', ['like', 'dislike'])->default('like');
            $table->timestamps();
            $table->unique(['likeable_id', 'likeable_type', 'owner_id', 'owner_type'], 'like_owner_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('likes');
    }
}
