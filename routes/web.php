<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('index');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Users routes
Route::get('/users', 'UserController@index')->name('users.index');

// Project routes
Route::get('/project', 'ProjectController@index')->name('project.index');
Route::post('/project', 'ProjectController@store');

// Pages routes
Route::get('/pages', 'PageController@index')->name('pages.index');

// Sentences routes
Route::get('/sentences', 'SentenceController@index')->name('sentences.index');

// Annotation routes
Route::get('/annotations', 'AnnotationController@index')->name('annotations.index');
Route::get('/annotations/create', 'AnnotationController@create')->name('annotations.create');
Route::get('/annotations/{sentence}/edit', 'AnnotationController@edit')->name('annotations.edit');
Route::put('/annotations/{sentence}', 'AnnotationController@update');

/**
 * Delete sentence and page option
 * Count of the users annotation
 * Progress bar when process files and populate database
 * Change input text when import file
 */
