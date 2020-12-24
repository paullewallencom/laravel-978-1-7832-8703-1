<?php

use Illuminate\Database\Migrations\Migration;

class Initial extends Migration {

    public function up(){
        Schema::create('cats', function($table){
            $table->increments('id');
            $table->string('name');
            $table->date('date_of_birth');
            $table->integer('breed_id')->nullable();
            $table->timestamps();
        });
        Schema::create('breeds', function($table){
            $table->increments('id');
            $table->string('name');
        });
    }
    public function down(){
        Schema::drop('cats');
        Schema::drop('breeds');
    }

}
