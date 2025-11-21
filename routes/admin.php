<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\InvestmentProjectController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\InvestorController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\DistributionController;
use App\Http\Controllers\Admin\InvestmentContractController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\IslamicFinanceController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\AdministrationController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\NotificationController;


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'auth'], function () {

    // Dashboard route – faqat index
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Foydalanuvchilar – resource
    Route::resource('users', UserController::class);

    // Investitsion loyihalar
    Route::resource('investment-projects', InvestmentProjectController::class);

    // Tushumlar
    Route::resource('revenues', RevenueController::class);

    // Daromadlar
    Route::resource('incomes', IncomeController::class);

    // Investorlar
    Route::resource('investors', InvestorController::class);

    // Xarajatlar
    Route::resource('expenses', ExpenseController::class);

    // Taqsimot
    Route::resource('distributions', DistributionController::class);

    // Investitsiya shartnomalar
    Route::resource('investment-contracts', InvestmentContractController::class);

    // Xisobotlar
    Route::resource('reports', ReportController::class);

    // Islom moliyasi nazorati
    Route::resource('islamic-finance', IslamicFinanceController::class);

    // Sozlamalar
    Route::resource('settings', SettingsController::class);

    // Mamuriyat bolimi
    Route::resource('administration', AdministrationController::class);

    // Profile
    Route::resource('profile', ProfileController::class);

    // Bildirishnomalar
    Route::resource('notifications', NotificationController::class);
});
