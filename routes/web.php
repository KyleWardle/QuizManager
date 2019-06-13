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

Auth::routes(['verify' => false, 'register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/modals/confirm-delete', 'ModalController@confirm_delete')->name('confirm_delete_modal');

Route::get('/home/create', 'QuizController@create')->name('createQuiz');
Route::post('/quiz/create',
    'QuizController@submitCreate')->name('submitCreateQuiz');
Route::get('/home/{quizid}/edit', 'QuizController@edit')->name('editQuiz');
Route::post('/quiz/{quizid}/edit', 'QuizController@submitEdit')->name('submitEditQuiz');
Route::delete('/quiz/{quizid}/delete', 'QuizController@delete')->name('deleteQuiz');
Route::get('/quiz/{quizid}/attempts', 'QuizController@quizAttempts')->name('quizAttempts');

Route::get('/quiz/{quizid}/manage-questions/', 'QuestionController@manage')->name('manageQuestions');
Route::get('/quiz/{quizid}/new-question/', 'QuestionController@new')->name('newQuestion');
Route::post('/quiz/{quizid}/new-question/', 'QuestionController@submitNew')->name('submitNewQuestion');
Route::get('/quiz/{quizid}/edit-question/{questionid}', 'QuestionController@edit')->name('editQuestion');
Route::post('/quiz/{quizid}/edit-question/{questionid}', 'QuestionController@submitEdit')->name('submitEditQuestion');
Route::delete('/quiz/{quizid}/delete-question/{questionid}', 'QuestionController@delete')->name('deleteQuestion');

Route::get('/quiz/{quizid}/start-quiz', 'QuizTakingController@start')->name('startQuiz');
Route::get('/quiz/{quizid}/start-quiz/submit', 'QuizTakingController@submitStart')->name('submitStartQuiz');
Route::get('/quiz/{quizid}/take-quiz/{quizattemptid}', 'QuizTakingController@take')->name('takeQuiz');
Route::post('/quiz/{quizid}/grab-next-question/{quizattemptid}', 'QuizTakingController@grabNextQuestion')->name('grabNextQuestion');
Route::post('/quiz/{quizid}/save-quiz-answer/{quizattemptid}', 'QuizTakingController@saveAnswer')->name('saveQuizAnswer');
Route::get('/quiz/{quizid}/quiz-summary/{quizattemptid}', 'QuizTakingController@summary')->name('quizSummary');

Route::get('/users/management', 'UserController@manage')->name('manageUsers');
Route::get('/users/new', 'UserController@newUser')->name('newUser');
Route::post('/users/new', 'UserController@createUser')->name('createUser');
Route::get('/users/edit/{User}', 'UserController@editUser')->name('editUser');
Route::patch('/users/edit/{User}', 'UserController@updateUser')->name('updateUser');
Route::delete('/users/delete/{User}', 'UserController@deleteUser')->name('deleteUser');

Route::get('/attempts', 'QuizTakingController@myAttempts')->name('myAttempts');
