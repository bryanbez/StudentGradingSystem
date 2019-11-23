<?php

Route::get('/', function () {
    return view('app');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('{any}', function() {
    return view('app');
})->where('any', '.*');
