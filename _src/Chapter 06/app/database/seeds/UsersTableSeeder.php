<?php

class UsersTableSeeder extends Seeder {
  public function run(){
    DB::table('users')->insert(array(
      array('username' => 'admin', 'password' => Hash::make('hunter2'),
        'is_admin' => true, 'created_at' => new DateTime, 'updated_at' => new DateTime),
      array('username' => 'scott', 'password' => Hash::make('tiger'),
      'is_admin' => false,'created_at' => new DateTime, 'updated_at' => new DateTime)
    ));
  }
}
