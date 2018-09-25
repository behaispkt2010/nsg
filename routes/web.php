<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


use Zizaco\Entrust\Entrust;

Auth::routes();

//Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
/*
 *
 *ADMIN
 *
 */
Route::get('login/facebook', 'Auth\RegisterController@redirectToProvider');
Route::get('login/facebook/callback', 'Auth\RegisterController@handleProviderCallback');
//print orders
Route::get('/report/orders', 'Report\OrdersController@getIndex');
Route::get('/report/orders/{oid}', 'Report\OrdersController@getOrderDetail');

Route::get('/report/orders/idv/{oid}', 'Report\OrdersController@getInventoryDeliveryVoucher');
Route::get('/report/orders/irv/{oid}', 'Report\OrdersController@getInventoryReceivingVoucher');
Route::get('/report/orders/rv/{oid}', 'Report\OrdersController@getReceiptVoucher');
Route::get('/report/orders/pv/{oid}', 'Report\OrdersController@getPaymentVoucher');
// print 
Route::get('/report/product/hisInput/{date}', 'Report\ProductController@getHistoryInput');
// export excel
Route::get('/report/export/orders', 'Report\ExportController@getExportOrders');
Route::get('/report/export/product', 'Report\ExportController@getExportProduct');
Route::get('/report/export/company', 'Report\ExportController@getExportCompany');
Route::get('/report/export/user', 'Report\ExportController@getExportUser');
Route::get('/report/export/staffs', 'Report\ExportController@getExportStaffs');
Route::get('/report/export/customer', 'Report\ExportController@getExportCustomer');
Route::get('/report/export/driver', 'Report\ExportController@getExportDriver');
Route::get('/report/export/hisInput', 'Report\ExportController@getExportHisInput');
Route::get('/report/export/warehouse', 'Report\ExportController@getExportWarehouse');

