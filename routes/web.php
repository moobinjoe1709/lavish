<?php

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
use App\Http\Middleware\CheckAuthadmin;

Route::group(['middleware' => 'auth'],function(){
	Route::get('/dashboard','BackofficeController@dashboard');
	//Product
	Route::get('/product','ProductController@index');
	Route::get('/product/create','ProductController@create');
	Route::get('/productdatatables','ProductController@datatable');
	Route::post('product_create','ProductController@store');
	Route::get('/product/update/{id}','ProductController@edit');
	Route::post('product_update','ProductController@update');
	Route::get('/product/delete/{id}','ProductController@destroy');
	Route::post('importscreate','ProductController@import');
	Route::post('productimportdata','ProductController@productimportdata');
	Route::post('productsaledata','ProductController@productsaledata');
	Route::post('delpricepro','ProductController@delpricepro');
	Route::post('productsortable','ProductController@sortable');
	
	//Category
	Route::get('/category','CategoryController@category');
	Route::post('categorycreate','CategoryController@cate_store');
	Route::post('querycategory','CategoryController@cate_edit');
	Route::post('categoryupdate','CategoryController@cate_update');
	Route::get('/category/delete/{id}','CategoryController@cate_destroy');
	
	//Bank
	Route::get('/bank','BankController@index');
	Route::post('bankselect','BankController@bankselect');
	Route::post('bankcreate','BankController@store');
	Route::post('querybank','BankController@edit');
	Route::post('bankupdate','BankController@update');
	Route::get('/bank/delete/{id}','BankController@destroy');
	
	//Customer
	Route::get('/customer','CustomerController@index');
	Route::get('/customerdatatables','CustomerController@datatable');
	Route::get('/customer/create','CustomerController@create');
	Route::post('customer_create','CustomerController@store');
	Route::get('/customer/update/{id}','CustomerController@edit');
	Route::post('supconupdate','CustomerController@supconupdate');
	Route::post('supaddressupdate','CustomerController@supaddressupdate');
	Route::post('supcondelete','CustomerController@supcondelete');
	Route::post('addressdelete','CustomerController@addressdelete');
	Route::post('customer_update','CustomerController@update');
	Route::get('customer/delete/{id}','CustomerController@destroy');
	Route::get('customer/import','CustomerController@import');
	Route::get('customer/numberphone','CustomerController@numberphone');
	Route::post('customersaledata','CustomerController@customersaledata');  
	Route::post('customerreturndata','CustomerController@customerreturndata');  
	Route::post('checkcodecust','CustomerController@checkcodecust');  
	Route::get('exportdatacus','CustomerController@exportdata')->name('exportdatacus');  

	//Supplier
	Route::get('/supplier','SupplierController@index');
	Route::get('/supplierdatatables','SupplierController@datatable');
	Route::get('/supplier/create','SupplierController@create');
	Route::post('supplier_create','SupplierController@store');
	Route::get('/supplier/update/{id}','SupplierController@edit');
	Route::post('supplier_update','SupplierController@update');
	Route::get('/supplier/delete/{id}','SupplierController@destroy');
	
	//Export
	Route::get('export','ExportController@index');
	Route::get('/exportdatatables','ExportController@datatable');
	Route::get('/export/create','ExportController@create');
	Route::get('/export/gift/create/{id}','ExportController@creategift');
	Route::get('/export/update/{id}','ExportController@edit');
	Route::post('export_update','ExportController@update');
	Route::get('/export/approve/{id}','ExportController@approve');
	Route::post('export_create','ExportController@store');
	Route::post('querypromotion','ExportController@querypromotion');
	Route::get('/export/delete/{id}','ExportController@destroy');
	Route::get('/invoice/{id}','ExportController@invoice');
	Route::get('/cover/{id}','ExportController@cover');
	Route::post('kerry_create','ExportController@kerryimport');
	Route::post('dhl_create','ExportController@dhl_create');
	Route::post('export_multiprint','ExportController@multiprint');
	Route::post('customerref','ExportController@customerref');
	Route::post('queryorder','ExportController@queryorder');
	
	
	//Imports
	Route::group(['middleware' => [ CheckAuthadmin::class]], function(){
		Route::get('/import','ImportController@index'); 
		Route::get('importdatatables','ImportController@datatable');
		Route::get('/import/create','ImportController@create');
		Route::post('imports_create','ImportController@store');
		Route::get('/import/update/{id}','ImportController@edit');
		Route::post('imports_update','ImportController@update');
		Route::post('enteimportsrbarcode','AutocompleteController@enterbarcode');
		Route::post('enterimportproduct','AutocompleteController@enterproduct');
		Route::get('/delimp/{id}','ImportController@destroy');
		
	});
	Route::get('search_suplier/{id}','ImportController@search_suplier');
	Route::get('search_address/{id}','ImportController@search_address');
	
	//Return
	Route::get('/return','ReturnController@index');
	Route::post('returninv','ReturnController@returninv');
	Route::get('/return/create','ReturnController@create');
	Route::get('/returndatatables','ReturnController@datatable');
	Route::post('returnbarcode','ReturnController@returnbarcode');
	Route::post('return_create','ReturnController@store');
	Route::get('/return/delete/{id}','ReturnController@return_destroy');
	Route::get('/withdraw','ReturnController@withdraw');
	Route::get('/withdraw/create','ReturnController@withdrawcreate');
	Route::get('/withdrawdatatables','ReturnController@withdrawdatatables');
	Route::post('withdraw_create','ReturnController@withdraw_create');
	Route::get('/withdraw/delete/{id}','ReturnController@withdraw_destroy');
	
	//Return - Supplier
	Route::get('/return/supplier','ReturnsupplierController@index');
	Route::get('/returnsupplierdatatables','ReturnsupplierController@datatable');
	Route::get('/return/supplier/create','ReturnsupplierController@create');
	Route::post('returnsupplierinv','ReturnsupplierController@returnsupplierinv');
	Route::post('returnsupplier_create','ReturnsupplierController@store');
	
	//Autocomplete
	Route::post('enterbarcode','AutocompleteController@enterbarcode');
	Route::post('enterproduct','AutocompleteController@enterproduct');
	Route::get('/searchcustomername/autocomplete','AutocompleteController@searchcustomername');
	Route::get('/searchcustomertel/autocomplete','AutocompleteController@searchcustomertel');
	Route::get('/searchproductname/autocomplete','AutocompleteController@autocompleteproductname');
	
	//Payment 
	Route::get('/payment','PaymentController@index');
	Route::post('transection_create','PaymentController@store');
	Route::post('trandatatables','PaymentController@trandatatables');
	Route::post('exportdatatables','PaymentController@exportdatatables');
	Route::post('trandataquery','PaymentController@trandataquery');
	Route::post('connectpayment','PaymentController@connectpayment');
	Route::get('/master_platform/payment','PaymentController@masterplatformpayment'); 
	Route::get('/master_platform/credit','PaymentController@masterplatformcredit');
	Route::get('/master_platform/kerry','PaymentController@masterplatformkerry');
	Route::get('/master_platform/dhl','PaymentController@masterplatformdhl');
	
	//Report
	Route::get('/report/daily','ReportController@daily');
	Route::post('reportdatadaily','ReportController@reportdatadaily');
	Route::post('dailypdf','ReportController@dailypdf');
	Route::get('/dailyexcel/{start}/{end}','ReportController@dailyexcel');
	
	Route::get('/report/saler','ReportController@saler');
	Route::post('reportdatasaler','ReportController@reportdatasaler');
	Route::post('salerpdf','ReportController@salerpdf');
	Route::get('/salerexcel/{start}/{end}/{saler}','ReportController@salerexcel');
	
	Route::get('/report/product','ReportController@product');
	Route::post('reportdataproduct','ReportController@reportdataproduct');
	Route::post('productpdf','ReportController@productpdf');
	Route::get('/productexcel/{start}/{end}/{product}','ReportController@productexcel');
	
	Route::get('report/supplier','ReportController@supplier');
	Route::post('reportdatasupplier','ReportController@reportdatasupplier');
	Route::post('supplierpdf','ReportController@supplierpdf');
	Route::get('/supplierexcel/{start}/{end}/{customer}','ReportController@supplierexcel');

	
	Route::get('/report/customer','ReportController@customer');
	Route::post('reportdatacustomer','ReportController@reportdatacustomer');
	Route::post('customerpdf','ReportController@customerpdf');
	Route::get('/customerexcel/{start}/{end}/{customer}','ReportController@customerexcel');
	
	Route::get('/report/statement','ReportController@statement');
	Route::post('reportdatastate','ReportController@reportdatastate');
	Route::post('statementpdf','ReportController@statementpdf');
	Route::get('/statementexcel/{start}/{end}/{status}','ReportController@statementexcel');
	
	Route::get('/report/stock','ReportController@stock');
	Route::post('reportdatastock','ReportController@reportdatastock');
	Route::post('stockpdf','ReportController@stockpdf');
	
	Route::get('/report/return','ReportController@returns');
	Route::post('reportdatareturn','ReportController@reportdatareturn');
	Route::post('returnpdf','ReportController@returnpdf');
	Route::get('returnexcel/{start}/{end}','ReportController@returnexcel');
	
	Route::get('/report/withdraw','ReportController@withdraw');
	Route::post('reportdatawithdraw','ReportController@reportdatawithdraw');
	Route::post('withdrawpdf','ReportController@withdrawpdf');
	Route::get('withdrawexcel/{start}/{end}','ReportController@withdrawexcel');
		
	//Users
	Route::get('users','UsersController@index');
	Route::get('users/create','UsersController@create');
	Route::post('users_create','UsersController@store');
	Route::get('users/update/{id}','UsersController@edit');
	Route::post('users_update','UsersController@update');
	Route::get('usersdatatables','UsersController@datatable');
	Route::get('/users-delete/{id}','UsersController@destroy');
	Route::get('/logs','UsersController@logs');
	Route::get('/logsdatatables','UsersController@logsdatatables');
	Route::get('/exportdata','UsersController@exportdata');
	
});	

// Route::get('/clc', function() {

//     Artisan::call('cache:clear');
//     Artisan::call('config:clear');
//     Artisan::call('config:cache');
//     Artisan::call('view:clear');
//         // Artisan::call('view:clear');
//         // session()->forget('key');
//     return "Cleared!";
// });


Auth::routes();
Route::get('/', 'HomeController@index')->name('home');
Route::get('/backoffice', 'HomeController@index')->name('home');
Route::get('/home','HomeController@dashboard');
Route::get('/logout','BackofficeController@logout');