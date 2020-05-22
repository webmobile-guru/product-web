<?php
header('Access-Control-Allow-Origin: *');
header( 'Access-Control-Allow-Headers: Authorization, Content-Type' );
header( 'Access-Control-Allow-Methods: POST,GET,OPTIONS,PUT,DELETE' );
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



Route::get('/', 'PageController@home')->name('home');
Route::get('locale/{locale}','PageController@setLocale')->name('portal.setLocale');
/*Route::get('locale/{locale}', function($locale) {
    $locale = strtolower($locale);
    $locales = config('app.locales');
    if ( ! array_key_exists($locale, $locales)){
        $locale = config('app.locale');
    }

    cookie()->queue(cookie()->forever('locale', $locale));

    return ['status' => true];
});*/
//Route::get('/', ['as' => 'home', 'uses' => 'Auth\LoginController@showLoginForm']);
Auth::routes();
Route::post('receivedDochTransaction', 'DochTransactionController@receivedDochTransaction')->name('DochTransaction.receivedDochTransaction');
Route::get('faq', 'PageController@faq')->name('page.faq');
Route::get('about', 'PageController@about')->name('page.about');

Route::get('contact', 'PageController@contact')->name('page.contact');
Route::post('contact', 'PageController@postContact')->name('page.contact.post');

Route::get('privacy-policy', 'PageController@privacyPolicy')->name('page.privacy-policy');
Route::get('testimonials', 'PageController@testimonials')->name('page.testimonials');
Route::get('gainers', 'PageController@gainers')->name('page.gainers');
Route::get('terms-and-conditions', 'PageController@termsAndConditions')->name('page.terms-and-conditions');


Route::get('ico', 'ICOController@showListedIco')->name('ico.list');

Route::get('ico/pre', 'ICOController@showPreIco')->name('ico.list.pre');
Route::get('ico/ongoing', 'ICOController@showOngoingIco')->name('ico.list.ongoing');
Route::get('ico/upcoming', 'ICOController@showUpcomingIco')->name('ico.list.upcoming');
Route::get('ico/past', 'ICOController@showPastIco')->name('ico.list.past');
Route::get('ico/airdrops', 'ICOController@showAirdropIco')->name('ico.list.airdrops');

//Route::get('ico/top', 'ICOController@showListedIco')->name('ico.list');

Route::get('ico/{slug}', 'ICOController@showSpecificIco')->name('ico.display');




Route::get('email-verification/error', 'Auth\RegisterController@getVerificationError')->name('email-verification.error');
Route::get('email-verification/check/{token}', 'Auth\RegisterController@getVerification')->name('email-verification.check');

// Routes for file controller
Route::get('ico/{directory}/{file}','FileController@getFileFromIco')->name('ico.file.get');
Route::get('/avatar/{file}/{user?}', 'FileController@getPhoto')->name('photo.get');


Route::post('payment/notification','PaymentController@notification');

Route::get('exchange', 'ExchangeController@index')->name('exchange.index');
Route::post('order-post', 'ExchangeController@orderPost')->name('exchange.order.post');
Route::post('stop-limit', 'ExchangeController@stopLimit')->name('exchange.order.limit');
Route::post('post-troll', 'ExchangeController@postTroll')->name('exchange.post.troll');

Route::get('/common','ExchangeController@orderTable');
Route::get('/PrivateInfo','ExchangeController@PrivateInfo');
Route::get('/TradeHistory','ExchangeController@TradeHistory');
Route::get('/UserTradeHistory','ExchangeController@UserTradeHistory');

Route::get('/history','ExchangeController@UserTradeHistoryFull');

Route::get('/marketTreicker','ExchangeController@returnTrickar');
Route::get('/last-price','ExchangeController@currentPrice');
Route::get('/daysReport','ExchangeController@daysReport');

Route::get('submit-ico', 'ICOController@showSubmitIcoForm')->name('ico.submit.show');
Route::post('submit-ico', 'ICOController@processIcoForm')->name('ico.submit.process');
Route::get('submit-ico/{ico}/success', 'ICOController@success')->name('ico.submit.success');



