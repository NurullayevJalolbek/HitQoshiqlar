<?php

use App\Http\Controllers\Admin\LanguageManagementController;
use App\Http\Controllers\Admin\MultilingualController;
use App\Http\Controllers\Admin\ProjectEntryRequestController;
use App\Http\Controllers\Admin\IntegrationSettingController;
use App\Http\Controllers\Admin\ProjectExitRequestController;
use App\Http\Controllers\Admin\InvestmentContractController;
use App\Http\Controllers\Admin\ProjectInvestorController;
use App\Http\Controllers\Admin\GeneralSettingController;
use App\Http\Controllers\Admin\IslamicFinanceController;
use App\Http\Controllers\Admin\AdministrationController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CompanyDetailController;
use App\Http\Controllers\Admin\SEOController;
use App\Http\Controllers\Admin\StaticPageController;
use App\Http\Controllers\Admin\SystemTranslationController;
use App\Http\Controllers\Admin\TemplateMessageController;
use App\Http\Controllers\Admin\UserInterfaceController;
use App\Http\Controllers\Admin\LoginHistoryController;
use App\Http\Controllers\Admin\ProjectBuyerController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\DistributionController;
use App\Http\Controllers\Admin\SystemLogController;
use App\Http\Controllers\Admin\ReferenceController;
use App\Http\Controllers\Admin\InvestorController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\RevenueController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\LocalizationController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;
use PhpParser\Node\Expr\AssignOp\Mul;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => ['auth', 'lang']], function () {


    //Profile
    Route::resource('profile', ProfileController::class)->except(['show']);


    // Dashboard route – faqat index
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');


    /*
     * Investitsiyon loyihalar
     */
    //Projects
    Route::resource('projects', ProjectController::class)->names('projects');

    //  Loyiha investorlar
    Route::resource('project-investors', ProjectInvestorController::class)->names([
        'index'   => 'project-investors.index',
        'create'  => 'project-investors.create',
        'store'   => 'project-investors.store',
        'show'    => 'project-investors.show',
        'edit'    => 'project-investors.edit',
        'update'  => 'project-investors.update',
        'destroy' => 'project-investors.destroy',
    ]);;

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
    Route::prefix('user-interface')->name('user-interface.')->group(function () {
        Route::get('/', [UserInterfaceController::class, 'index'])->name('index');

        Route::resource('/language-management', LanguageManagementController::class);

        Route::resource('/system-translations',SystemTranslationController::class);

        Route::resource('/template-messages', TemplateMessageController::class);

        Route::resource('/multimedia', MultilingualController::class);

        Route::resource('/static-pages', StaticPageController::class);
    });


    Route::prefix('/seo-settings')->name('seo-settings.')->group(function () {

        // READ – barcha yozuvlarni ko‘rsatish
        Route::get('/', [SEOController::class, 'index'])->name('index');

        // CREATE – yangi yozuv yaratish formasi
        Route::get('/create', [SEOController::class, 'create'])->name('create');
        Route::post('/', [SEOController::class, 'store'])->name('store');

        // SHOW – bitta yozuvni ko‘rsatish
        Route::get('/{id}', [SEOController::class, 'show'])->name('show');

        // EDIT – bitta yozuvni tahrirlash formasi
        Route::get('/{key}/edit', [SEOController::class, 'edit'])->name('edit');
        Route::put('/{key}', [SEOController::class, 'update'])->name('update');

        // DELETE – bitta yozuvni o‘chirish
        Route::delete('/{id}', [SEOController::class, 'destroy'])->name('destroy');
    });


    Route::resource('/localization', LocalizationController::class);

    /*
     *
     * Mamuriyat bo'limi
     */

    //Foydalanuvchilar
    Route::resource('users', UserController::class);

    // Investorlar
    Route::resource('investors', InvestorController::class);

    //Rollar
    Route::resource('roles', RoleController::class);

    //Permissions
    Route::get('role-permissions', function () {
        return view('pages.permissions.show'); // statik ruxsatlar sahifasi
    })->name('role-permissions.index');


    //Login histori
    Route::resource('login-histories', LoginHistoryController::class);


    //System logs
    Route::resource('system-logs', SystemLogController::class);








    // Mamuriyat bolimi
    Route::resource('administration', AdministrationController::class);

    // Profile
    Route::resource('profile', ProfileController::class);

    // Bildirishnomalar
    Route::resource('notifications', NotificationController::class);
});
