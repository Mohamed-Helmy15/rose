<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GoodsReceivedNoteController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\SupplierEvaluationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Website\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\layouts\WithoutMenu;
use App\Http\Controllers\layouts\WithoutNavbar;
use App\Http\Controllers\layouts\Fluid;
use App\Http\Controllers\layouts\Container;
use App\Http\Controllers\layouts\Blank;
use App\Http\Controllers\pages\AccountSettingsAccount;
use App\Http\Controllers\pages\AccountSettingsNotifications;
use App\Http\Controllers\pages\AccountSettingsConnections;
use App\Http\Controllers\pages\MiscError;
use App\Http\Controllers\pages\MiscUnderMaintenance;
use App\Http\Controllers\authentications\LoginBasic;
use App\Http\Controllers\authentications\RegisterBasic;
use App\Http\Controllers\authentications\ForgotPasswordBasic;
use App\Http\Controllers\cards\CardBasic;
use App\Http\Controllers\user_interface\Accordion;
use App\Http\Controllers\user_interface\Alerts;
use App\Http\Controllers\user_interface\Badges;
use App\Http\Controllers\user_interface\Buttons;
use App\Http\Controllers\user_interface\Carousel;
use App\Http\Controllers\user_interface\Collapse;
use App\Http\Controllers\user_interface\Dropdowns;
use App\Http\Controllers\user_interface\Footer;
use App\Http\Controllers\user_interface\ListGroups;
use App\Http\Controllers\user_interface\Modals;
use App\Http\Controllers\user_interface\Navbar;
use App\Http\Controllers\user_interface\Offcanvas;
use App\Http\Controllers\user_interface\PaginationBreadcrumbs;
use App\Http\Controllers\user_interface\Progress;
use App\Http\Controllers\user_interface\Spinners;
use App\Http\Controllers\user_interface\TabsPills;
use App\Http\Controllers\user_interface\Toasts;
use App\Http\Controllers\user_interface\TooltipsPopovers;
use App\Http\Controllers\user_interface\Typography;
use App\Http\Controllers\extended_ui\PerfectScrollbar;
use App\Http\Controllers\extended_ui\TextDivider;
use App\Http\Controllers\icons\Boxicons;
use App\Http\Controllers\form_elements\BasicInput;
use App\Http\Controllers\form_elements\InputGroups;
use App\Http\Controllers\form_layouts\VerticalForm;
use App\Http\Controllers\form_layouts\HorizontalForm;

// Main Page Route


// layout
Route::get('/layouts/without-menu', [WithoutMenu::class, 'index'])->name('layouts-without-menu');
Route::get('/layouts/without-navbar', [WithoutNavbar::class, 'index'])->name('layouts-without-navbar');
Route::get('/layouts/fluid', [Fluid::class, 'index'])->name('layouts-fluid');
Route::get('/layouts/container', [Container::class, 'index'])->name('layouts-container');
Route::get('/layouts/blank', [Blank::class, 'index'])->name('layouts-blank');

// pages
Route::get('/pages/account-settings-account', [AccountSettingsAccount::class, 'index'])->name('pages-account-settings-account');
Route::get('/pages/account-settings-notifications', [AccountSettingsNotifications::class, 'index'])->name('pages-account-settings-notifications');
Route::get('/pages/account-settings-connections', [AccountSettingsConnections::class, 'index'])->name('pages-account-settings-connections');
Route::get('/pages/misc-error', [MiscError::class, 'index'])->name('pages-misc-error');
Route::get('/pages/misc-under-maintenance', [MiscUnderMaintenance::class, 'index'])->name('pages-misc-under-maintenance');

// authentication
Route::get('/auth/login-basic', [LoginBasic::class, 'index'])->name('auth-login-basic');
Route::get('/auth/register-basic', [RegisterBasic::class, 'index'])->name('auth-register-basic');
Route::get('/auth/forgot-password-basic', [ForgotPasswordBasic::class, 'index'])->name('auth-reset-password-basic');

// cards
Route::get('/cards/basic', [CardBasic::class, 'index'])->name('cards-basic');

