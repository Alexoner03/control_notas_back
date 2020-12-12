<?php
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

Route::post('login', 'UserController@login')->name('login');
Route::post('login-admin', 'UserController@loginAdm')->name('login.admin');

Route::group(['middleware' => 'auth:api'], function () {

    Route::get('logout', 'UserController@logout')->name('logout');
    Route::get('user', 'UserController@getAuthenticatedUser')->name('user');
    Route::middleware('roles:administrador')->post('users/{role}/create','UserController@create')->name('create.user');
    Route::middleware('roles:administrador')->get('users/{role}/list','UserController@listByRole')->name('list.user.rol');
    Route::middleware('roles:administrador')->delete('users/{id}/delete','UserController@delete')->name('delete.user');
    Route::patch('users/{id}/edit','UserController@edit')->name('edit.user');

    // ---------------------------------------------------
    Route::get('roles','RoleController@index')->name('roles.index');

    //----------------------------------------------------
    Route::middleware('roles:administrador')->post('courses/create','CourseController@create')->name('create.course');
    Route::middleware('roles:administrador')->patch('courses/{id}/edit','CourseController@edit')->name('edit.course');
    Route::middleware('roles:administrador')->delete('courses/{id}/delete','CourseController@delete')->name('delete.course');
    Route::get('courses/{id}/list-teacher','CourseController@listByTeacher')->name('list.teacher.courses');
    Route::get('courses','CourseController@listAll')->name('all.course');
    Route::get('courses/{id}/detail','CourseController@detail')->name('detail.course');
    Route::middleware('roles:docente')->patch('courses/calificate','CourseController@updateCalification')->name('patch.course.note');

    //-----------------------------------------------------
    Route::get('teachers','TeacherController@listAll')->name('all.teachers');

    Route::get('students/{id}/courses','StudentController@listMyCourses')->name('student.mycourses');
    Route::get('students/{id}/courses-availables','StudentController@listMyCoursesAvailables')->name('student.mycourses.availables');
    Route::post('students/enroll','StudentController@enroll')->name('student.enroll');

    Route::get('allStadisctics','AllController@allData')->name('all.data');

});

