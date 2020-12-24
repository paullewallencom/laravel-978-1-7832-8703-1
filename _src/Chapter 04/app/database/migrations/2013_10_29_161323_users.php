<?php

use Illuminate\Database\Migrations\Migration;

class Users extends Migration {

  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    //
    Schema::create('users', function($table){
      $table->increments('id');
      $table->string('username');
      $table->string('password');
      $table->boolean('is_admin');
      $table->timestamps();
    });
    Schema::table('cats', function($table){
      $table->integer('user_id')->nullable();
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
      $table->dropColumn('user_id');
    });
    Schema::drop('users');
  }

}
