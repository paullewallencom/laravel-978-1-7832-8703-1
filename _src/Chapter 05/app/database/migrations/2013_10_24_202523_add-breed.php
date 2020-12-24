<?php

use Illuminate\Database\Migrations\Migration;

class AddBreed extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('breeds', function($table){
      $table->increments('id');
      $table->string('name');
    });

    Schema::table('cats', function($table){
      $table->integer('breed_id')->nullable();
      $table->foreign('breed_id')->references('id')->on('breeds');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::table('cats', function($table){
      $table->dropColumn('breed_id');
    });
    Schema::drop('breeds');
  }

}
