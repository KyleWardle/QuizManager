<?php

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
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home')->middleware('verified');

Route::get('/home/create', 'QuizController@create')->name('createQuiz');
Route::post('/quiz/create', 'QuizController@submitCreate')->name('submitCreateQuiz');
Route::get('/home/edit/{quizid}', 'QuizController@edit')->name('editQuiz');
Route::post('/quiz/edit/{quizid}', 'QuizController@submitEdit')->name('submitEditQuiz');
Route::get('/quiz/delete/{quizid}', 'QuizController@delete')->name('deleteQuiz');
