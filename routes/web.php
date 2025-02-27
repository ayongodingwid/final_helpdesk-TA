<?php

use App\Http\Controllers\AssetCategoryController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\AssetRequestController;
use App\Http\Controllers\AssetSubcategoryController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\BackofficeController;
use App\Http\Controllers\BusinessUnitController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\MenuBomController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OutletController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ProblemHandlingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RepairHistoryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SalesModeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TicketCategoryController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\TicketSubcategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VoidMenuController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingPageController::class, 'index'])->name('landing-page');
Route::get('/buat-tiket', [LandingPageController::class, 'createTicket'])->name('landing-create');
Route::get('/detail-tiket/{ticket_number}', [LandingPageController::class, 'detailTicket'])->name('landing-detail'); 
Route::post('/search-tiket', [LandingPageController::class, 'searchTicket'])->name('landing-search'); 

Route::post('/buat-tiket', [DashboardController::class, 'storeTicket'])->name('ticket-store');
Route::get('/login', [AuthenticationController::class, 'login'])->name('login');
Route::post('/login', [AuthenticationController::class, 'authenticate']);

Route::post('/penanganan-masalah', [ProblemHandlingController::class, 'store'])->name('pm-store');


Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
    
    Route::get('/get-notification', [NotificationController::class, 'getNotification']);
    Route::post('read-all', [NotificationController::class, 'readAll']);
    Route::post('read-notif', [NotificationController::class, 'readNotif']);
    
    
    Route::post('/ticket/update/{data}', [TicketController::class, 'updateStatus']);
    Route::post('/ticket/reject', [TicketController::class, 'ticketReject'])->name('ticket-reject');
    // Get Ticket Detail
    Route::get('/get-ticket/{data}', [TicketController::class, 'getTicket']);
    
    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'dashboardIndex'])->name('dashboard');
    
    // GENERAL
    Route::get('/general/list-tiket', [DashboardController::class, 'listTicket'])->name('list-ticket');
    Route::post('/general/list-tiket', [DashboardController::class, 'ticketFilter']);
    
    // ICT
    Route::prefix('ict')->group(function () {
            // PENANGANAN MASALAJH
        Route::get('/penanganan-masalah', [ProblemHandlingController::class, 'index'])->name('ict-pm');
        // PERMINTAAN ASET
        Route::controller(AssetRequestController::class)->group(function () {
            Route::get('/permintaan-aset', 'index')->name('ict-pa');
            Route::get('/permintaan-aset/create', 'create')->name('pa-create');
            Route::post('/permintaan-aset', 'store')->name('pa-store');
        });
    });
    
    Route::get('/permintaan-aset/form/{id}', [AssetRequestController::class, 'getForm']);
    
    
    // OPERATIONAL
    Route::prefix('operational')->group(function () {
            // MENU & BOM
        Route::controller(MenuBomController::class)->group(function () {
            Route::get('/menu-dan-bom', 'index')->name('menu-bom');
            Route::get('/menu-dan-bom/create', 'create')->name('mnb-create');
            Route::post('/menu-dan-bom', 'store')->name('mnb-store');
        });
        // PROGRAM PROMO 
        Route::controller(PromoController::class)->group(function () {
            Route::get('/program-promo', 'index')->name('program-promo');
            Route::get('/program-promo/create', 'create')->name('pp-create');
            Route::post('/program-promo', 'store')->name('pp-store');
        });
        // DISCOUNT 
        Route::controller(DiscountController::class)->group(function () {
            Route::get('/discount', 'index')->name('discount');
            Route::get('/discount/create', 'create')->name('discount-create');
            Route::post('/discount', 'store')->name('discount-store');
        });
        // SELISIH HARGA 
        Route::controller(PriceController::class)->group(function () {
            Route::get('/selisih-harga', 'index')->name('harga');
            Route::get('/selisih-harga/create', 'create')->name('harga-create');
            Route::post('/selisih-harga', 'store')->name('harga-store');
        });
        // VOID 
        Route::controller(VoidMenuController::class)->group(function () {
            Route::get('/void', 'index')->name('void');
            Route::get('/void/create', 'create')->name('void-create');
            Route::post('/void', 'store')->name('void-store');
        });
    });
    
    
    // FAT
    Route::controller(CoaController::class)->group(function () {
        Route::get('/fat/coa', 'index')->name('coa');
        Route::get('/fat/coa/create', 'create')->name('coa-create');
        Route::post('/fat/coa/store', 'store')->name('coa-store');
    });
    // PURCHASING
    Route::prefix('purchasing')->group(function () {
        // PRODUCT
        Route::controller(ProductController::class)->group(function () {
            Route::get('/product', 'index')->name('product');
            Route::get('/product/create', 'create')->name('product-create');
            Route::post('/product/store', 'store')->name('product-store');
        });
        // SUPPLIER 
        Route::controller(SupplierController::class)->group(function () {
            Route::get('/supplier', 'index')->name('supplier');
            Route::get('/supplier/create', 'create')->name('supplier-create');
            Route::post('/supplier/store', 'store')->name('supplier-store');
        });
    });
    // MASTER
    Route::prefix('master')->group(function () {
        // BISNIS UNIT
        Route::controller(BusinessUnitController::class)->group(function () {
            Route::get('/bisnis-unit', 'index')->name('bisnis-unit');
            Route::post('/bisnis-unit/store', 'store')->name('bu-store');
            Route::delete('/bisnis-unit/delete/{id}', 'delete')->name('bu-delete');
        });
        // DIVISI 
        Route::controller(DivisionController::class)->group(function () {
            Route::get('/divisi', 'index')->name('divisi');
            Route::post('/divisi/store', 'store')->name('divisi-store');
            Route::delete('/divisi/delete/{id}', 'delete')->name('divisi-delete');
        });
        // SALES MODE 
        Route::controller(SalesModeController::class)->group(function () {
            Route::get('/sales-mode', 'index')->name('sales-mode');
            Route::post('/sales-mode/store', 'store')->name('sm-store');
            Route::delete('/sales-mode/delete/{id}', 'delete')->name('sm-delete');
        });
        // BACKOFFICE
        Route::controller(BackofficeController::class)->group(function () {
            Route::get('/backoffice', 'index')->name('backoffice');
            Route::post('/backoffice/store', 'store')->name('backoffice-store');
            Route::delete('/backoffice/delete/{id}', 'delete')->name('backoffice-delete');
        });
        // ASET
        Route::controller(AssetController::class)->group(function () {
            Route::get('/asset', 'index')->name('asset');
            Route::get('/asset/create', 'create')->name('asset-create');
            Route::get('/asset/detail/{id}', 'show')->name('asset-detail');
            Route::post('/asset/store', 'store')->name('asset-store');
            Route::put('/asset/update/{id}', 'update')->name('asset-update');
        });
        Route::controller(RepairHistoryController::class)->group(function () {
            Route::get('/repair/create/{id}', 'create')->name('repair-create');
            Route::get('/repair/history', 'history')->name('repair-history');
            Route::post('/repair/store', 'store')->name('repair-store');
        });
        Route::get('/get-repair-history/{data}', [RepairHistoryController::class, 'getRepairHistory']);

    });
    
    // PENGATURAN
        // TICKET CATEGORY
    Route::controller(TicketCategoryController::class)->group(function () {
        Route::get('/pengaturan/ticket-category', 'index')->name('pengaturan-ticket');
        Route::get('/pengaturan/create/ticket-category', 'create')->name('pengaturan-create-ticket');
        Route::post('/ticket-category/store', 'store')->name('pengaturan-store-ticket');
        Route::get('/pengaturan/edit/ticket-category/{id}', 'edit')->name('pengaturan-edit-ticket');
        Route::put('/ticket-category/update/{id}', 'update')->name('pengaturan-update-ticket');
        // Route::delete('/category/delete/{id}', 'delete')->name('delete-category');
    });
    Route::delete('/sub-category/delete/{id}', [TicketSubcategoryController::class, 'delete']);
        // ASET CATEGORY
    Route::controller(AssetCategoryController::class)->group(function () {
        Route::get('/pengaturan/aset-category', 'index')->name('pengaturan-aset');
        Route::get('/pengaturan/create/aset-category', 'create')->name('pengaturan-create-aset');
        Route::post('/aset-category/store', 'store')->name('pengaturan-store-aset');
        Route::get('/pengaturan/edit/aset-category/{id}', 'edit')->name('pengaturan-edit-aset');
        Route::put('/aset-category/update/{id}', 'update')->name('pengaturan-update-aset');
        Route::delete('/aset-category/delete/{id}', 'delete')->name('delete-aset-category');
    });
    Route::delete('/aset-subcategory/delete/{id}', [AssetSubcategoryController::class, 'delete']);
        // AKUN ROLE
    Route::controller(RoleController::class)->group(function () {
        Route::get('/pengaturan/akun-role', 'index')->name('akun-role');
        Route::get('/pengaturan/akun-role/create', 'create')->name('ar-create');
        Route::get('/pengaturan/akun-role/edit/{id}', 'edit')->name('ar-edit');
        Route::post('/pengaturan/akun-role', 'store')->name('ar-store');
        Route::put('/pengaturan/akun-role/update/{id}', 'update')->name('ar-update');
    });
        // List Akun
    Route::controller(UserController::class)->group(function () {
        Route::get('/pengaturan/list-akun', 'index')->name('list-akun');
        Route::get('/pengaturan/list-akun/create', 'create')->name('la-create');
        Route::get('/pengaturan/list-akun/edit/{id}', 'edit')->name('la-edit');
        Route::post('/pengaturan/list-akun', 'store')->name('la-store');
        Route::put('/pengaturan/list-akun/update/{id}', 'update')->name('la-update');
        Route::delete('/pengaturan/list-akun/delete/{id}', 'destroy')->name('la-delete');
    });
        // FAQ
    Route::controller(FaqController::class)->group(function () {
        Route::get('/pengaturan/faq', 'index')->name('faq');
        Route::get('/pengaturan/faq/create', 'create')->name('faq-create');
        Route::get('/pengaturan/faq/edit/{id}', 'edit')->name('faq-edit');
        Route::post('/pengaturan/faq', 'store')->name('faq-store');
        Route::put('/pengaturan/faq/update/{id}', 'update')->name('faq-update');
        Route::delete('/pengaturan/faq/delete/{id}', 'destroy')->name('faq-delete');
    });
});
