<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThreadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('threads', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('slug')->unique();
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('channel_id');
            $table->unsignedInteger('replies_count')->default(0);
            $table->unsignedInteger('visits')->default(0);
            $table->string('title');
            $table->text('body');
            $table->unsignedInteger('best_reply_id')->nullable();
            $table->timestamp('locked_at')->nullable();
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
        Schema::dropIfExists('threads');
    }
}
