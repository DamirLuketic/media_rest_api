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
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('active')->default(0);
            $table->integer('confirmation_code');
            $table->boolean('admin')->default(0);
            $table->boolean('visible')->default(1);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            'name'              => 'Damir',
            'email'             => 'luketic.damir@gmail.com',
            'password'          => '$2y$10$KSoqCnSbvU6uoSexNku07OxRRsaLBcQrEek0eUyLbY5nD1AsUKoXu',
            'active'            => 1,
            'confirmation_code' => 0,
            'admin'             => 1
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
