<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConditionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conditions', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });

        DB::table('conditions')->insert([
            'name' => 'Poor'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Fair'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Good'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Very Good'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Mint'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('conditions');
    }
}
