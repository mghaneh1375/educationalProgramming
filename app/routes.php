<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', array('before' => 'auth', 'uses' => 'HomeController@home'));

Route::get('/home', array('before' => 'auth', 'uses' => 'HomeController@home'));

Route::get('/logout', 'HomeController@logout');

Route::get('/tag', array('before' => 'auth|levelController:1', 'uses' => 'HomeController@addTag'));

Route::post('/tag', array('before' => 'auth|levelController:1', 'uses' => 'HomeController@doOpOnTag'));

Route::get('/addAdviser', array('before' => 'auth|levelController:1', 'uses' => 'HomeController@addAdviser'));

Route::post('/addAdviser', array('before' => 'auth|levelController:1', 'uses' => 'HomeController@doAddAdviser'));

Route::get('/addStudent', array('before' => 'auth|levelController:2', 'uses' => 'HomeController@addStudent'));

Route::post('/addStudent', array('before' => 'auth|levelController:2', 'uses' => 'HomeController@doAddStudent'));

Route::get('/addQuiz', array('before' => 'auth|levelController:1', 'uses' => 'HomeController@addQuiz'));

Route::post('/addQuiz', array('before' => 'auth|levelController:1', 'uses' => 'HomeController@doAddQuiz'));

Route::get('/schedules', array('before' => 'auth', 'uses' => 'SchedulerController@addSchedule'));

Route::post('/schedules', array('before' => 'auth', 'uses' => 'SchedulerController@doAddSchedule'));

Route::get('/schedule={schedulerId}', array('before' => 'auth', 'uses' => 'SchedulerController@schedule'));

Route::get('/login', 'HomeController@login');

Route::post('/login', 'HomeController@doLogin');

Route::get('/grades', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@grades'));

Route::post('/grades', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@opOnGrades'));

Route::get('/lessons', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@lessons'));

Route::post('/lessons', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@opOnLessons'));

Route::get('/subjects', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@subjects'));

Route::post('/subjects', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@opOnSubjects'));

Route::get('/quizes', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@quizes'));

Route::get('/stages', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@stages'));

Route::post('/quizes', array('before' => 'auth|levelController:1', 'uses' => 'ReportHandler@opOnQuiz'));

Route::post('getLessonsByChangingDegree', 'AjaxHandler@getLessons');

Route::post('getSubjectsByChangingLesson', 'AjaxHandler@getSubjects');

Route::post('getStepsByChangingQuiz', 'AjaxHandler@getSteps');

Route::post('getMySchedules', 'AjaxHandler@getMySchedules');

Route::post('isThisTagProgrammable', 'AjaxHandler@isThisTagProgrammable');

Route::post('getSubjectsByChangingStep', 'AjaxHandler@getSubjectsByChangingStep');

Route::post('getDefaultTagAndSubject', 'AjaxHandler@getDefaultTagAndSubject');

Route::post('changeScheduleItem', 'AjaxHandler@changeScheduleItem');

Route::post('addNewAssign', 'AjaxHandler@addNewAssign');

Route::post('createPDF', 'AjaxHandler@createPDF');

Route::post('sendToTelegram', 'AjaxHandler@sendToTelegram');

Route::post('deleteSelectedSubjectFromAssign', 'AjaxHandler@deleteSelectedSubjectFromAssign');