// User Interface
Route::get('/ui/accordion', [Accordion::class, 'index'])->name('ui-accordion');
Route::get('/ui/alerts', [Alerts::class, 'index'])->name('ui-alerts');
Route::get('/ui/badges', [Badges::class, 'index'])->name('ui-badges');
Route::get('/ui/buttons', [Buttons::class, 'index'])->name('ui-buttons');
Route::get('/ui/carousel', [Carousel::class, 'index'])->name('ui-carousel');
Route::get('/ui/collapse', [Collapse::class, 'index'])->name('ui-collapse');
Route::get('/ui/dropdowns', [Dropdowns::class, 'index'])->name('ui-dropdowns');
Route::get('/ui/footer', [Footer::class, 'index'])->name('ui-footer');
Route::get('/ui/list-groups', [ListGroups::class, 'index'])->name('ui-list-groups');
Route::get('/ui/modals', [Modals::class, 'index'])->name('ui-modals');
Route::get('/ui/navbar', [Navbar::class, 'index'])->name('ui-navbar');
Route::get('/ui/offcanvas', [Offcanvas::class, 'index'])->name('ui-offcanvas');
Route::get('/ui/pagination-breadcrumbs', [PaginationBreadcrumbs::class, 'index'])->name('ui-pagination-breadcrumbs');
Route::get('/ui/progress', [Progress::class, 'index'])->name('ui-progress');
Route::get('/ui/spinners', [Spinners::class, 'index'])->name('ui-spinners');
Route::get('/ui/tabs-pills', [TabsPills::class, 'index'])->name('ui-tabs-pills');
Route::get('/ui/toasts', [Toasts::class, 'index'])->name('ui-toasts');
Route::get('/ui/tooltips-popovers', [TooltipsPopovers::class, 'index'])->name('ui-tooltips-popovers');
Route::get('/ui/typography', [Typography::class, 'index'])->name('ui-typography');

// extended ui
Route::get('/extended/ui-perfect-scrollbar', [PerfectScrollbar::class, 'index'])->name('extended-ui-perfect-scrollbar');
Route::get('/extended/ui-text-divider', [TextDivider::class, 'index'])->name('extended-ui-text-divider');

// icons
Route::get('/icons/boxicons', [Boxicons::class, 'index'])->name('icons-boxicons');

// form elements
Route::get('/forms/basic-inputs', [BasicInput::class, 'index'])->name('forms-basic-inputs');
Route::get('/forms/input-groups', [InputGroups::class, 'index'])->name('forms-input-groups');

// form layouts
Route::get('/form/layouts-vertical', [VerticalForm::class, 'index'])->name('form-layouts-vertical');
Route::get('/form/layouts-horizontal', [HorizontalForm::class, 'index'])->name('form-layouts-horizontal');




Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::get('lang/{locale}', function ($locale) {
    if (!in_array($locale, ['en', 'ar'])) {
        abort(400);
    }
    session()->put('locale', $locale);
    app()->setLocale($locale);
    return redirect()->back();
})->name('lang.switch');