Route::get('/logout', 'Auth\LoginController@logout');
Route::group(['prefix' => 'admin','middleware' => ['auth', 'authorize']], function () {

    Route::get('/', 'DashboardController@index');
    Route::get('/dashboard', 'DashboardAdminController@index');
    //Tin tức
    Route::resource('news', 'NewController');
    Route::get('news/data/json', 'NewController@data');
    //Giá cả
    Route::resource('pricing', 'PricingController');
    Route::get('pricing/data/json', 'PricingController@data');
    Route::post('pricing/AjaxCreatePricing', 'PricingController@AjaxCreatePricing');
    Route::post('pricing/AjaxUpdatePricing', 'PricingController@AjaxUpdatePricing');
    //Tài liệu
    Route::resource('document', 'DocumentController');
    Route::get('document/data/json', 'DocumentController@data');
    Route::post('document/AjaxCreateDocument', 'DocumentController@AjaxCreateDocument');
    Route::post('document/AjaxUpdateDocument', 'DocumentController@AjaxUpdateDocument');
    

    //Liên kết Website
    Route::resource('websitelink', 'WebsiteLinkController');
    Route::get('websitelink/data/json', 'WebsiteLinkController@data');
    Route::post('websitelink/AjaxCreateWebsiteLink', 'WebsiteLinkController@AjaxCreateWebsiteLink');
    Route::post('websitelink/AjaxUpdateWebsiteLink', 'WebsiteLinkController@AjaxUpdateWebsiteLink');

    // Thông tin cần mua từ các Công ty
    Route::resource('newscompany', 'NewsCompanyController');
    Route::get('newscompany/data/json', 'NewsCompanyController@data');

    // Tin menu trợ giúp, Nhóm menu trợ giúp
    Route::resource('help-menu', 'HelpMenuController');
    Route::post('help-menu/createAjax', 'HelpMenuController@createAjax');
    Route::post('help-menu/updateAjax', 'HelpMenuController@updateAjax');

    //Nhóm tin tức
    Route::resource('category', 'CategoryController');
    Route::get('category/data/json', 'CategoryController@data');

    //permisson
    Route::resource('role', 'RolesController');
    Route::get('role/data/json', 'RolesController@data');

    //permisson
    Route::resource('permission', 'PermissionsController');
    Route::get('permission/data/json', 'PermissionsController@data');


    //Trang
    Route::resource('pages', 'PageController');
    Route::get('pages/data/json', 'PageController@data');

    //Sản phẩm
    Route::resource('products', 'ProductController');
    Route::post('products/AjaxGetProduct', 'ProductController@AjaxGetProduct');

    //Nhóm sp
    Route::resource('categoryProducts', 'CategoryProductController');
    Route::post('categoryProducts/createAjax', 'CategoryProductController@createAjax');
    Route::post('categoryProducts/updateAjax', 'CategoryProductController@updateAjax');
    Route::post('categoryProducts/AjaxGetCategory', 'CategoryProductController@AjaxGetCategory');
 
    //Đơn hàng
    Route::resource('orders', 'OrderController');
    Route::get('orders/getOrderByStatus/{id}', 'OrderController@getOrderByStatus');
    Route::post('orders/AjaxGetDistrictByProvince', 'OrderController@AjaxGetDistrictByProvince');
    Route::post('orders/AjaxGetDistrictByProvinceID', 'OrderController@AjaxGetDistrictByProvinceID');
    Route::post('orders/AjaxLoadInfoAddress', 'OrderController@AjaxLoadInfoAddress');
    //ql kho
    Route::resource('inventory', 'InventoryController');
    // xuất nhập kho
    Route::resource('warehousing', 'WarehousingController');
    //ql sỗ quỹ
    Route::resource('money', 'MoneyController');
    Route::resource('payment', 'PaymentController');
    Route::post('payment/getListOfType', 'PaymentController@getListOfType');
    Route::post('payment/getTotalPayment', 'PaymentController@getTotalPayment');
    //ql lịch sữ giao dịch
    Route::resource('historyInput', 'HistoryInputController');
    Route::resource('company', 'CompanyController');

    //Quản lý kho
    Route::resource('warehouse', 'WarehouseController');

//    Route::post('warehouse/AjaxInfo', 'WarehouseController@AjaxInfo');
    Route::post('warehouse/AjaxBank', 'WarehouseController@AjaxBank');
    Route::post('warehouse/AjaxEditBank', 'WarehouseController@AjaxEditBank');
    Route::post('warehouse/AjaxEditLevel', 'WarehouseController@AjaxEditLevel');
    Route::post('warehouse/AjaxInfo', 'WarehouseController@AjaxInfo');
    Route::post('warehouse/AjaxChangePass', 'WarehouseController@AjaxChangePass');
    Route::post('warehouse/AjaxSendRequestUpdateLevelKho', 'WarehouseController@AjaxSendRequestUpdateLevelKho');
    Route::post('warehouse/AjaxReQuestConfirmKho', 'WarehouseController@AjaxReQuestConfirmKho');
    Route::post('warehouse/AjaxReQuestQuangCao', 'WarehouseController@AjaxReQuestQuangCao');
    Route::post('warehouse/AjaxConfirmKho', 'WarehouseController@AjaxConfirmKho');
    Route::post('warehouse/AjaxQuangCao', 'WarehouseController@AjaxQuangCao');
    Route::post('warehouse/AjaxReQuestTraphi', 'WarehouseController@AjaxReQuestTraphi');

    Route::post('company/AjaxBank', 'CompanyController@AjaxBank');
    Route::post('company/AjaxEditBank', 'CompanyController@AjaxEditBank');
    // Route::post('company/AjaxEditLevel', 'WarehouseController@AjaxEditLevel');
    Route::post('company/AjaxInfo', 'CompanyController@AjaxInfo');
    Route::post('company/AjaxChangePass', 'CompanyController@AjaxChangePass');
    // Route::post('company/AjaxSendRequestUpdateLevelKho', 'WarehouseController@AjaxSendRequestUpdateLevelKho');
    Route::post('company/AjaxReQuestConfirmKho', 'CompanyController@AjaxReQuestConfirmKho');
    Route::post('company/AjaxReQuestQuangCao', 'CompanyController@AjaxReQuestQuangCao');
    Route::post('company/AjaxConfirmKho', 'CompanyController@AjaxConfirmKho');
    Route::post('company/AjaxQuangCao', 'CompanyController@AjaxQuangCao');
    Route::post('company/AjaxReQuestTraphi', 'CompanyController@AjaxReQuestTraphi');

    //Khách hàng
    Route::resource('customers', 'customerController');
    //Users
    Route::resource('users', 'UserController');
    Route::post('users/AjaxCreateCustomer', 'UserController@AjaxCreateCustomer');
    Route::post('users/AjaxGetDataCustomer', 'UserController@AjaxGetDataCustomer');
    Route::post('users/AjaxDeleteUser', 'UserController@AjaxDeleteUser')->name('user.deleted');


    //Nhân sự
    Route::resource('staffs', 'StaffController'); 
    // Vận chuyển
    Route::resource('driver', 'DriverController'); 
    Route::get('driver/data/json', 'DriverController@data');
    Route::post('driver/AjaxCreateTransport', 'DriverController@AjaxCreateTransport');
    Route::post('driver/AjaxGetDataTransport', 'DriverController@AjaxGetDataTransport');
    /////
    Route::resource('cartype', 'CarTypeController'); 
    Route::post('cartype/createAjax', 'CarTypeController@createAjax');
    Route::post('cartype/updateAjax', 'CarTypeController@updateAjax');
    /////
    Route::resource('transport', 'TransportController'); 
    Route::post('transport/createAjax', 'TransportController@createAjax');
    Route::post('transport/updateAjax', 'TransportController@updateAjax');

    
    //Cài đặt
    Route::resource('setting', 'SettingController');
    //Menu
    Route::resource('menu', 'MenuController');
    Route::post('menu/AjaxSave', 'MenuController@AjaxSave');

    //Giao diện
    Route::resource('display', 'DisplayController');
    //Ngôn ngữ
    Route::resource('languages', 'LanguageController');
    //Thống kê truy cập
    Route::resource('statistics', 'StatisticController');
    //Thông báo
    Route::resource('notification', 'NotificationController');

    //Mã giới thiệu
    Route::resource('sharingreferralcode', 'ReferralCodeController');

    
});
//Maps
    Route::get('/mapsgetmap', 'LocationCotroller@getMap');
    Route::get('/mapsadd', 'LocationCotroller@getAdd');
    Route::post('/mapsadd', 'LocationCotroller@postAdd');
