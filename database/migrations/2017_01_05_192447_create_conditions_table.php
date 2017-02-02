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

        // Dummy data
        DB::table('conditions')->insert([
            'name' => 'Not selected'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Sealed Albums'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Mint'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Near Mint'
        ]);
        DB::table('conditions')->insert([
            'name' => 'Excellent'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Very Good'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Good'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Poor'
        ]);

        DB::table('conditions')->insert([
            'name' => 'Promotional Copies'
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
