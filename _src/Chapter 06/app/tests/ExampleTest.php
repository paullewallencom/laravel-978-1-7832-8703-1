<?php

use Mockery\MockInterface;

class ExampleTest extends TestCase {

    public function setUp() {
        parent::setUp();
        Artisan::call('migrate');
        $this->seed();
    }

    public function testHomePageRedirection() {
        $this->call('GET', '/');
        $this->assertRedirectedTo('cats');
    }

    public function testVisitorIsRedirected() {
        Route::enableFilters();
        $this->call('GET', '/cats/create');
        $this->assertRedirectedTo('login');
    }

    public function testLoggedInUserCanCreateCat() {
        Route::enableFilters();
        $user = new User(array('name'=>'John Doe', 'is_admin'=>false));
        $this->be($user);
        $this->call('GET', '/cats/create');
        $this->assertResponseOk();
    }

    public function testNonAdminCannotEditCat() {
        $user = new User(array('id'=>2, 'name'=>'Owner','is_admin'=>false));
        $this->be($user);
        $this->call('PUT', '/cats/1');
        $this->assertRedirectedTo('/cats/1');
        $this->assertSessionHas('error');
    }

    public function testAdminCanEditCat() {
        $user = new User(array('id'=>3, 'name'=>'Admin', 'is_admin'=>true));
        $this->be($user);
        $new_name = 'Berlioz';
        $this->call('PUT', '/cats/1', array('name' => $new_name));
        $crawler = $this->client->request('GET', '/cats/1');
        $this->assertCount(1, $crawler->filter('h2:contains("'.$new_name.'")'));
    }

}
