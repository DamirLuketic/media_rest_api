<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('active')->default(0);
            $table->integer('confirmation_code');
            $table->boolean('admin')->default(0);
            $table->string('image_url')->nullable();
            $table->boolean('items_visible')->default(1);
            $table->boolean('email_available')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });

        // Dummy data
        DB::table('users')->insert([
            'name'              => 'Damir',
            'email'             => 'luketic.damir@gmail.com',
            'password'          => '$2y$10$KSoqCnSbvU6uoSexNku07OxRRsaLBcQrEek0eUyLbY5nD1AsUKoXu',
            'active'            => 1,
            'confirmation_code' => 0,
            'admin'             => 1
        ]);

        DB::table('users')->insert([
            'name'              => 'Darko',
            'email'             => 'luketic.darko@gmail.com',
            'password'          => '$2y$10$SB4h5t3kQVthkjYIH87mz.m/ID9/kopp522wCrrxZerOEu.uIcUv.',
            'active'            => 1,
            'confirmation_code' => 0,
            'admin'             => 0
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
