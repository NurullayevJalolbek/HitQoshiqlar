<?php

use App\Http\Controllers\Admin\CompanyDetailController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\IntegrationSettingController;
use App\Http\Controllers\Admin\ProjectBuyerController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\ProjectEntryRequestController;
use App\Http\Controllers\Admin\ProjectExitRequestController;
use App\Http\Controllers\Admin\ProjectInvestorController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\UserInterfaceController;
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


Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'lang']], function () {


    //Profile
    Route::resource('profile', ProfileController::class)->except(['show']);


    // Dashboard route – faqat index
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Foydalanuvchilar – resource
    Route::resource('users', UserController::class);



    /*
     * Investitsiyon loyihalar
     */
    //Projects
    Route::resource('projects', ProjectController::class);

    //  Loyiha investorlar
    Route::resource('project-investors', ProjectInvestorController::class);

    //  Loyiha sotib olganlar (buyers)
    Route::resource('project-buyers', ProjectBuyerController::class);

    //  Ulushga kirish so‘rovlari
    Route::resource('project-entry-requests', ProjectEntryRequestController::class);

    //  Ulushdan chiqish so‘rovlari
    Route::resource('project-exit-requests', ProjectExitRequestController::class);

    //  Korxona rekvizitlari
    Route::resource('company-details', CompanyDetailController::class);



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


    /*
     *
     * Sozlamalar
     */

    //Malumotnomalar
    Route::resource('references', ReferenceController::class);

    //Umumiy sozlamalar
    Route::resource('general-settings', GeneralSettingController::class);

    //Integratsya sozlamalari
    Route::resource('integration-settings', IntegrationSettingController::class);

    //Foydalanuvchi interfeysi
    Route::resource('user-interface', UserInterfaceController::class);





    // Mamuriyat bolimi
    Route::resource('administration', AdministrationController::class);

    // Profile
    Route::resource('profile', ProfileController::class);

    // Bildirishnomalar
    Route::resource('notifications', NotificationController::class);
});
