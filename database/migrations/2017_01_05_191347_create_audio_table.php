<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAudioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('audio', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('audio_category_id');
            $table->boolean('for_change')->default(0);
            $table->integer('condition_id')->default(1);
            $table->boolean('allowed')->default(1);
            $table->string('band');
            $table->string('album');
            $table->integer('year')->nullable();
            $table->integer('first_release_year')->nullable();
            $table->text('description')->nullable();
            $table->text('personal_note')->nullable();
            $table->string('cat')->nullable();
            $table->string('label')->nullable();
            $table->string('barcode_numbers')->nullable();
            $table->timestamps();
        });

        // Dummy data
        DB::table('audio')->insert([
            'user_id'            => 1,
            'audio_category_id'  => 1,
            'condition_id'       => 1,
            'band'               => 'Judas Priest',
            'album'              => 'Painkiller',
            'year'               => 1990,
            'for_change'         => 1,
            'description'        => 'Some description for item painkiller',
            'created_at'         => '2016-12-15',
            'updated_at'         => '2016-12-18'
        ]);

        DB::table('audio')->insert([
            'user_id'           => 1,
            'audio_category_id' => 2,
            'condition_id'      => 3,
            'band'              => 'Judas Priest',
            'album'             => 'British Steel',
            'for_change'        => 1,
            'description'       => 'Some description for item British Steel'
        ]);

        DB::table('audio')->insert([
            'user_id'           => 2,
            'audio_category_id' => 2,
            'condition_id'      => 3,
            'band'              => 'Band 1',
            'album'             => 'Album 1',
            'for_change'        => 1
        ]);

        DB::table('audio')->insert([
            'user_id'           => 2,
            'audio_category_id' => 2,
            'condition_id'      => 3,
            'band'              => 'Band 1',
            'album'             => 'Album 2',
            'for_change'        => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('audio');
    }
}
