<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('video_category_id');
            $table->integer('condition_id');
            $table->string('name');
            $table->string('director')->nullable();
            $table->integer('year')->nullable();
            $table->boolean('for_change')->default(0);
            $table->text('description')->nullable();
            $table->boolean('allowed')->default(1);
            $table->timestamps();
        });

        // Dummy data
        DB::table('videos')->insert([
            'user_id' => 1,
            'video_category_id' => 1,
            'condition_id' => 2,
            'name' => 'The Silence of the Lambs',
            'year' => 1991,
            'for_change' => 1,
        ]);

        DB::table('videos')->insert([
            'user_id' => 1,
            'video_category_id' => 2,
            'condition_id' => 3,
            'name' => 'Hannibal',
            'for_change' => 1,
        ]);

        DB::table('videos')->insert([
            'user_id' => 2,
            'video_category_id' => 2,
            'condition_id' => 3,
            'name' => 'Some Video',
            'for_change' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('videos');
    }
}
