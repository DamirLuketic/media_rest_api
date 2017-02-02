<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('url');
            $table->boolean('featured')->default(0);
            $table->integer('imageable_id');
            $table->string('imageable_type');
            $table->timestamps();
        });

        // Dummy data
            // Audio
        DB::table('images')->insert([
            'url'            => 'http://domaingang.com/wp-content/uploads/2012/02/example.png',
            'featured'       => 1,
            'imageable_id'   => 1,
            'imageable_type' => 'App\Audio'
        ]);

        DB::table('images')->insert([
            'url'            => 'http://www.apicius.es/wp-content/uploads/2012/07/IMG-20120714-009211.jpg',
            'imageable_id'   => 1,
            'imageable_type' => 'App\Audio'
        ]);

        DB::table('images')->insert([
            'url'            => 'http://www.apicius.es/wp-content/uploads/2012/07/IMG-20120714-009211.jpg',
            'imageable_id'   => 1,
            'imageable_type' => 'App\Audio'
        ]);
            // Video
        DB::table('images')->insert([
            'url'            => 'image 4',
            'featured'       => 1,
            'imageable_id'   => 1,
            'imageable_type' => 'App\Video'
        ]);

        DB::table('images')->insert([
            'url'            => 'image 5',
            'imageable_id'   => 1,
            'imageable_type' => 'App\Video'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('images');
    }
}
