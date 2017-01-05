<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('category_id');
            $table->integer('condition_id')->nullable();
            $table->string('m_name')->nullable();
            $table->string('m_director')->nullable();
            $table->string('m_actor')->nullable();
            $table->string('a_band')->nullable();
            $table->string('a_album')->nullable();
            $table->integer('year')->nullable();
            $table->boolean('for_change')->default(0);
            $table->text('comment')->nullable();
            $table->boolean('allowed')->default(1);
            $table->timestamps();
        });

        DB::table('media')->insert([
            'user_id' => 1,
            'category_id' => 1,
            'condition_id' => 4,
            'a_band' => 'Judas Priest',
            'a_album' => 'Painkiller',
            'year' => 1990,
            'for_change' => 1
        ]);

        DB::table('media')->insert([
            'user_id' => 1,
            'category_id' => 1,
            'condition_id' => 5,
            'a_band' => 'Leonard Cohen',
            'a_album' => 'You Want It Darker',
            'year' => 2016,
            'for_change' => 1
        ]);

        DB::table('media')->insert([
            'user_id' => 1,
            'category_id' => 2,
            'condition_id' => 4,
            'a_band' => 'Judas Priest',
            'a_album' => 'Screaming For Vengeance',
            'year' => 1982,
            'for_change' => 1
        ]);

        DB::table('media')->insert([
            'user_id' => 1,
            'category_id' => 3,
            'condition_id' => 5,
            'm_name' => 'Hellraiser IV',
            'year' => 1996,
            'for_change' => 1
        ]);

        DB::table('media')->insert([
            'user_id' => 1,
            'category_id' => 4,
            'condition_id' => 4,
            'm_name' => 'Nightbreed',
            'year' => 1990,
            'for_change' => 1
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
