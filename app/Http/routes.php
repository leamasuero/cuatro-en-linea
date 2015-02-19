<?php

/*
  |--------------------------------------------------------------------------
  | Application Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register all of the routes for an application.
  | It's a breeze. Simply tell Laravel the URIs it should respond to
  | and give it the controller to call when that URI is requested.
  |
 */

Route::get('/games/{player}', [
    'as' => 'board', 'uses' => 'BoardController@play'
])->where('player', '[12]');

Route::post('/addCoin', [
    'as' => 'addCoin', 'uses' => 'BoardController@addCoin'
]);