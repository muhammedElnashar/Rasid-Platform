<?php

use App\Http\Controllers\Auth\CustomResetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware('guest')->group(function () {
    Route::get('custom-reset-password/{token}', [CustomResetPasswordController::class, 'showResetForm'])->name('custom.password.reset');
    Route::post('custom-reset-password', [CustomResetPasswordController::class, 'reset'])->name('custom.password.update');

});
    // Super Admin Route
Route::middleware('auth')->middleware('isSuperAdmin')->group(function () {
    Route::resource('admin', \App\Http\Controllers\SuperAdmin\SchoolAdminController::class);
    Route::post('admin/activate/{admin}', [\App\Http\Controllers\SuperAdmin\SchoolAdminController::class, 'activate'])->name('admin.activate');
    Route::post('admin/deactivate/{admin}', [\App\Http\Controllers\SuperAdmin\SchoolAdminController::class, 'deactivate'])->name('admin.deactivate');
    Route::resource('school', \App\Http\Controllers\SuperAdmin\SchoolController::class);
});





Route::group(['middleware' => ['auth','check.user.status']], function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // ----------------------------------------schoolAdmin----------------------------------------------------------
    // -> Users
    Route::resource('users', \App\Http\Controllers\SchoolAdmin\UserController::class);
    Route::post('user/activate/{user}', [\App\Http\Controllers\SchoolAdmin\UserController::class, 'activate'])->name('user.activate');
    Route::post('user/deactivate/{user}', [\App\Http\Controllers\SchoolAdmin\UserController::class, 'deactivate'])->name('user.deactivate');
    Route::get('bulk/users',[\App\Http\Controllers\SchoolAdmin\UserController::class,'bulkUser'])->name('bulk.users');
    Route::post('import/bulk/users',[\App\Http\Controllers\SchoolAdmin\UserController::class,'import'])->name('import.bulk.users');
    Route::resource('subjects', \App\Http\Controllers\SchoolAdmin\SubjectController::class);
    Route::resource('teacher-subject-classes', \App\Http\Controllers\SchoolAdmin\TeacherSubjectClassController::class);
    Route::resource('student-classes', \App\Http\Controllers\SchoolAdmin\StudentClassController::class);
    Route::resource('student-subjects', \App\Http\Controllers\SchoolAdmin\StudentSubjectsController::class);
    Route::resource('student-guardian', \App\Http\Controllers\SchoolAdmin\StudentGuardiansController::class);
    // School
    Route::get('school-data', [App\Http\Controllers\SchoolAdmin\SchoolDataController::class, 'edit'])->name('school.data.edit');
    Route::put('school-data', [App\Http\Controllers\SchoolAdmin\SchoolDataController::class, 'update'])->name('school.data.update');
    // Stage->Grades->Classes
    Route::resource('stages', \App\Http\Controllers\SchoolAdmin\StagesController::class);
    Route::resource('stages.grades', \App\Http\Controllers\SchoolAdmin\GradesController::class);
    Route::resource('stages.grades.classes', \App\Http\Controllers\SchoolAdmin\ClassesController::class);
    // Card->Categories->items
    Route::resource('cards', \App\Http\Controllers\SchoolAdmin\CardController::class);
    Route::resource('cards.categories', \App\Http\Controllers\SchoolAdmin\CardCategoryController::class);
    Route::resource('cards.categories.items', \App\Http\Controllers\SchoolAdmin\CardItemsController::class);
    //Card Issues
    Route::resource('issues', \App\Http\Controllers\SchoolAdmin\CardIssueController::class);
    Route::put('issues/approved/{issue}',[\App\Http\Controllers\SchoolAdmin\CardIssueController::class,'approved'])->name('issues.approved');
    Route::put('issues/rejected/{issue}',[\App\Http\Controllers\SchoolAdmin\CardIssueController::class,'rejected'])->name('issues.rejected');
    Route::put('issues/unrestricted/{issue}',[\App\Http\Controllers\SchoolAdmin\CardIssueController::class,'unrestricted'])->name('issues.unrestricted');
    // Deduction Card
    Route::resource('deduction-cards', \App\Http\Controllers\SchoolAdmin\DeductionCardController::class);
    // Recharge Card
    Route::resource('recharge-cards', \App\Http\Controllers\SchoolAdmin\RechargeCardController::class);
    Route::get('recharge/page',[\App\Http\Controllers\SchoolAdmin\RechargeCardController::class,'assignCard'])->name('recharge.page');
    Route::get('recharge/list',[\App\Http\Controllers\SchoolAdmin\RechargeCardController::class,'list'])->name('recharge.list');
    Route::post('recharge/assign',[\App\Http\Controllers\SchoolAdmin\RechargeCardController::class,'assign'])->name('recharge.assign');
    Route::post('recharge-cards/activation/{rechargeCardUser}',[\App\Http\Controllers\SchoolAdmin\RechargeCardController::class,'active'])->name('recharge-cards.activation');
    //Category->Layers->Levels
    Route::resource('categories', \App\Http\Controllers\SchoolAdmin\CategoryController::class);
    Route::resource('categories.layers', \App\Http\Controllers\SchoolAdmin\LayersController::class);
    Route::resource('categories.layers.levels', \App\Http\Controllers\SchoolAdmin\LevelController::class);
    //insignias
    Route::resource('insignias', \App\Http\Controllers\SchoolAdmin\InsigniaController::class);
    Route::get('insignias/assign/page', [\App\Http\Controllers\SchoolAdmin\InsigniaController::class,'assignPage'])->name('insignias.assign.page');
    Route::post('insignias/assign', [\App\Http\Controllers\SchoolAdmin\InsigniaController::class,'assign'])->name('insignias.assign');
    Route::get('users/insignias/list', [\App\Http\Controllers\SchoolAdmin\InsigniaController::class,'listPage'])->name('users.insignias.list');
    //Badges
    Route::resource('badges', \App\Http\Controllers\SchoolAdmin\BadgeController::class);
    Route::get('users/badges/list', [\App\Http\Controllers\SchoolAdmin\BadgeController::class,'list'])->name('users.badges.list');
    //Logs
    Route::resource('logs', \App\Http\Controllers\SchoolAdmin\BehaviorLogController::class);
    Route::put('logs/approve/{log}', [\App\Http\Controllers\SchoolAdmin\BehaviorLogController::class, 'approve'])->name('logs.approve');
    Route::put('logs/reject/{log}', [\App\Http\Controllers\SchoolAdmin\BehaviorLogController::class, 'reject'])->name('logs.reject');
    Route::post('activation/logs/{log}',[\App\Http\Controllers\SchoolAdmin\BehaviorLogController::class,'activation'])->name('activation.logs');
    //Market
    Route::resource('awards', \App\Http\Controllers\SchoolAdmin\StoreItemController::class);
    Route::get('exchange/requests',[\App\Http\Controllers\SchoolAdmin\RedemptionRequestController::class,'requests'])->name('exchange.requests');
    Route::put('exchange/requests/approved/{request}',[\App\Http\Controllers\SchoolAdmin\RedemptionRequestController::class,'approvedRequest'])->name('exchange.requests.approved');
    Route::put('exchange/requests/reject/{request}',[\App\Http\Controllers\SchoolAdmin\RedemptionRequestController::class,'rejectRequest'])->name('exchange.requests.reject');
    // Transfers
    Route::get('transfers',[\App\Http\Controllers\SchoolAdmin\PointTransferController::class,'index'])->name('transfer.index');
    Route::put('transfer/approved/{transfer}',[\App\Http\Controllers\SchoolAdmin\PointTransferController::class,'approved'])->name('transfer.approved');
    Route::put('transfer/rejected/{transfer}',[\App\Http\Controllers\SchoolAdmin\PointTransferController::class,'rejected'])->name('transfer.rejected');

    Route::middleware('CheckNormalUser')->group(function (){
        //market
        Route::get('market',[\App\Http\Controllers\Users\MarketController::class,'marketItem'])->name('market-item');
        Route::post('exchange',[\App\Http\Controllers\Users\MarketController::class,'exchange'])->name('market.exchange');
        Route::get('user/awards',[\App\Http\Controllers\Users\MarketController::class,'userAward'])->name('user.awards');
        //logs
        Route::get('user/logs',[\App\Http\Controllers\Users\ProfileController::class,'userLogs'])->name('user.logs');
        //Issue
        Route::get('unsettled-issues',[\App\Http\Controllers\Users\ProfileController::class,'unsettledIssue'])->name('unsettled.issues');
        Route::get('approved-issues',[\App\Http\Controllers\Users\ProfileController::class,'approvedIssue'])->name('issues.approved.index');
        Route::put('settle/{issue}',[\App\Http\Controllers\Users\ProfileController::class,'settle'])->name('issue.settle');
        //transfer
        Route::get('transfer/create',[\App\Http\Controllers\SchoolAdmin\PointTransferController::class,'create'])->name('transfer.create');
        Route::post('transfer/store',[\App\Http\Controllers\SchoolAdmin\PointTransferController::class,'store'])->name('transfer.store');
        Route::get('all-transfers',[\App\Http\Controllers\Users\ProfileController::class,'transfers'])->name('all.transfers');
        //deduction Card
        Route::get('deductions-cards',[\App\Http\Controllers\Users\ProfileController::class,'deductionCards'])->name('deductions-cards.list');
        //Recharge Card
        Route::get('user-recharge-cards',[\App\Http\Controllers\Users\ProfileController::class,'userCard'])->name('user.recharge.cards');
        Route::get('user-recharge-page',[\App\Http\Controllers\Users\ProfileController::class,'rechargePage'])->name('user.recharge.page');
        Route::post('user-recharge',[\App\Http\Controllers\Users\ProfileController::class,'recharge'])->name('user.recharge');
        //Profile
        Route::get('profile',[\App\Http\Controllers\Users\ProfileController::class,'UserProfile'])->name('profile');
    });

});

