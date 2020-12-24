<?php

use Illuminate\Database\Migrations\Migration;

class Initial extends Migration {

  public function up()
  {
    Schema::create('cats', function($table){
      $table->increments('id');
      $table->string('name');
      $table->date('date_of_birth')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Schema::drop('cats');
  }

}