Route::get('/', [HomeController::class, 'index']);
Route::middleware(['auth'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::prefix('shipping')->group(function () {
        // Governates
        Route::get('governates', [ShippingController::class, 'governates'])->name('shipping.governates.index');
        Route::get('governates/create', [ShippingController::class, 'governateCreate'])->name('shipping.governates.create');
        Route::post('governates', [ShippingController::class, 'governateStore'])->name('shipping.governates.store');
        Route::get('governates/{governate}', [ShippingController::class, 'governateShow'])->name('shipping.governates.show');
        Route::get('governates/{governate}/edit', [ShippingController::class, 'governateEdit'])->name('shipping.governates.edit');
        Route::put('governates/{governate}', [ShippingController::class, 'governateUpdate'])->name('shipping.governates.update');
        Route::delete('governates/{governate}', [ShippingController::class, 'governateDestroy'])->name('shipping.governates.destroy');

        // Cities
        Route::get('cities', [ShippingController::class, 'cities'])->name('shipping.cities.index');
        Route::get('cities/create', [ShippingController::class, 'cityCreate'])->name('shipping.cities.create');
        Route::post('cities', [ShippingController::class, 'cityStore'])->name('shipping.cities.store');
        Route::get('cities/{city}', [ShippingController::class, 'cityShow'])->name('shipping.cities.show');
        Route::get('cities/{city}/edit', [ShippingController::class, 'cityEdit'])->name('shipping.cities.edit');
        Route::put('cities/{city}', [ShippingController::class, 'cityUpdate'])->name('shipping.cities.update');
        Route::delete('cities/{city}', [ShippingController::class, 'cityDestroy'])->name('shipping.cities.destroy');

        // Locations
        Route::get('locations', [ShippingController::class, 'locations'])->name('shipping.locations.index');
        Route::get('locations/create', [ShippingController::class, 'locationCreate'])->name('shipping.locations.create');
        Route::post('locations', [ShippingController::class, 'locationStore'])->name('shipping.locations.store');
        Route::get('locations/{location}', [ShippingController::class, 'locationShow'])->name('shipping.locations.show');
        Route::get('locations/{location}/edit', [ShippingController::class, 'locationEdit'])->name('shipping.locations.edit');
        Route::put('locations/{location}', [ShippingController::class, 'locationUpdate'])->name('shipping.locations.update');
        Route::delete('locations/{location}', [ShippingController::class, 'locationDestroy'])->name('shipping.locations.destroy');

        // Shipping Rates
        Route::get('rates', [ShippingController::class, 'shippingRates'])->name('shipping.rates.index');
        Route::get('rates/create', [ShippingController::class, 'shippingRateCreate'])->name('shipping.rates.create');
        Route::post('rates', [ShippingController::class, 'shippingRateStore'])->name('shipping.rates.store');
        Route::get('rates/{shippingRate}', [ShippingController::class, 'shippingRateShow'])->name('shipping.rates.show');
        Route::get('rates/{shippingRate}/edit', [ShippingController::class, 'shippingRateEdit'])->name('shipping.rates.edit');
        Route::put('rates/{shippingRate}', [ShippingController::class, 'shippingRateUpdate'])->name('shipping.rates.update');
        Route::delete('rates/{shippingRate}', [ShippingController::class, 'shippingRateDestroy'])->name('shipping.rates.destroy');
    });
    Route::resource('notifications', NotificationController::class);
    Route::resource('branches', BranchController::class);
    Route::resource('categories', CategoryController::class);
    Route::post('categories/reorder', [CategoryController::class, 'reorder'])->name('categories.reorder');

    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::resource('products', ProductController::class);

    Route::get('pos', [OrderController::class, 'pos'])->name('pos');
    Route::post('orders/pos', [OrderController::class, 'storePos'])->name('orders.pos.store');
    Route::resource('orders', OrderController::class);
    Route::post('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.status');
    Route::get('orders/{order}/print/a4', [OrderController::class, 'printA4'])->name('orders.print.a4');
    Route::get('orders/{order}/print/thermal', [OrderController::class, 'printThermal'])->name('orders.print.thermal');
    Route::get('commissions/report', [OrderController::class, 'commissionsReport'])->name('commissions.report');

    Route::resource('suppliers', SupplierController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('goods-received-notes', GoodsReceivedNoteController::class);
    Route::resource('supplier-evaluations', SupplierEvaluationController::class);
    Route::get('purchase-orders/{purchase_order}/products', [PurchaseOrderController::class, 'getProducts'])->name('purchase_orders.products');
    // Route::get('purchase-orders/{purchaseOrder}/receive', [GoodsReceivedNoteController::class, 'create'])->name('goods-received-notes.create');
    // Route::post('purchase-orders/{purchaseOrder}/receive', [GoodsReceivedNoteController::class, 'store'])->name('goods-received-notes.store');

    Route::prefix('inventory')->name('inventory.')->group(function () {
        Route::get('/movements', [InventoryController::class, 'movements'])->name('movements'); // قائمة حركات
        // روتس إضافية للحركات، باتشات، إلخ (يمكن توسيع)
        Route::get('/batches', [InventoryController::class, 'batches'])->name('batches'); // قائمة دفعات
        Route::get('/pick-lists', [InventoryController::class, 'pickLists'])->name('pick-lists'); // قوائم انتقاء
        Route::get('/deliveries', [InventoryController::class, 'deliveries'])->name('deliveries'); // توصيلات

        Route::get('/', [InventoryController::class, 'index'])->name('index');
        Route::get('/create', [InventoryController::class, 'create'])->name('create');
        Route::post('/', [InventoryController::class, 'store'])->name('store');
        Route::get('/{warehouse}', [InventoryController::class, 'show'])->name('show'); // عرض مخزن معين
        Route::get('/{warehouse}/edit', [InventoryController::class, 'edit'])->name('edit');
        Route::put('/{warehouse}', [InventoryController::class, 'update'])->name('update');
        Route::delete('/{warehouse}', [InventoryController::class, 'destroy'])->name('destroy');

    });

    Route::get('/invoice', function () {
        return view('invoices.a4');
    });


});

Route::get('/create-storage-link', function () {
    try {
        $target = storage_path('app/public');
        $shortcut = public_path('storage');

        if (file_exists($shortcut)) {
            return 'Storage link already exists.';
        }

        // Instead of symlink, use PHP copy or recursive directory copy
        \File::copyDirectory($target, $shortcut);

        return 'Storage directory copied to public/storage.';
    } catch (\Exception $e) {
        return 'Error: ' . $e->getMessage();
    }
});


Route::group(['as' => 'site.', 'prefix' => '/flower', 'namespace' => 'Website'], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/category', [HomeController::class, 'category'])->name('category');
    Route::get('/product', [HomeController::class, 'product'])->name('product');
    Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
    Route::get('/favorite', [HomeController::class, 'favorite'])->name('favorite');
    Route::get('/compare', [HomeController::class, 'compare'])->name('compare');
    Route::get('/account', [HomeController::class, 'account'])->name('account');
    Route::get('/address', [HomeController::class, 'address'])->name('address');
    Route::get('/address/add', [HomeController::class, 'addAddress'])->name('addAddress');
    Route::get('/address/edit', [HomeController::class, 'editAddress'])->name('editAddress');
    Route::get('/about', [HomeController::class, 'about'])->name('about');
    Route::get('/shipping', [HomeController::class, 'shipping'])->name('shipping');
    Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');
    Route::get('/policy', [HomeController::class, 'policy'])->name('policy');


});

use Illuminate\Support\Facades\Storage;

Route::get('/storage/{path}', function ($path) {
    $filePath = storage_path('app/public/' . $path);

    if (!Storage::exists('public/' . $path)) {
        abort(404);
    }

    return response()->file($filePath);
})->where('path', '.*');

// helmy@future-vision.nexap.org
// -n9+bvfWVT[9)?XF