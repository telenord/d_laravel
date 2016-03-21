<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('access_key_id')->unsigned();
			$table->foreign('access_key_id')->references('id')->on('access_keys');
			$table->timestamp('happened_on');
            $table->timestamps();
			$table->index(['user_id', 'happened_on'], 'idx_user_happened');
			$table->index(['access_key_id', 'happened_on'], 'idx_access_key_happened');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
    }
}
