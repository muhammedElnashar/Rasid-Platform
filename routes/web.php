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
    Route::get('profile',[\App\Http\Controllers\ProfileController::class,'UserProfile'])->name('profile');
    Route::resource('subjects', \App\Http\Controllers\SchoolAdmin\SubjectController::class);
    Route::resource('teacher-subject-classes', \App\Http\Controllers\SchoolAdmin\TeacherSubjectClassController::class);
    Route::resource('student-classes', \App\Http\Controllers\SchoolAdmin\StudentClassController::class);
    Route::resource('student-guardian', \App\Http\Controllers\SchoolAdmin\StudentGuardiansController::class);
    Route::resource('stages', \App\Http\Controllers\SchoolAdmin\StagesController::class);
    Route::resource('stages.grades', \App\Http\Controllers\SchoolAdmin\GradesController::class);
    Route::resource('stages.grades.classes', \App\Http\Controllers\SchoolAdmin\ClassesController::class);
    Route::resource('cards', \App\Http\Controllers\SchoolAdmin\CardController::class);
    Route::resource('cards.categories', \App\Http\Controllers\SchoolAdmin\CardCategoryController::class);
    Route::resource('cards.categories.items', \App\Http\Controllers\SchoolAdmin\CardItemsController::class);
    Route::resource('issues', \App\Http\Controllers\SchoolAdmin\CardIssueController::class);
    Route::get('approved-issues',[\App\Http\Controllers\SchoolAdmin\CardIssueController::class,'approvedIssues'])->name('issues.approved.index');
    Route::put('approved/{issue}',[\App\Http\Controllers\SchoolAdmin\CardIssueController::class,'approved'])->name('issues.approved');
    Route::get('rejected-issues',[\App\Http\Controllers\SchoolAdmin\CardIssueController::class,'rejectedIssues'])->name('issues.rejected.index');
    Route::delete('rejected/{issue}',[\App\Http\Controllers\SchoolAdmin\CardIssueController::class,'rejected'])->name('issues.rejected');
    Route::put('settle/{issue}',[\App\Http\Controllers\ProfileController::class,'settle'])->name('issue.settle');
    Route::get('school-data', [App\Http\Controllers\SchoolAdmin\SchoolDataController::class, 'edit'])->name('school.data.edit');
    Route::put('school-data', [App\Http\Controllers\SchoolAdmin\SchoolDataController::class, 'update'])->name('school.data.update');

});

