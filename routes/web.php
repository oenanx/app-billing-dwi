<?php

use Illuminate\Support\Facades\Route;

Route::get('refresh-csrf', function(){
    return csrf_token();
});

Route::group(['middleware' => 'prevent-back-history'],function()
{
    //Route::get('/', [\App\Http\Controllers\Home::class, 'index']);

	//Route::post('/captcha-validation', [\App\Http\Controllers\Home::class, 'authenticate']);
	
	//Route::get('/reload-captcha', [\App\Http\Controllers\Home::class, 'reloadCaptcha'])->name('login.reloadCaptcha');

    Route::get('/home', [\App\Http\Controllers\Home::class, 'home']);

    Route::get('Home/home', [\App\Http\Controllers\Home::class, 'dashboard']);

    //Route::post('login', [\App\Http\Controllers\Home::class, 'authenticate'])->name('login.authenticate');

    //Route::get('forget', [\App\Http\Controllers\Home::class, 'forget'])->name('login.forget');

    //Route::post('resetpasswd', [\App\Http\Controllers\Home::class, 'resetpasswd'])->name('login.resetpasswd');

    Route::get('logout', [\App\Http\Controllers\Home::class, 'logout'])->name('logout');

	//Group Customer
	Route::get('/cariGCustomer/{id}', [\App\Http\Controllers\GCustomer::class, 'cariGCustomer']);
	Route::get('/autogsearch', [\App\Http\Controllers\AutoController::class, 'autocompleteGSearch']);
	Route::get('/mgcustomer', [\App\Http\Controllers\GCustomer::class, 'index']);
	Route::post('mgcustomer/datatable', [\App\Http\Controllers\GCustomer::class, 'index']);
	Route::post('/insertmgcustomer', [\App\Http\Controllers\GCustomer::class, 'insert']);
	Route::get('/vgcustomer/{id}', [\App\Http\Controllers\GCustomer::class, 'view']);
	Route::post('/editmgcustomer', [\App\Http\Controllers\GCustomer::class, 'edit']);
	Route::get('/delgcustomer/{id}', [\App\Http\Controllers\GCustomer::class, 'delete']);

	//Registration Customer
    Route::get('Registration/index', [\App\Http\Controllers\Registration::class, 'index']);
    Route::post('Registration/datatable', [\App\Http\Controllers\Registration::class, 'index'])->name('Registration.datatable');
    Route::post('Registration/InsCust', [\App\Http\Controllers\Registration::class, 'InsertReg']);
    Route::post('Registration/InsRates', [\App\Http\Controllers\Registration::class, 'InsertRates']);
    Route::post('Registration/Completed', [\App\Http\Controllers\Registration::class, 'Completed']);
    Route::get('Registration/viewReg/{id}', [\App\Http\Controllers\Registration::class, 'viewReg'])->name('Registration.view');
    Route::get('Registration/deleteReg/{id}', [\App\Http\Controllers\Registration::class, 'deleteReg']);
    Route::get('Registration/newregistration', [\App\Http\Controllers\Registration::class, 'newregistration']);

    Route::get('M_Company/index', [\App\Http\Controllers\M_Company::class, 'index']);
    Route::post('M_Company/datatable', [\App\Http\Controllers\M_Company::class, 'index'])->name('M_Company.datatable');
    //Route::get('M_Company/delete_cust/{id}', [\App\Http\Controllers\M_Company::class, 'delete_cust']);
    Route::get('M_Company/createaccount/{id}', [\App\Http\Controllers\M_Company::class, 'accountcustomer']);
    Route::post('M_Company/InsCust', [\App\Http\Controllers\M_Company::class, 'InsCust']);
    Route::get('M_Company/view_cust/{id}', [\App\Http\Controllers\M_Company::class, 'view_cust'])->name('M_Company.view');
    Route::get('M_Company/update_cust', [\App\Http\Controllers\M_Company::class, 'update_cust']);
    Route::post('M_Company', [\App\Http\Controllers\M_Company::class, 'getcompany'])->name('M_Company.getcompany');
	Route::get('/autocomplete-search', [\App\Http\Controllers\M_Company::class, 'autocompleteSearch']);
	Route::get('/autocomplete-lokalsearch', [\App\Http\Controllers\M_Company::class, 'autocompleteLokalSearch']);
	Route::get('/autocomplete-periodsearch', [\App\Http\Controllers\M_Company::class, 'autocompletePeriodSearch']);
	Route::get('/cariCustomer/{id}', [\App\Http\Controllers\M_Company::class, 'cariCustomer']);
	Route::get('/cariLokalCustomer/{id}', [\App\Http\Controllers\M_Company::class, 'cariLokalCustomer']);
    Route::get('M_Company/view_ftp/{id}', [\App\Http\Controllers\M_Company::class, 'view_ftp'])->name('M_Company.viewftp');
    Route::get('M_Company/update_ftp', [\App\Http\Controllers\M_Company::class, 'update_ftp']);

    Route::get('M_Products/index', [\App\Http\Controllers\M_Products::class, 'index']);
    Route::post('M_Products/datatable', [\App\Http\Controllers\M_Products::class, 'index'])->name('M_Products.datatable');
    Route::get('M_Products/view_products/{id}', [\App\Http\Controllers\M_Products::class, 'view_products']);

    Route::get('M_Rates/index', [\App\Http\Controllers\M_Rates::class, 'index']);
    Route::get('M_Rates/create/{id}', [\App\Http\Controllers\M_Rates::class, 'creates']);
    Route::post('M_Rates/datatable', [\App\Http\Controllers\M_Rates::class, 'index'])->name('M_Rates.datatable');
    Route::get('M_Rates/delete_rates/{id}', [\App\Http\Controllers\M_Rates::class, 'delete_rates']);
    Route::post('M_Rates/InsRates', [\App\Http\Controllers\M_Rates::class, 'InsRates']);
    Route::get('M_Rates/view_rates/{id}', [\App\Http\Controllers\M_Rates::class, 'view_rates'])->name('M_Rates.view');
    Route::get('M_Rates/view_rates_pstn/{id}', [\App\Http\Controllers\M_Rates::class, 'view_rates_pstn']);
    Route::get('M_Rates/view_rates_gsm/{id}', [\App\Http\Controllers\M_Rates::class, 'view_rates_gsm']);
    Route::post('M_Rates/update_rates', [\App\Http\Controllers\M_Rates::class, 'update_rates']);
    Route::post('M_Rates', [\App\Http\Controllers\M_Rates::class, 'getcompany'])->name('M_Rates.getcompany');
	Route::get('/auto-search', [\App\Http\Controllers\M_Rates::class, 'autoSearch']);
    Route::get('/cariCompany/{id}', [\App\Http\Controllers\M_Rates::class, 'cariCompany']);

    Route::get('M_Trial/index', [\App\Http\Controllers\M_Trial::class, 'index']);
    Route::post('M_Trial/datatable', [\App\Http\Controllers\M_Trial::class, 'index'])->name('M_Trial.datatable');
    Route::get('M_Trial/view_data/{id}', [\App\Http\Controllers\RegistrationTrial::class, 'view_cust']);
    Route::get('M_Trial/view_rates/{id}', [\App\Http\Controllers\RegistrationTrial::class, 'view_rates']);
    Route::post('RegistrationTrial/view_services/{id}', [\App\Http\Controllers\RegistrationTrial::class, 'view_services']);
	Route::get('RegistrationTrial/view_usage/{id}', [\App\Http\Controllers\RegistrationTrial::class, 'view_usage']);
	Route::post('RegistrationTrial/datatableusage/{params}', [\App\Http\Controllers\RegistrationTrial::class, 'datatableusage']);
	Route::get('RegistrationTrial/downloadlog/{params}', [\App\Http\Controllers\RegistrationTrial::class, 'downloadlog']);
	Route::post('RegistrationTrial/datatableAll/{params}', [\App\Http\Controllers\RegistrationTrial::class, 'datatableAll']);

    Route::get('M_Postpaid/index', [\App\Http\Controllers\M_Postpaid::class, 'index']);
    Route::post('M_Postpaid/datatable', [\App\Http\Controllers\M_Postpaid::class, 'index'])->name('M_Postpaid.datatable');
	Route::post('M_Postpaid/datatable_rates/{id}', [\App\Http\Controllers\M_Postpaid::class, 'datatable_rates']);
    Route::get('M_Postpaid/view_data/{id}', [\App\Http\Controllers\RegistrationPostpaid::class, 'view_cust']);
    Route::get('M_Postpaid/view_rates/{id}', [\App\Http\Controllers\RegistrationPostpaid::class, 'view_rates']);
    Route::post('RegistrationPostpaid/view_services/{id}', [\App\Http\Controllers\RegistrationPostpaid::class, 'view_services']);
	Route::get('RegistrationPostpaid/view_usage/{id}', [\App\Http\Controllers\RegistrationPostpaid::class, 'view_usage']);
	Route::post('RegistrationPostpaid/datatableusage/{params}', [\App\Http\Controllers\RegistrationPostpaid::class, 'datatableusage']);
	Route::get('RegistrationPostpaid/downloadlog/{params}', [\App\Http\Controllers\RegistrationPostpaid::class, 'downloadlog']);
	Route::post('RegistrationPostpaid/datatableAll/{params}', [\App\Http\Controllers\RegistrationPostpaid::class, 'datatableAll']);

    Route::get('M_Completed/index', [\App\Http\Controllers\M_Completed::class, 'index']);
	Route::get('M_Completed/complete_cust/{id}', [\App\Http\Controllers\M_Completed::class, 'complete_cust']);
	Route::get('M_Completed/sync/{id}', [\App\Http\Controllers\M_Completed::class, 'sync']);
	
    Route::get('PaymentPeriod/index', [\App\Http\Controllers\PaymentPeriod::class, 'index']);
    //Route::post('Payment/datatable', [\App\Http\Controllers\PaymentPeriod::class, 'index'])->name('PaymentPeriod.datatable');
	Route::post('PaymentPeriod/{period}', [\App\Http\Controllers\PaymentPeriod::class, 'searching']);
	Route::post('SearchingPeriod/{period}', [\App\Http\Controllers\PaymentPeriod::class, 'searching']);
	Route::post('Insertpaymentperiod', [\App\Http\Controllers\PaymentPeriod::class, 'insert']);
    Route::get('PaymentPeriod/view/{id}', [\App\Http\Controllers\PaymentPeriod::class, 'view'])->name('PaymentPeriod.view');
    Route::post('PaymentPeriod/update', [\App\Http\Controllers\PaymentPeriod::class, 'update']);
    Route::get('PaymentPeriod/delete/{id}', [\App\Http\Controllers\PaymentPeriod::class, 'delete']);
	
    Route::get('Payment/index', [\App\Http\Controllers\Payment::class, 'index']);
    //Route::post('Payment/datatable', [\App\Http\Controllers\Payment::class, 'index'])->name('Payment.datatable');
	Route::post('Searching/{period}', [\App\Http\Controllers\Payment::class, 'searching']);
	Route::post('Insertpayment', [\App\Http\Controllers\Payment::class, 'insert']);
    Route::get('Payment/view/{id}', [\App\Http\Controllers\Payment::class, 'view'])->name('Payment.view');
    Route::post('Payment/update', [\App\Http\Controllers\Payment::class, 'update']);
    Route::get('Payment/delete/{id}', [\App\Http\Controllers\Payment::class, 'delete']);
	
    Route::get('InvoicePeriod/index', [\App\Http\Controllers\InvoicePeriod::class, 'index']);
	Route::get('InvoicePeriod/viewInvoice/{ids}', [\App\Http\Controllers\PDFInvPeriod::class, 'index']);
    Route::post('InvoicePeriod/datatable', [\App\Http\Controllers\InvoicePeriod::class, 'datatable']);
    Route::post('InvoicePeriod/datatable2', [\App\Http\Controllers\InvoicePeriod::class, 'datatable2']);
    Route::get('InvoicePeriod/download/{id}', [\App\Http\Controllers\InvoicePeriod::class, 'download']);
    Route::get('InvoicePeriod/delete/{id}', [\App\Http\Controllers\InvoicePeriod::class, 'delete']);
    Route::get('InvoicePeriod/addInv/{id}', [\App\Http\Controllers\InvoicePeriod::class, 'addInv']);
	
    Route::get('Invoice/index', [\App\Http\Controllers\Invoice::class, 'index']);
	Route::post('/viewInvoice', [\App\Http\Controllers\PDFInv::class, 'index']);
    Route::post('Invoice/datatable', [\App\Http\Controllers\Invoice::class, 'datatable']);
    Route::get('Invoice/download/{id}', [\App\Http\Controllers\Invoice::class, 'download']);
    Route::get('Invoice/delete/{id}', [\App\Http\Controllers\Invoice::class, 'delete']);
    Route::get('Invoice/addInv/{id}', [\App\Http\Controllers\Invoice::class, 'addInv']);
	
    Route::get('Inquiry/index', [\App\Http\Controllers\Inquiry::class, 'index']);
    Route::post('Inquiry/datatable', [\App\Http\Controllers\Inquiry::class, 'index']);
    Route::post('Inquiry/bsperiod/{id}', [\App\Http\Controllers\ViewBSPeriod::class, 'bs']);
    Route::post('Inquiry/payperiod/{id}', [\App\Http\Controllers\ViewBSPeriod::class, 'pay']);
    Route::post('Inquiry/bs/{id}', [\App\Http\Controllers\ViewBS::class, 'bs']);
    Route::post('Inquiry/pay/{id}', [\App\Http\Controllers\ViewBS::class, 'pay']);
	
    Route::get('MaintenancePeriod/index', [\App\Http\Controllers\MaintenancePeriod::class, 'index']);
	Route::post('/periode_proses', [\App\Http\Controllers\MaintenancePeriod::class, 'proses']);
	
    Route::get('MaintenanceMonth/index', [\App\Http\Controllers\Maintenance::class, 'index']);
	Route::post('/proses', [\App\Http\Controllers\Maintenance::class, 'proses']);

    Route::get('SummaryMonth/index', [\App\Http\Controllers\Reports::class, 'summarymonth']);
    Route::post('SummaryMonth/dtTables_rpt/{params}', [\App\Http\Controllers\Reports::class, 'datatable']);
	Route::get('SummaryMonth/rptadmxls/{params}', [\App\Http\Controllers\Reports::class, 'searching']);

	Route::get('Whiz/autocomplete', [\App\Http\Controllers\Whiz::class, 'autocomplete']);
	Route::get('Whiz/cariCustomer/{id}', [\App\Http\Controllers\Whiz::class, 'cariCustomer']);
	Route::get('Whiz/getID', [\App\Http\Controllers\Whiz::class, 'getID']);
	Route::get('Whiz/index', [\App\Http\Controllers\Whiz::class, 'index']);
	Route::get('Whiz/view/{id}', [\App\Http\Controllers\Whiz::class, 'view']);
	Route::post('Whiz/proses', [\App\Http\Controllers\Whiz::class, 'proses']);
	Route::post('Whiz/copy_result', [\App\Http\Controllers\Whiz::class, 'copy_result']);
	Route::post('Whiz/order', [\App\Http\Controllers\Whiz::class, 'order']);
	Route::get('Whiz/download/{id}', [\App\Http\Controllers\Whiz::class, 'download']);
	Route::get('Whiz/downskip/{id}', [\App\Http\Controllers\Whiz::class, 'downskip']);
	Route::get('Whiz/downscreenhp/{id}', [\App\Http\Controllers\Whiz::class, 'downscreenhp']);
	Route::get('Whiz/downscreenwa/{id}', [\App\Http\Controllers\Whiz::class, 'downscreenwa']);
	Route::post('Whiz/datatable', [\App\Http\Controllers\Whiz::class, 'dttable']);
	Route::get('Whiz/complete/{id}', [\App\Http\Controllers\Whiz::class, 'complete']);
	Route::get('Whiz/delete/{id}', [\App\Http\Controllers\Whiz::class, 'deleted']);

	Route::get('Screen/autocomplete', [\App\Http\Controllers\Screen::class, 'autocomplete']);
	Route::get('Screen/cariFile/{id}', [\App\Http\Controllers\Screen::class, 'cariFile']);
	Route::get('Screen/index', [\App\Http\Controllers\Screen::class, 'index']);
	Route::post('Screen/proseshp', [\App\Http\Controllers\Screen::class, 'proseshp']);
	Route::post('Screen/proseswa', [\App\Http\Controllers\Screen::class, 'proseswa']);
	Route::post('Screen/datatable', [\App\Http\Controllers\Screen::class, 'dttable']);
	Route::get('Screen/download/{id}', [\App\Http\Controllers\Screen::class, 'download']);

	Route::get('UploadFTP/index', [\App\Http\Controllers\UploadFTP::class, 'index']);
	Route::post('UploadFTP/datatable', [\App\Http\Controllers\UploadFTP::class, 'dttable']);
	Route::post('UploadFTP/proses', [\App\Http\Controllers\UploadFTP::class, 'proses']);
    Route::get('UploadFTP/upload/{id}', [\App\Http\Controllers\UploadFTP::class, 'upload']);
	
	
    Route::get('InquiryApi/index', [\App\Http\Controllers\InquiryApi::class, 'index']);
    Route::post('InquiryApi/datatable', [\App\Http\Controllers\InquiryApi::class, 'index']);
    Route::post('InquiryApi/bsprepaid/{id}', [\App\Http\Controllers\ViewBSPrepaid::class, 'bs']);
    Route::post('InquiryApi/payprepaid/{id}', [\App\Http\Controllers\ViewBSPrepaid::class, 'pay']);
    Route::get('InquiryApi/bspostpaid/{id}', [\App\Http\Controllers\ViewBSPostpaid::class, 'bs']);
    Route::post('InquiryApi/paypostpaid/{id}', [\App\Http\Controllers\ViewBSPostpaid::class, 'pay']);
	
    Route::get('InvoicePrepaid/index', [\App\Http\Controllers\InvoicePrepaid::class, 'index']);
	Route::post('InvoicePrepaid/crtInvoice', [\App\Http\Controllers\PDFInvPrepaid::class, 'index']);
	
    Route::get('InvoicePostpaid/index', [\App\Http\Controllers\InvoicePostpaid::class, 'index']);
	Route::post('InvoicePostpaid/crtInvoice', [\App\Http\Controllers\PDFInvPostpaid::class, 'index']);
	
    Route::get('MaintenancePrepaid/index', [\App\Http\Controllers\MaintenancePrepaid::class, 'index']);
    Route::post('MaintenancePrepaid/get_usage', [\App\Http\Controllers\MaintenancePrepaid::class, 'get_usage']);
	Route::post('MaintenancePrepaid/proses', [\App\Http\Controllers\MaintenancePrepaid::class, 'proses']);
	
    Route::get('MaintenancePostpaid/index', [\App\Http\Controllers\MaintenancePostpaid::class, 'index']);
    Route::post('MaintenancePostpaid/get_usage', [\App\Http\Controllers\MaintenancePostpaid::class, 'get_usage']);
	Route::post('MaintenancePostpaid/proses', [\App\Http\Controllers\MaintenancePostpaid::class, 'proses']);
	
    Route::get('PaymentPrepaid/index', [\App\Http\Controllers\PaymentPrepaid::class, 'index']);
	Route::post('PaymentPrepaid/{period}', [\App\Http\Controllers\PaymentPrepaid::class, 'searching']);
	Route::post('SearchingPrepaid/{period}', [\App\Http\Controllers\PaymentPrepaid::class, 'searching']);
	Route::post('InsertpaymentPrepaid', [\App\Http\Controllers\PaymentPrepaid::class, 'insert']);
    Route::get('PaymentPrepaid/view/{id}', [\App\Http\Controllers\PaymentPrepaid::class, 'view']);
    Route::post('PaymentPrepaid/update', [\App\Http\Controllers\PaymentPrepaid::class, 'update']);
    Route::get('PaymentPrepaid/delete/{id}', [\App\Http\Controllers\PaymentPrepaid::class, 'delete']);
	
    Route::get('PaymentPostpaid/index', [\App\Http\Controllers\PaymentPostpaid::class, 'index']);
    Route::get('PaymentPostpaid/view_detail/{id}', [\App\Http\Controllers\PaymentPostpaid::class, 'view_detail']);
	Route::post('PaymentPostpaid/Datatable/{id}', [\App\Http\Controllers\PaymentPostpaid::class, 'view_detail']);
	Route::post('InsertPaymentPostpaid', [\App\Http\Controllers\PaymentPostpaid::class, 'insert']);
    Route::get('PaymentPostpaid/view/{id}', [\App\Http\Controllers\PaymentPostpaid::class, 'view']);
    Route::post('PaymentPostpaid/input', [\App\Http\Controllers\PaymentPostpaid::class, 'insert']);
    Route::get('PaymentPostpaid/update', [\App\Http\Controllers\PaymentPostpaid::class, 'update']);
    Route::get('PaymentPostpaid/delete/{id}', [\App\Http\Controllers\PaymentPostpaid::class, 'delete']);

	Route::get('/autocomplete-apisearch', [\App\Http\Controllers\M_CompanyAPI::class, 'autocompleteAPISearch']);
	Route::get('/cariAPICustomer/{id}', [\App\Http\Controllers\M_CompanyAPI::class, 'cariAPICustomer']);

});
