<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('address')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();
            $table->string('image')->nullable();
            $table->string('latitude', 30)->nullable();
            $table->string('longitude', 30)->nullable();
            $table->timestamps();
        });

        Schema::create('place_translations', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('place_id')->unsigned();
            $table->string('locale')->index();
            $table->boolean('status')->default(0);
            $table->string('title');
            $table->string('slug')->nullable();
            $table->text('summary');
            $table->text('body');
            $table->timestamps();
            $table->unique(['place_id', 'locale']);
            $table->unique(['locale', 'slug']);
            $table->foreign('place_id')->references('id')->on('places')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('place_translations');
        Schema::drop('places');
    }
}
