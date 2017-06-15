<?php


Route::group(array('before' => 'auth|levelController:1'), function (){

    Route::get('/tag', 'HomeController@addTag');

    Route::post('/tag', 'HomeController@doOpOnTag');

    Route::get('/addAdviser', 'HomeController@addAdviser');

    Route::post('/addAdviser', 'HomeController@doAddAdviser');

    Route::get('/addStudent', 'HomeController@addStudent');

    Route::post('/addStudent', 'HomeController@doAddStudent');

    Route::get('/addQuiz', 'HomeController@addQuiz');

    Route::post('/addQuiz', 'HomeController@doAddQuiz');

    Route::get('/grades', 'ReportHandler@grades');

    Route::post('/grades', 'ReportHandler@opOnGrades');

    Route::get('/lessons', 'LessonController@lessons');

    Route::post('/lessons', 'LessonController@opOnLessons');

    Route::get('/subjects', 'ReportHandler@subjects');

    Route::post('/subjects', 'ReportHandler@opOnSubjects');

    Route::get('/quizes', 'ReportHandler@quizes');

    Route::get('/stages', 'ReportHandler@stages');

    Route::post('/quizes', 'ReportHandler@opOnQuiz');

    Route::post('getLessonsByChangingDegree', 'AjaxHandler@getLessons');
});


Route::group(array('before' => 'auth|levelController:1'), function() {

    Route::post('addLessonBatch', 'LessonController@addBatch');

});

Route::group(array('before' => 'auth'), function (){

    Route::get('/', 'HomeController@home');

    Route::get('home', 'HomeController@home');

    Route::get('logout', 'HomeController@logout');

    Route::get('/schedules', 'SchedulerController@addSchedule');

    Route::post('/schedules', 'SchedulerController@doAddSchedule');

    Route::get('/schedule={schedulerId}', 'SchedulerController@schedule');
});


Route::get('login', 'HomeController@login');

Route::post('login', 'HomeController@doLogin');

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