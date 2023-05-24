<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Auth')->middleware(['guest:api'])->group(function() {
    Route::post('auth/login', 'AuthenticationController@login');
//    Route::post('auth/refresh', 'AuthenticationController@refresh');
    Route::post('auth/password/email', 'AuthenticationController@sendResetLinkEmail');
    Route::post('auth/password/reset', 'AuthenticationController@resetPassword');
    Route::get('auth/check-token-expired', 'AuthenticationController@checkExpiredForgotPasswordToken');
});

Route::middleware(['auth:sanctum'])->group(function() {
    Route::namespace('Auth')->group(function () {
        Route::get('auth/profile', 'AuthenticationController@profile');
        Route::post('auth/profile', 'AuthenticationController@updateProfile');
        Route::post('auth/logout', 'AuthenticationController@logout');
    });

    Route::namespace('Api')->group(function () {
        Route::get('users', 'UserController@index')->name('users.index');
        Route::post('users', 'UserController@store')->name('users.store');
        Route::put('users/{id}', 'UserController@update')->name('users.update');
        Route::get('users/{id}', 'UserController@detail')->name('users.detail');
        Route::delete('users/{id}', 'UserController@delete')->name('users.delete');

        // Category
        Route::get('categories', 'CategoryController@index')->name('categories.index');
        Route::post('categories', 'CategoryController@updateOrCreate')->name('categories.updateOrCreate');
        Route::delete('categories/{id}', 'CategoryController@delete')->name('categories.delete');

        //Teacher
        Route::get('teachers', 'TeacherController@index')->name('teacher.index');
        Route::put('teachers/{id}', 'TeacherController@update')->name('teacher.update');
        Route::post('teachers', 'TeacherController@create')->name('teacher.create');
        Route::get('teachers/{id}', 'TeacherController@detail')->name('teacher.detail');
        Route::delete('teachers/{id}', 'TeacherController@delete')->name('teacher.delete');
        Route::get('assign-subject-to-teacher/{id}', 'TeacherController@assignSubject')->name('teacher.assign.subject');

        //Student
        Route::get('students', 'StudentController@index')->name('student.index');
        Route::post('students', 'StudentController@create')->name('student.create');
        Route::put('students/{id}', 'StudentController@update')->name('student.update');
        Route::get('students/{id}', 'StudentController@detail')->name('student.detail');
        Route::delete('students/{id}', 'StudentController@delete')->name('student.delete');

        //Grade
        Route::get('grades', 'GradeController@index')->name('grade.index');
        Route::post('grades', 'GradeController@create')->name('grade.create');

        Route::get('assign-subject-to-class/{id}', 'GradeController@assignSubject')->name('grade.assign.subject');
        Route::post('assign-subject-to-class/{id}', 'GradeController@storeAssignedSubject')->name('store.class.assign.subject');
        Route::put('grades/{id}', 'GradeController@update')->name('grade.update');
        Route::get('grades/{id}', 'GradeController@detail')->name('grade.detail');

        //Subject
        Route::get('subjects', 'SubjectController@index')->name('subject.index');
        Route::post('subjects', 'SubjectController@create')->name('subject.create');
        Route::put('subjects/{id}', 'SubjectController@update')->name('subject.update');
        Route::delete('subjects/{id}', 'SubjectController@delete')->name('subject.delete');
    });
});