/**
 * ajax
 */

Route::post('users/changeAvata', 'UserController@AjaxChangeImage');
Route::post('product/checkProductAjax', 'ProductController@checkProductAjax');
Route::post('product/updateProductAjax', 'ProductController@UpdateProductAjax');
Route::post('product/UpdateProductHistoryInput', 'ProductController@UpdateProductHistoryInput');
Route::post('product/deleteDetailImage', 'ProductController@deleteDetailImage');
Route::post('admin/getdashboard', 'DashboardAdminController@getdashboard');
Route::post('admin/dashboardctrl', 'DashboardController@dashboard');
Route::post('admin/dashboard/Approval', 'DashboardController@Approval');
Route::post('admin/dashboard/ApprovalNews', 'DashboardController@ApprovalNews');
Route::get('admin/notify/AjaxUpdateIsReadNotify', 'NotificationController@AjaxUpdateIsReadNotify');
Route::get('admin/notify/AjaxUpdateClickOneNotify', 'NotificationController@AjaxUpdateClickOneNotify');
Route::post('warehouse/AjaxDetail', 'WarehouseController@AjaxDetail');
Route::post('warehouse/deleteDetailImage', 'WarehouseController@deleteDetailImage');
Route::post('warehouse/UploadImgDetail', 'WarehouseController@UploadImgDetail');
Route::post('company/UploadImgDetail', 'CompanyController@UploadImgDetail');
Route::post('company/AjaxDetail', 'CompanyController@AjaxDetail');
Route::post('company/deleteDetailImage', 'CompanyController@deleteDetailImage');




