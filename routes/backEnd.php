<?php
/*
|--------------------------------------------------------------------------
| All Routes for Back End
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your NetCoden'S Back End. Just tell NetCoden the URIs it should respond
| to using a Closure or controller method. Build something great!
|
|
|  Designer : NetCoden
|  Developer: NetCoden
|  Maintenance: NetCoden
|  Website: http://netcoden.com
|
*/


// Route with localization

Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localize' ]
    ], function()
{
    
/*=================================
=     Authentication Section      =
=================================*/

Route::get('/register', 'AuthController@getRegister');
Route::post('/register', 'AuthController@postRegister');

Route::get('/member/confirm-registration/{token}', 'AuthController@getConfirmLiveAccountRegistration');

Route::get('/login', 'AuthController@getLogin');

Route::post('/login', 'AuthController@postLogin');
Route::get('/logout', 'AuthController@getLogout');

/*=================================
=          Password Resets        =
=================================*/

Route::get('/reset-password', 'AuthController@getResetPassword');

Route::post('/reset-password', 'AuthController@postResetPassword');

Route::get('/reset-password-successful/{token}', 'AuthController@getResetPasswordSuccessful');



/*=================================
=          Test Mail PDF          =
=================================*/

// Route::get('/test-mail-pdf', 'CrmController@testMailPdf');


/*=================================
=    Live Account Registration    =
=================================*/

Route::get('/live-account-register', 'AuthController@getLiveAccountRegister');
Route::post('/live-account-register', 'AuthController@postLiveAccountRegister');

Route::get('/live-account-registration/{token}', 'AuthController@successLiveAccountRegistration');



/*=================================
=    Demo Account Registration    =
=================================*/

 Route::get('/demo-account-register', 'AuthController@getDemoAccountRegister');
Route::post('/demo-account-register', 'AuthController@postDemoAccountRegister');

Route::get('/demo-account-registration/{token}', 'AuthController@successDemoAccountRegistration');

/*=================================
=    sucess page   =
=================================*/

Route::get('/success-reset-link', 'AuthController@successRegistration');
Route::get('/success-registration', 'AuthController@successRegistration');
Route::get('/password-reset-successful', 'AuthController@successRegistration');
Route::get('/confirm-email', 'AuthController@successRegistration');


Route::get('/get-states', 'CrmController@errorNotFound');
Route::post('/get-states', 'AuthController@getStates');

Route::get('/get-cities', 'CrmController@errorNotFound');
Route::post('/get-cities', 'AuthController@getCities');
Route::get('/error-page', 'CrmController@errorNotFound');
/*=================================
=          Home Page              =
=================================*/

Route::get('/dashboard',  'CrmController@getIndex');
Route::post('/become_an_ib',  'CrmController@becomeIB');

/*=================================
=       Open New Account      =
=================================*/
Route::get('/open-new-account',  'CrmController@openNewAccount');

/*=================================
=       Open Demo Account      =
=================================*/

Route::get('/open-demo-account',  'CrmController@openDemoAccount');

Route::post('/open-demo-account',  'CrmController@openDemoAccountConfirmation');


/*=================================
=       Open Trading Account      =
=================================*/

Route::get('/open-trading-account',  'CrmController@openTradingAccount');
Route::post('/open-trading-account',  'CrmController@openTradingAccountConfirmation');

/*=================================
=       Open Manager Account      =
=================================*/

// Route::get('/open-manager-account',  'SocialTradingController@openManagerAccount');
// Route::post('/open-manager-account',  'SocialTradingController@confirmManagerAccount');

/*=================================
=       Open Investor Account      =
=================================*/
// Route::get('/manager-list',  'SocialTradingController@showManagers');
// Route::get('/open-investor-account/{manager_id}',  'SocialTradingController@openInvestorAccount');
// Route::post('/open-investor-account',  'SocialTradingController@confirmInvestorAccount');

/*=================================
=      Strategic Manager Detail   =
=================================*/
// Route::get('/managers/detail/{manager_id}', 'SocialTradingController@getManagerDetail');

/*=================================
=  Controlling Investor accounts   =
=================================*/
// Route::get('/accounts/trading/manager', 'SocialTradingController@allManagerTradingAccounts');
// Route::get('/managers/trading_account-{id}',  'SocialTradingController@managerAccountTradingDetails');
// Route::get('/managers/enable-disable-investor/{id}',  'SocialTradingController@managerEnableDisableInvestor');
// Route::get('/managers/change-allocation-type/{id}/{allocation_type}',  'SocialTradingController@managerChangeAllocationType');
// Route::post('/managers/update-allocation',  'SocialTradingController@updateAllocation');
// Route::post('/managers/live-trades',  'SocialTradingController@managerInvestorLiveTrades');
// Route::post('/managers/reports',  'SocialTradingController@managerReports');
// Route::post('/managers/commissions',  'SocialTradingController@managerCommissions');
// Route::post('/managers/commission-history',  'SocialTradingController@managerCommissionHistory');
// Route::post('/managers/remove-investor-account',  'SocialTradingController@managerRemoveInvestorAccount');

/*=================================
=              Profile            =
=================================*/

Route::get('/profile',  'CrmController@profile');
Route::post('/upload-profile-pic','CrmController@uploadProfilePic');
Route::get('/update-profile',  'CrmController@errorNotFound');
Route::post('/update-profile',  'CrmController@postUpdateProfile');
Route::get('/change-password',  'CrmController@changePassword');
Route::get('/send-password-reset-code','CrmController@sendPasswordResetCode');
Route::get('/check-verification-code/{code}','CrmController@checkVerificationCode');
Route::post('/change-password', 'CrmController@postChangePassword');
Route::post('/save-updated-password', 'CrmController@saveUpdatedPassword');
Route::get('/password-verification',  'CrmController@errorNotFound');
Route::post('/password-verification',  'CrmController@passwordVerification');

Route::get('/verify-profile',  'CrmController@verifyProfile');
Route::post('/verify-profile',  'CrmController@postVerifyProfile');

Route::get('/identity-documents-details','CrmController@identityDetails');
Route::get('/resident-documents-details','CrmController@residenceDetails');
Route::get('/not-verified','CrmController@notVerified');

Route::post('/identity-document-upload','CrmController@identityDocumentUpload');
Route::post('/resident-document-upload','CrmController@residentDocumentUpload');

Route::get('/bank-information',  'CrmController@bankInformation');
Route::post('/bank-information',  'CrmController@postBankInformation');

Route::post('/notification-status-update','CrmController@notificationStatusUpdate');



/*=================================
=      All Trading Accounts       =
=================================*/

Route::get('/all-trading-accounts',  'CrmController@allTradingAccounts');


/*=================================
=            Live Trades          =
=================================*/

Route::get('/live-trades',  'CrmController@getLiveTrades');


/*=================================
=     Transaction History         =
=================================*/

Route::get('/transaction-history',  'CrmController@transactionHistory');
Route::get('/transaction-history-datatable',  'CrmController@transactionHistoryDatatable');


/*=================================
=          Trading Details        =
=================================*/


Route::get('/trading_account-{id}',  'CrmController@tradingDetails');

Route::get('/trading-history-single-datatable','CrmController@tradingHistorySingleDatatable');

Route::get('/trading-history-single-total','CrmController@tradingHistorySingleTotal');



/*=================================
=          Change Leverage        =
=================================*/

Route::get('/change-leverage',  'CrmController@changeLeverage');
Route::post('/change-leverage',  'CrmController@postChangeLeverage');

Route::get('/leverage-verification',  'CrmController@errorNotFound');
Route::post('/leverage-verification',  'CrmController@leverageVerification');

/*=================================
=          Change MT4 Password        =
=================================*/

Route::get('/change-mt4-password',  'CrmController@changeMt4Password');

Route::get('/mt4-password',  'CrmController@errorNotFound');
Route::post('/mt4-password',  'CrmController@mt4Password');
Route::get('/mt4-investor-password',  'CrmController@errorNotFound');
Route::post('/mt4-investor-password',  'CrmController@mt4InvestorPassword');

Route::post('/change-mt4-password',  'CrmController@postChangeMt4Password');

Route::get('/mt4-password-verification',  'CrmController@errorNotFound');
Route::post('/mt4-password-verification',  'CrmController@mt4PasswordVerification');

Route::post('/change-mt4-investor-password',  'CrmController@postChangeMt4InvestorPassword');

Route::get('/mt4-investor-password-verification',  'CrmController@errorNotFound');
Route::post('/mt4-investor-password-verification',  'CrmController@mt4InvestorPasswordVerification');


/*=================================
=    Download Trading Platforms   =
=================================*/


Route::get('/download-platforms', 'CrmController@downloadPlatforms');


/*=================================
=          Internal Transfer      =
=================================*/

Route::get('/internal-transfer',  'CrmController@internalTransfer');
Route::post('/internal-transfer',  'CrmController@postInternalTransfer');

Route::get('/internal-verification',  'CrmController@errorNotFound');
Route::post('/internal-verification',  'CrmController@postInternalVerification');

/*=================================
=          Withdraw Funds         =
=================================*/

// Route::get('/withdraw-funds',  'CrmController@withdrawFunds');

// Route::get('/neteller_withdraw',  'CrmController@netellerWithdraw');
// Route::post('/neteller_withdraw',  'CrmController@postNetellerWithdraw');

// Route::get('/perfect_money_withdraw',  'CrmController@perfectMoneyWithdraw');
// Route::post('/perfect_money_withdraw',  'CrmController@postPerfectMoneyWithdraw');

// Route::get('/skrill_withdraw',  'CrmController@skrillWithdraw');
// Route::post('/skrill_withdraw',  'CrmController@postSkrillWithdraw');

// Route::get('/okpay_withdraw',  'CrmController@okpayWithdraw');
// Route::post('/okpay_withdraw',  'CrmController@postOkpayWithdraw');

Route::get('/bank-withdraw-funds',  'CrmController@bankWithdrawFunds');
Route::post('/bank-withdraw-funds',  'CrmController@postBankWithdrawFunds');

Route::get('/verification',  'CrmController@errorNotFound');
Route::post('/verification',  'CrmController@postVerification');




/*=================================
=          Deposit Funds          =
=================================*/

Route::get('/deposit-funds',  'CrmController@depositFunds');
Route::get('/bank-transfer-funds',  'CrmController@bankFunds');

// Route::get('/local-bank-transfer-funds',  'DepositController@localbankFunds');
// Route::post('/local-bank-transfer-funds',  'DepositController@postlocalbankFunds');

// Route::get('/neteller_deposit',  'DepositController@netellerDeposit');
// Route::post('/neteller_deposit',  'DepositController@postNetellerDeposit');

// /*form */
// Route::get('/form_deposit',  'DepositController@netellerDeposit');
// Route::post('/form_deposit',  'DepositController@postNetellerDeposit');



// Route::get('/skrill_deposit_test',  'DepositController@skrillDepositTest');
// Route::get('/skrill_deposit',  'DepositController@skrillDeposit');
// Route::post('/skrill_deposit',  'DepositController@postSkrillDeposit');
// Route::get('/skrill_deposit_success',  'DepositController@skrillDepositSuccess');
// Route::get('/skrill_deposit_cancel',  'DepositController@skrillDepositCancel');
// Route::get('/skrill_deposit_status',  'CrmController@errorNotFound');
// Route::post('/skrill_deposit_status',  'DepositController@skrillDepositStatus');

// Route::get('/perfect_money_deposit',  'DepositController@perfectMoneyDeposit');
// Route::post('/perfect_money_deposit',  'DepositController@postPerfectMoneyDeposit');
// Route::get('/perfect_money_deposit_success',  'DepositController@perfectMoneyDepositSuccess');
// Route::get('/perfect_money_deposit_cancel',  'DepositController@perfectMoneyDepositCancel');
// Route::post('/perfect_money_deposit_status',  'DepositController@perfectMoneyDepositStatus');

// Route::get('/perfect_money_deposit_status',  'CrmController@errorNotFound');


// Route::get('/voguepay_deposit',  'DepositController@voguepayDeposit');
// Route::post('/voguepay_deposit',  'DepositController@postVoguepayDeposit');

// Route::post('/voguepay_deposit_notify',  'DepositController@voguepayDepositNotify');

// Route::get('/voguepay_deposit_notify',  'CrmController@errorNotFound');


// Route::get('/upaycard-deposit',  'DepositController@upaycardDeposit');
// Route::post('/upaycard-deposit',  'DepositController@postUpaycardDeposit');
// Route::get('/upaycard-deposit-success',  'DepositController@upaycardDepositSuccess');
// Route::get('/upaycard-deposit-fail',  'DepositController@upaycardDepositFail');
// Route::get('/upaycard-api-fail',  'DepositController@upaycardDepositFail');


/*=================================
=                Contest             =
=================================*/

Route::get('/contest',  'CrmController@getContest');

/*=================================
=            Pam Mamm             =
=================================*/

Route::get('/mam-pamm-platform',  'CrmController@getMamPammPlatform');


/*=================================
=                FAQs             =
=================================*/

Route::get('/faqs',  'CrmController@getFaqs');

/*=================================
=         Open Ticket             =
=================================*/

Route::get('/open-ticket',  'TicketController@openTicket');
Route::get('/my-tickets',  'TicketController@myTickets');
Route::get('/my-tickets-datatable','TicketController@myTicketsDatatable');
Route::post('/store-ticket','TicketController@storeTicket');
Route::get('/ticket-details-{id}','TicketController@ticketDetails');
Route::post('/store-ticket-message','TicketController@storeTicketReply');

});





