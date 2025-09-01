<?php

use App\Http\Controllers\Admin\AddressesController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AreaController;
use App\Http\Controllers\Admin\AreasController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BoardController;
use App\Http\Controllers\Admin\BranchsController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\CouponsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OptionsController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\PropertiesController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SaleController;
use App\Http\Controllers\Admin\SearchController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['middleware' => 'Lang'], function () {

    Route::group(['prefix' => 'admin'], function () {

        Route::get('login', [AuthController::class, 'login']);
        Route::post('login', [AuthController::class, 'auth']);

        Route::group(['prefix' => 'settings'], function () {
            Route::get('language/{lang}', [SettingController::class, 'language']);
            Route::get('theme/{theme}', [SettingController::class, 'theme']);
            Route::get('terms', [SettingController::class, 'about']);
            Route::post('update', [SettingController::class, 'update']);
        });

        #################### Auth ##########################
        Route::group(['middleware' => 'admin'], function () {

            Route::get('logout', [AuthController::class, 'logout']);

            Route::get('', [DashboardController::class, 'index']);
            Route::get('dashboard', [DashboardController::class, 'index']);
            Route::get('contact_us', [ContactUsController::class, 'index']);
            Route::get('contact_us/view/{id}', [ContactUsController::class, 'show']);

            Route::group(['prefix' => 'notifications'], function () {
                Route::get('', [NotificationController::class, 'index']);
                Route::get('orders', [NotificationController::class, 'index_orders']);
                Route::get('read/{type}', [NotificationController::class , 'read']);
                Route::get('notify', [NotificationController::class , 'notify']);
                Route::get('board_notify', [NotificationController::class , 'board_notify']);
            });

            Route::group(['prefix' => 'search'], function () {
                Route::get('', [SearchController::class, 'index']);
            });

            Route::get('settings', [SettingController::class, 'index']);
            Route::post('settings', [SettingController::class, 'update']);

            Route::group(['prefix' => 'admins'], function () {
                Route::get('', [AdminController::class, 'index']);
                Route::get('create', [AdminController::class, 'create']);
                Route::get('edit/{id}', [AdminController::class, 'edit']);
                Route::get('view/{id}', [AdminController::class, 'show']);
                Route::get('logs/{id}', [AdminController::class, 'logs']);
                Route::get('logs', [AdminController::class, 'logs']);
                Route::post('create', [AdminController::class, 'store']);
                Route::post('update/{id}', [AdminController::class, 'update']);
                Route::post('delete', [AdminController::class, 'destroy']);
                Route::get('deleted', [AdminController::class, 'deleted']);
                Route::get('restore/{id}', [AdminController::class, 'restore']);
                Route::get('force_delete', [AdminController::class, 'force_delete']);
            });

            Route::group(['prefix' => 'roles'], function () {
                Route::get('', [RoleController::class, 'index']);
                Route::get('create', [RoleController::class, 'create']);
                Route::post('create', [RoleController::class, 'store']);
                Route::get('view/{id}', [RoleController::class, 'show']);
                Route::get('edit/{id}', [RoleController::class, 'edit']);
                Route::post('update/{id}', [RoleController::class, 'update']);
                Route::post('delete', [RoleController::class, 'destroy']);
            });

            Route::group(['prefix' => 'services'], function () {
                Route::get('', [ServiceController::class, 'index']);
                Route::get('create', [ServiceController::class, 'create']);
                Route::post('create', [ServiceController::class, 'store']);
                Route::get('view/{id}', [ServiceController::class, 'show']);
                Route::get('edit/{id}', [ServiceController::class, 'edit']);
                Route::post('update/{id}', [ServiceController::class, 'update']);
                Route::post('{id}/delete', [ServiceController::class, 'destroy']);
            });

            Route::group(['prefix' => 'team'], function () {
                Route::get('', [TeamController::class, 'index']);
                Route::get('create', [TeamController::class, 'create']);
                Route::post('create', [TeamController::class, 'store']);
                Route::get('view/{id}', [TeamController::class, 'show']);
                Route::get('edit/{id}', [TeamController::class, 'edit']);
                Route::post('update/{id}', [TeamController::class, 'update']);
                Route::post('{id}/delete', [TeamController::class, 'destroy']);
            });

            Route::group(['prefix' => 'projects'], function () {
                Route::get('', [ProjectController::class, 'index']);
                Route::get('create', [ProjectController::class, 'create']);
                Route::post('create', [ProjectController::class, 'store']);
                Route::get('view/{id}', [ProjectController::class, 'show']);
                Route::get('edit/{id}', [ProjectController::class, 'edit']);
                Route::post('update/{id}', [ProjectController::class, 'update']);
                Route::post('{id}/delete', [ProjectController::class, 'destroy']);
            });

            // Route::group(['prefix' => 'users'], function () {
            //     Route::get('', [UserController::class, 'index']);
            //     Route::get('create', [UserController::class, 'create']);
            //     Route::get('edit/{id}', [UserController::class, 'edit']);
            //     Route::get('view/{id}', [UserController::class, 'show']);
            //     Route::post('create', [UserController::class, 'store']);
            //     Route::post('update/{id}', [UserController::class, 'update']);
            //     Route::post('delete', [UserController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'boards'], function () {
            //     Route::get('', [BoardController::class, 'index']);
            //     Route::get('create', [BoardController::class, 'create']);
            //     Route::get('orders/new', [BoardController::class, 'new_orders']);
            //     Route::get('orders/recent', [BoardController::class, 'recent_orders']);
            //     Route::get('orders/view/{id}', [BoardController::class, 'orders_view']);
            //     Route::get('edit/{id}', [BoardController::class, 'edit']);
            //     Route::get('view/{id}', [BoardController::class, 'show']);
            //     Route::post('create', [BoardController::class, 'store']);
            //     Route::post('orders/payment_update/{id}', [BoardController::class, 'payment_update']);
            //     Route::post('orders/update/{id}', [BoardController::class, 'update']);
            //     Route::post('delete', [BoardController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'cities'], function () {
            //     Route::get('', [CityController::class, 'index']);
            //     Route::get('create', [CityController::class, 'create']);
            //     Route::get('edit/{id}', [CityController::class, 'edit']);
            //     Route::get('view/{id}', [CityController::class, 'show']);
            //     Route::post('create', [CityController::class, 'store']);
            //     Route::post('update/{id}', [CityController::class, 'update']);
            //     Route::post('delete', [CityController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'addresses'], function () {
            //     Route::get('', [AddressesController::class, 'index']);
            //     Route::get('create', [AddressesController::class, 'create']);
            //     Route::get('edit/{id}', [AddressesController::class, 'edit']);
            //     Route::get('view/{id}', [AddressesController::class, 'show']);
            //     Route::post('create', [AddressesController::class, 'store']);
            //     Route::post('update/{id}', [AddressesController::class, 'update']);
            //     Route::post('delete', [AddressesController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'areas'], function () {
            //     Route::post('city', [AreaController::class, 'city']);
            //     Route::post('delivery/create', [AreaController::class, 'delivery_create']);
            //     Route::post('create', [AreaController::class, 'store']);
            //     Route::post('update', [AreaController::class, 'update']);
            //     Route::post('delete', [AreaController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'sliders'], function () {
            //     Route::get('', [SliderController::class, 'index']);
            //     Route::get('create', [SliderController::class, 'create']);
            //     Route::get('edit/{id}', [SliderController::class, 'edit']);
            //     Route::get('view/{id}', [SliderController::class, 'show']);
            //     Route::post('create', [SliderController::class, 'store']);
            //     Route::post('update/{id}', [SliderController::class, 'update']);
            //     Route::post('delete', [SliderController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'banners'], function () {
            //     Route::get('', [BannerController::class, 'index']);
            //     Route::get('create', [BannerController::class, 'create']);
            //     Route::get('edit/{id}', [BannerController::class, 'edit']);
            //     Route::get('view/{id}', [BannerController::class, 'show']);
            //     Route::post('create', [BannerController::class, 'store']);
            //     Route::post('update/{id}', [BannerController::class, 'update']);
            //     Route::post('delete', [BannerController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'galleries'], function () {
            //     Route::get('', [GalleryController::class, 'index']);
            //     Route::get('create', [GalleryController::class, 'create']);
            //     Route::get('edit/{id}', [GalleryController::class, 'edit']);
            //     Route::get('view/{id}', [GalleryController::class, 'show']);
            //     Route::post('create', [GalleryController::class, 'store']);
            //     Route::post('update/{id}', [GalleryController::class, 'update']);
            //     Route::post('delete', [GalleryController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'categories'], function () {
            //     Route::get('', [CategoryController::class, 'index']);
            //     Route::get('create', [CategoryController::class, 'create']);
            //     Route::get('edit/{id}', [CategoryController::class, 'edit']);
            //     Route::get('view/{id}', [CategoryController::class, 'show']);
            //     Route::post('create', [CategoryController::class, 'store']);
            //     Route::post('update/{id}', [CategoryController::class, 'update']);
            //     Route::post('delete', [CategoryController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'products'], function () {
            //     Route::get('', [ProductController::class, 'index']);
            //     Route::get('create', [ProductController::class, 'create']);
            //     Route::get('edit/{id}', [ProductController::class, 'edit']);
            //     Route::get('view/{id}', [ProductController::class, 'show']);
            //     Route::post('create', [ProductController::class, 'store']);
            //     Route::post('update/{id}', [ProductController::class, 'update']);
            //     Route::post('delete', [ProductController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'orders'], function () {
            //     Route::get('', [OrderController::class, 'index']);
            //     Route::get('today', [OrderController::class, 'today']);
            //     Route::get('view/{id}', [OrderController::class, 'show']);
            //     Route::get('view/pdf/{id}', [OrderController::class, 'show_pdf']);
            //     Route::post('update/{id}', [OrderController::class, 'update']);
            // });

            // Route::group(['prefix' => 'sales'], function () {
            //     Route::get('', [SaleController::class, 'index']);
            //     Route::get('daily', [SaleController::class, 'today']);
            //     Route::get('weekly', [SaleController::class, 'week']);
            //     Route::get('monthly', [SaleController::class, 'month']);
            //     Route::get('yearly', [SaleController::class, 'year']);
            //     Route::get('view/{id}', [SaleController::class, 'show']);
            // });

            // Route::group(['prefix' => 'coupons'], function () {
            //     Route::get('', [CouponsController::class, 'index'])->name('admin.coupons');
            //     Route::get('create', [CouponsController::class, 'create']);
            //     Route::post('store', [CouponsController::class, 'store']);
            //     Route::get('edit/{id}', [CouponsController::class, 'edit']);
            //     Route::post('update/{id}', [CouponsController::class, 'update']);
            //     Route::post('delete/{id}', [CouponsController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'payments'], function () {
            //     Route::get('', [PaymentController::class, 'index'])->name('admin.payments');
            //     Route::get('create', [PaymentController::class, 'create']);
            //     Route::post('store', [PaymentController::class, 'store']);
            //     Route::get('edit/{id}', [PaymentController::class, 'edit']);
            //     Route::post('update/{id}', [PaymentController::class, 'update']);
            //     Route::post('delete/{id}', [PaymentController::class, 'destroy']);
            // });

            // Route::group(['prefix' => 'branches'], function () {
            //     Route::get('', [BranchsController::class, 'index'])->name('admin.branches');
            //     Route::get('create', [BranchsController::class, 'create']);
            //     Route::post('store', [BranchsController::class, 'store']);
            //     Route::get('edit/{id}', [BranchsController::class, 'edit']);
            //     Route::post('update/{id}', [BranchsController::class, 'update']);
            //     Route::post('delete/{id}', [BranchsController::class, 'destroy']);
            //     Route::get('get_branch_areas', [BranchsController::class, 'getBranchAreas'])->name('branch.areas');
            // });

            // Route::group(['prefix' => 'options'], function () {
            //     Route::get('', [OptionsController::class, 'index'])->name('admin.options');
            //     Route::get('create', [OptionsController::class, 'create']);
            //     Route::post('store', [OptionsController::class, 'store']);
            //     Route::get('view/{id}', [OptionsController::class, 'show']);
            //     Route::post('{id}/assign', [OptionsController::class, 'assign']);
            //     Route::get('edit/{id}', [OptionsController::class, 'edit']);
            //     Route::post('update/{id}', [OptionsController::class, 'update']);
            //     Route::post('delete/{id}', [OptionsController::class, 'destroy']);
            //     Route::group(['prefix' => '{id}/properties'], function () {
            //         Route::get('', [PropertiesController::class, 'index'])->name('admin.options.properties');
            //         Route::get('create', [PropertiesController::class, 'create']);
            //         Route::post('store', [PropertiesController::class, 'store']);
            //         Route::get('view/{id}', [PropertiesController::class, 'show']);
            //         Route::get('edit/{id}', [PropertiesController::class, 'edit']);
            //         Route::post('update/{prop_id}', [PropertiesController::class, 'update']);
            //         Route::post('delete/{id}', [PropertiesController::class, 'destroy']);
            //     });
            // });
        
        });
    });
});
