<?php

use App\Http\Controllers\Auth\CustomResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('guest')->group(function () {
    Route::get('custom-reset-password/{token}', [CustomResetPasswordController::class, 'showResetForm'])->name('custom.password.reset');
    Route::post('custom-reset-password', [CustomResetPasswordController::class, 'reset'])->name('custom.password.update');

});
Route::middleware('auth')->middleware('isSuperAdmin')->group(function () {
    Route::resource('admin', \App\Http\Controllers\SuperAdmin\SchoolAdminController::class);
    Route::resource('school', \App\Http\Controllers\SuperAdmin\SchoolController::class);

});





Route::group(['middleware' => ['auth']], function () {
    Route::resource('users', \App\Http\Controllers\SchoolAdmin\UserController::class);
    Route::resource('subjects', \App\Http\Controllers\SchoolAdmin\SubjectController::class);
    Route::resource('teacher-subject-classes', \App\Http\Controllers\SchoolAdmin\TeacherSubjectClassController::class);
    Route::resource('student-classes', \App\Http\Controllers\SchoolAdmin\StudentClassController::class);
    Route::resource('stages', \App\Http\Controllers\SchoolAdmin\StagesController::class);
    Route::resource('stages.grades', \App\Http\Controllers\SchoolAdmin\GradesController::class);
    Route::resource('stages.grades.classes', \App\Http\Controllers\SchoolAdmin\ClassesController::class);

    Route::get('school-data', [App\Http\Controllers\SchoolAdmin\SchoolDataController::class, 'edit'])->name('school.data.edit');
    Route::put('school-data', [App\Http\Controllers\SchoolAdmin\SchoolDataController::class, 'update'])->name('school.data.update');

});

