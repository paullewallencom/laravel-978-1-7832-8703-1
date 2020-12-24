<?php

class CatsTableSeeder extends Seeder {
  public function run(){
    Cat::create(array('id'=>1, 'name'=>'Figaro', 'user_id'=>1));
  }
}
