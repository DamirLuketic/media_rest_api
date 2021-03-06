<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('can_views', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('can_view_id');
            $table->timestamps();
        });

        DB::table('can_views')->insert([
            'user_id'     => 1,
            'can_view_id' => 2
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('can_views');
    }
}
