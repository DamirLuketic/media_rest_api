<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIdentifiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('identifiers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('input');
            $table->integer('identifierable_id');
            $table->string('identifierable_type');
            $table->timestamps();
        });

        // Dummy data
        DB::table('identifiers')->insert([
            'title'                 => 'for audio 1 -> first',
            'input'                 => 'some identifier for audio 1 -> first',
            'identifierable_id'     => 1,
            'identifierable_type'   => 'App\Audio'
        ]);

        DB::table('identifiers')->insert([
            'title'                 => 'for audio 1 -> second',
            'input'                 => 'some identifier for audio 1 -> second',
            'identifierable_id'     => 1,
            'identifierable_type'   => 'App\Audio'
        ]);

        DB::table('identifiers')->insert([
            'title'                 => 'for video 1 -> first',
            'input'                 => 'some identifier for video 1 -> first',
            'identifierable_id'     => 1,
            'identifierable_type'   => 'App\Video'
        ]);

        DB::table('identifiers')->insert([
            'title'                 => 'for video 1 -> second',
            'input'                 =>'some identifier for video 1 -> second',
            'identifierable_id'     => 1,
            'identifierable_type'   => 'App\Video'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('identifiers');
    }
}