/*
 *
 *APP
 *
 */


Route::get('/', 'HomeController@index');

//product
Route::get('/category-product/{cateSlug}','Frontend\ProductController@CateProduct');
Route::get('/products', 'Frontend\ProductController@index');
Route::get('/product/{cateSlug}/{productSlug}', 'Frontend\ProductController@SingleProduct');
Route::get('/check-order', 'Frontend\ProductController@CheckOrder');
//Route::post('/check-order', 'Frontend\ProductController@PostCheckOrder');
Route::post('/single-order', 'Frontend\ProductController@singleOrder');

Route::get('/company-business', 'Frontend\ProductController@GetAllCompany');
Route::get('/warehouse-business', 'Frontend\ProductController@GetAllWareHouse');
Route::get('/productview', 'Frontend\ProductController@GetAllProduct');
Route::get('/company/{company_id}', 'Frontend\PageController@DetailCompany');
Route::get('/company/{company_id}/{newscompanySlug}/{newscompany_id}', 'Frontend\PageController@DetailNewsCompany');



//blog
Route::get('/category-blog/{cateSlug}','Frontend\BlogController@CateBlog');
Route::get('/blogs', 'Frontend\BlogController@index');
Route::get('/blog/{cateSlug}/{productSlug}', 'Frontend\BlogController@SingleBlog');
Route::get('/gia-ca-thi-truong', 'Frontend\BlogController@PricingMaker');

Route::get('/contact','Frontend\PageController@Contact');
Route::post('/contact','Frontend\PageController@PostContact');

Route::get('/nhan-ho-tro','Frontend\PageController@SendHelpUser');

//thông tin chủ kho
Route::get('/shop/{warehouse_id}', 'Frontend\PageController@DetailWarehouse');
Route::get('/xac-thuc-kho', 'Frontend\PageController@ConfirmKho');
Route::get('/quang-cao', 'Frontend\PageController@QuangCao');
Route::get('/tra-phi', 'Frontend\PageController@TraPhi');
Route::get('/nang-cap-kho', 'Frontend\PageController@UpgradeKho');

Route::get('/infoconfirmkho', 'Frontend\PageController@InfoConfirmKho');
Route::get('/infoquangcao', 'Frontend\PageController@InfoQuangCao');

Route::get('/resisterWareHouse','Frontend\PageController@GetResisterWareHouse');
Route::post('/resisterWareHouse','Frontend\PageController@PostResisterWareHouse');

Route::get('/tro-giup', 'Frontend\LandingPageController@help_home');
Route::get('/tro-giup/{linkMenu}', 'Frontend\LandingPageController@help_menu');
Route::get('/dataJsTree', 'Frontend\LandingPageController@dataJsTree');

Route::get('/about','Frontend\PageController@About');
// Route::get('/{slug}','Frontend\PageController@CustomPage');

Route::post('/customer-rate','Frontend\ProductController@customerRate');

// maps
/*Route::get('/', ['as' => 'getLocation', 'uses' => 'LocationCotroller@getLocation']);*/

// Route::get('/xac-thuc-kho', 'HomeController@testmap');

Route::get('/nha-cung-cap/{capdo}', 'Frontend\PageController@GetWareHouseByLevel');
Route::get('/ho-tro/{content}', 'Frontend\PageController@Help');
Route::get('/vung-mien/{area}', 'Frontend\PageController@getWareHouseArea');

Route::get('/lp/{content}', 'Frontend\LandingPageController@LandingPage');

Route::get('/tai-lieu','Frontend\BlogController@Document');

////cart
//Route::get('/cart', 'CartController@index');
//Route::get('/cart/empty', 'CartController@emptyCart');
//Route::get('/cart/{id}', 'CartController@store');
//Route::get('/cart/remove/{id}', 'CartController@destroy');