// Route::group(['middleware' => ['auth','twofa']], function(){
Route::group(['middleware' => ['auth']], function(){
	
	Route::get('loginAsAdmin',function(){ 
		if(Session::get('adminLogin')){
			Session::forget('adminLogin');
			Auth::loginUsingId(1);
			return redirect()->route('admin.user.index');
		}else{
			abort(404);
		}
	})->name('loginAsAdmin');
	
	 Route::get('announcement', 'AnnouncementsController@index')->name('announcement');
     Route::get('announcement/{announcement}', 'AnnouncementsController@display')->name('announcement.display');
    
    Route::get('request/coin/add', 'ListingController@showCoinListingForm')->name('request.coin');
    Route::post('request/coin/add', 'ListingController@saveCoinListingForm')->name('request.coin.post');
    Route::get('request/coin/add/success', 'ListingController@successCoinListing')->name('request.coin.success');

    Route::get('kyc/upload', 'KycController@upload')->name('kyc.upload.index');
    Route::post('kyc/upload', 'KycController@submitKyc')->name('kyc.upload.store');

    Route::get('account', 'AccountController@index')->name('account.index');
    Route::get('account/switch', 'AccountController@toggleSwitch')->name('account.switch');
    Route::get('account/deposit/{coin}', 'AccountController@getDeposit')->name('account.coin.deposit');
    Route::get('account/withdraw/{coin}', 'AccountController@getWithdraw')->name('account.coin.withdraw');
    Route::get('account/history', 'AccountController@getHistory')->name('account.history');

    Route::post('account/deposit/{coin}', 'AccountController@makeDeposit')->name('user.deposit.coin.make');
    Route::post('account/withdraw/{coin}', 'AccountController@makeWithdraw')->name('user.withdraw.coin.make');

    //Route::post('account/saveTransactionHash', 'DochTransactionController@saveTransactionHash')->name('DochTransaction.saveTransactionHash');
    

    Route::get('order/open', 'OrderController@getOpenOrder')->name('order.open');
    Route::get('order/history', 'OrderController@getHistory')->name('order.history');
    Route::post('order/cancel', 'OrderController@cancelOrder')->name('order.cancel');

    Route::get('profile', 'ProfileController@profile')->name('profile');
	Route::post('profile', 'ProfileController@saveProfile')->name('profile.save');
	Route::post('profile/image', 'ProfileController@uploadProfileImage')->name('profile.image.save');
	Route::post('profile/change-password','ProfileController@changePassword')->name('profile.change-password');

    Route::get('security/two-factor','SecurityController@security_2fa')->name('security.2fa');
    Route::post('security/two-factor','SecurityController@security_2fa_post')->name('security.fapost');
	
    Route::get('security/two-factor/verify', 'SecurityController@getTwoFaVerification')->name('security.2fa.get');
    Route::post('security/two-factor/verify', 'SecurityController@postTwoFaVerification')->name('security.2fa.post');
	
    Route::get('security/email/verify', 'SecurityController@getEmailVerification')->name('security.email.get');
    Route::post('security/email/verify', 'SecurityController@postEmailVerification')->name('security.email.post');

	Route::get('referral-code', 'ReferralController@index')->name('profile.referral-code');
    Route::post('referral-code', 'ReferralController@sendMail')->name('referral.send');
    
    Route::get('transactions', 'TransactionController@getTransactions')->name('transactions.getTransactions');
    Route::get('transactions/switch', 'TransactionController@toggleSwitch')->name('transactions.switch');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth','admin','twofa']], function(){ 

    Route::get('/', ['as' =>'admin.dashboard', 'uses' => 'Admin\DashboardController@index']);

    //Routes for ICOController

    Route::get('ico', 'Admin\ICOController@index')->name('admin.ico.index');
    Route::get('ico/{ico}/edit', 'Admin\ICOController@edit')->name('admin.ico.edit');
    Route::put('ico/{ico}', 'Admin\ICOController@update')->name('admin.ico.update');
    Route::get('ico/{ico}/display', 'Admin\ICOController@display')->name('admin.ico.display');
    Route::post('ico/{slug}/approve', 'Admin\ICOController@approve')->name('admin.ico.approve');
    Route::post('ico/{slug}/reject', 'Admin\ICOController@reject')->name('admin.ico.reject');

    Route::get('ico/{slug}/mark/{tag}', 'Admin\ICOController@processMark')->name('admin.ico.mark');
    
    // Routes for ApprovalController
    Route::get('approve/withdraw', ['as' =>'admin.approve.withdraw', 'uses' => 'Admin\ApprovalController@withdraw']);
    Route::post('withdraw-approval', ['as' =>'admin.withdraw.approve', 'uses' => 'Admin\ApprovalController@withdrawApprove']);
    Route::post('withdraw-reject', ['as' =>'admin.withdraw.reject', 'uses' => 'Admin\ApprovalController@withdrawReject']);

    Route::get('approve/kyc-document', ['as' =>'admin.approve.kyc', 'uses' => 'Admin\ApprovalController@kycDocument']);
    Route::get('approve/kyc-document/{document}/show', ['as' =>'admin.approve.kyc.show', 'uses' => 'Admin\ApprovalController@showKycDocument']);
    Route::post('approve/kyc-document/process', ['as' =>'admin.kyc.process', 'uses' => 'Admin\ApprovalController@processKyc']);
    
    // Routes for User Controller
    Route::get('user', ['as' =>'admin.user.index', 'uses' => 'Admin\UserController@index']);
    Route::get('user/create', ['as' =>'admin.user.create', 'uses' => 'Admin\UserController@create']);
    Route::post('user', ['as' =>'admin.user.store', 'uses' => 'Admin\UserController@store']);
    Route::get('user/{user}', ['as' =>'admin.user.show', 'uses' => 'Admin\UserController@show']);
    Route::get('user/{user}/login', ['as' =>'admin.user.login', 'uses' => 'Admin\UserController@login']);
    Route::get('user/{user}/edit', ['as' =>'admin.user.edit', 'uses' => 'Admin\UserController@edit']);
    Route::put('user/{user}', ['as' =>'admin.user.update', 'uses' => 'Admin\UserController@update']);
    Route::delete('user/{user}', ['as' =>'admin.user.destroy', 'uses' => 'Admin\UserController@destroy']);
    
	####switch
    Route::get('account/switch', ['as' =>'admin.account.switch', 'uses' => 'Admin\AccountController@toggleSwitch']);

    // Routes for Coin Controller
    Route::get('coin', ['as' =>'admin.coin.index', 'uses' => 'Admin\CoinController@index']);

    Route::get('coin/create', ['as' =>'admin.coin.create', 'uses' => 'Admin\CoinController@create']);
    Route::post('coin', ['as' =>'admin.coin.store', 'uses' => 'Admin\CoinController@store']);

    Route::get('coin/request', ['as' =>'admin.coin.request', 'uses' => 'Admin\CoinController@getRequestForList']);
    Route::get('coin/request/{id}', ['as' =>'admin.coin.request.show', 'uses' => 'Admin\CoinController@showCoinRequest']);
    Route::post('coin/request/{id}/approve', ['as' =>'admin.coin.request.approve', 'uses' => 'Admin\CoinController@approveCoin']);
    Route::post('coin/request/{id}/reject', ['as' =>'admin.coin.request.reject', 'uses' => 'Admin\CoinController@rejectCoin']);

    Route::get('coin/transaction', ['as' =>'admin.coin.transaction', 'uses' => 'Admin\CoinController@transaction']);

    Route::put('coin/{coin}', ['as' =>'admin.coin.update', 'uses' => 'Admin\CoinController@update']);
    Route::delete('coin/{coin}', ['as' =>'admin.coin.destroy', 'uses' => 'Admin\CoinController@destroy']);

    Route::get('coin/{coin}/edit', ['as' =>'admin.coin.edit', 'uses' => 'Admin\CoinController@edit']);
    Route::get('coin/{coin}/chanage-status', ['as' =>'admin.coin.changeStatus', 'uses' => 'Admin\CoinController@changeStatus']);
    Route::get('coin/{coin}/chanage-base', ['as' =>'admin.coin.changeBase', 'uses' => 'Admin\CoinController@changeBase']);


    Route::get('doch_withdrawal_management', ['as' =>'admin.dochManagement.addressBalanced', 'uses' => 'Admin\DochManagementController@listsOfTokenAddress']);
    Route::get('doch_withdrawal_management/systemWallet/create/{token}', ['as' =>'admin.dochManagement.createWallet', 'uses' => 'Admin\DochManagementController@createNewAddress']);
    Route::post('doch_withdrawal_management/Token-transfer/{token}', ['as' =>'admin.dochManagement.transfer', 'uses' => 'Admin\DochManagementController@transferToken']);


    // Routes for Coin Pair Controller
    Route::get('coin-pair', ['as' =>'admin.coinpair.index', 'uses' => 'Admin\CoinPairController@index']);
    Route::get('coin-pair/create', ['as' =>'admin.coinpair.create', 'uses' => 'Admin\CoinPairController@create']);
    Route::post('coin-pair', ['as' =>'admin.coinpair.store', 'uses' => 'Admin\CoinPairController@store']);
    Route::get('coin-pair/{coinpair}/edit', ['as' =>'admin.coinpair.edit', 'uses' => 'Admin\CoinPairController@edit']);
    Route::put('coin-pair/{coinpair}', ['as' =>'admin.coinpair.update', 'uses' => 'Admin\CoinPairController@update']);
    Route::delete('coin-pair/{coinpair}', ['as' =>'admin.coinpair.destroy', 'uses' => 'Admin\CoinPairController@destroy']);
    Route::get('coin-pair/{coinpair}/chanage-status', ['as' =>'admin.coinpair.changeStatus', 'uses' => 'Admin\CoinPairController@changeStatus']);

    // Routes for User Account management
    Route::get('accounts', ['as' =>'admin.account.index', 'uses' => 'Admin\AccountController@index']);
    Route::get('accounts/{accounts}/show', ['as' =>'admin.account.show', 'uses' => 'Admin\AccountController@show']);
	Route::get('accounts/{accounts}/credit', ['as' =>'admin.account.credit.get', 'uses' => 'Admin\AccountController@showCreditForm']);
	Route::post('accounts/{accounts}/credit', ['as' =>'admin.account.credit.post', 'uses' => 'Admin\AccountController@creditAmount']);
	Route::get('accounts/{accounts}/debit', ['as' =>'admin.account.debit.get', 'uses' => 'Admin\AccountController@showDebitForm']);
	Route::post('accounts/{accounts}/debit', ['as' =>'admin.account.debit.post', 'uses' => 'Admin\AccountController@debitAmount']);

    // Route for Trade controller
    Route::get('trades', ['as' =>'admin.trade.index', 'uses' => 'Admin\TradeController@index']);
    
    Route::get('trades/{trade}/explore', ['as' =>'admin.trade.explore', 'uses' => 'Admin\TradeController@exploreTrade']);

    Route::get('trades/{trade}/cancel', ['as' =>'admin.trade.cancel', 'uses' => 'Admin\TradeController@cancelTrade']);
    Route::get('trades/{trade}/close', ['as' =>'admin.trade.close', 'uses' => 'Admin\TradeController@closeTrade']);
    
    Route::post('trades/{trade}/partial', ['as' =>'admin.trade.partial', 'uses' => 'Admin\TradeController@partialClose']);

    // Routes for Setting controller
    Route::get('setting/coins', ['as' =>'admin.setting.coins.get', 'uses' => 'Admin\SettingController@getCoinSetting']);
    Route::post('setting/coins', ['as' =>'admin.setting.coins.post', 'uses' => 'Admin\SettingController@setCoinSetting']);
    Route::get('setting/coins/{coin}', ['as' =>'admin.setting.coins.display', 'uses' => 'Admin\SettingController@displayCoinSetting']);

    Route::get('setting/commission', ['as' =>'admin.setting.commission.get', 'uses' => 'Admin\SettingController@getCommissionSetting']);
    Route::post('setting/commission', ['as' =>'admin.setting.commission.post', 'uses' => 'Admin\SettingController@setCommissionSetting']);
    Route::post('setting/referral', ['as' =>'admin.setting.referral.post', 'uses' => 'Admin\SettingController@setReferralSetting']);

    Route::get('news-and-announcement', ['as' =>'admin.news.index', 'uses' => 'Admin\NewsController@index']);
    Route::get('news-and-announcement/create', ['as' =>'admin.news.create', 'uses' => 'Admin\NewsController@create']);
    Route::post('news-and-announcement', ['as' =>'admin.news.store', 'uses' => 'Admin\NewsController@store']);
    Route::post('news-and-announcement/delete', ['as' =>'admin.news.delete', 'uses' => 'Admin\NewsController@news_delete']);

    Route::get('language', ['as' => 'admin.language.index', 'uses' => 'Admin\LanguageController@index'])->name('language');
    Route::post('language', ['as' => 'admin.language.store', 'uses' => 'Admin\LanguageController@getLanguageKey'])->name('managelanguage');

    Route::post('managelanguage','Admin\LanguageController@setLanguageKey')->name('changelanguage');

    //Routes for Report controller
    Route::get('report/transaction', ['as' =>'admin.report.transaction', 'uses' => 'Admin\ReportController@transaction']);
    Route::get('report/trade-summary', ['as' =>'admin.report.tsummary', 'uses' => 'Admin\ReportController@getTradeSummary']);
    Route::get('report/payback', ['as' =>'admin.report.payback', 'uses' => 'Admin\ReportController@getPaybackSummary']);
});
