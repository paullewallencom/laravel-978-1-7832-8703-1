<?php

Route::model('cat', 'Cat');

View::composer('cats.edit', function($view)
{
  $breeds = Breed::all();
  $breed_options = array_combine($breeds->lists('id'), $breeds->lists('name'));
  $view->with('breed_options', $breed_options);
});

Route::get('/', function() {
  return Redirect::to("cats");
});

Route::get('about', function(){
  return View::make('about')->with('number_of_cats', 9000);
});


Route::get('cats', function(){
  $cats = Cat::all();
  return View::make('cats/index')
    ->with('cats', $cats);
});

Route::get('cats/breeds/{name}', function($name){
  $breed = Breed::whereName($name)->with('cats')->first();
  return View::make('cats/index')
    ->with('breed', $breed)
    ->with('cats', $breed->cats);
});


Route::get('cats/{id}', function($id) {
  $cat = Cat::find($id);
  return View::make('cats.single')
    ->with('cat', $cat);
})->where('id', '[0-9]+');

Route::group(array('before'=>'auth'), function(){

  Route::get('cats/create', function() {
    $cat = new Cat;
    return View::make('cats.edit')
      ->with('cat', $cat)
      ->with('method', 'post');
  });

  Route::get('cats/{cat}/edit', function(Cat $cat) {
    if(Auth::user()->canEdit($cat)){
      return View::make('cats.edit')
        ->with('cat', $cat)
        ->with('method', 'put');
    } else {
      return Redirect::to('cats/' . $cat->id)
        ->with('error', "You are not allowed to edit this profile");
    }
  });

  Route::get('cats/{cat}/delete', function(Cat $cat) {
    if(Auth::user()->canEdit($cat)){
      return View::make('cats.edit')
        ->with('cat', $cat)
        ->with('method', 'delete');
    } else {
      return Redirect::to('cats/' . $cat->id)
        ->with('error', "You are not allowed to delete this profile");
    }
  });

  Route::group(array('before'=>'csrf'), function(){
    Route::post('cats', function(){
      $cat = Cat::create(Input::all());
      $cat->user_id = Auth::user()->id;
      $cat->save();
      return Redirect::to('cats/' . $cat->id)
        ->with('message', 'Successfully created profile!');
    });

    Route::put('cats/{cat}', function(Cat $cat) {
      if(Auth::user()->canEdit($cat)){
        $cat->update(Input::all());
        return Redirect::to('cats/' . $cat->id)
          ->with('message', 'Successfully updated profile!');
      } else {
        return Redirect::to('cats/' . $cat->id)
          ->with('error', "You are not allowed to edit this profile");
      }
    });

    Route::delete('cats/{cat}', function(Cat $cat) {
      if(Auth::user()->canEdit($cat)){
        $cat->delete();
        return Redirect::to('cats')
          ->with('message', 'Successfully deleted profile!');
      } else {
        return Redirect::to('cats/' . $cat->id)
          ->with('error', "You are not allowed to delete this profile");
      }
    });
  });

});

Route::get('login', array('before'=>'guest', function(){
  return View::make('login');
}));
Route::post('login', function(){
  if(Auth::attempt(Input::only('username', 'password')))
    return Redirect::intended('/');
  else
    return Redirect::back()
      ->withInput()
      ->with('error', "Invalid credentials");
});
Route::get('logout', array('before'=>'csrf', function(){
  Auth::logout();
  return Redirect::to('/')
    ->with('message', 'You are now logged out');
}));


Route::get('sql-injection-vulnerable', function(){
  $name = "'Bobby' OR 1=1";
  return DB::select( DB::raw("SELECT * FROM cats WHERE name = $name") );
});

Route::get('sql-injection-not-vulnerable', function(){
  $name = "'Bobby' OR 1=1";
  return DB::select(
    DB::raw("SELECT * FROM cats WHERE name = ?", array($name)));
});


