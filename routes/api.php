<?php

use Illuminate\Http\Request;
use App\PriceQuote;
use Laravel\Passport\Passport;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/layout', function (Request $request) {
     return $request->user();
});

Route::get('/price/quotes', function () {
    return ['status'=>1,'image_path'=>url('coin/32x32/'),'data'=>PriceQuote::selectRaw('symbol,price')->where('status',1)->get()];
});

Passport::routes();

Route::post('/register', ['as' => 'user.register', 'uses' => 'API\AuthController@register']);
Route::post('/login', ['as' => 'user.login', 'uses' => 'API\AuthController@login']);
Route::group([
    'middleware' => 'auth:api'
  ], function() {

      Route::get('logout', 'API\AuthController@logout');
      Route::get('user', 'API\AuthController@user');
      
      Route::get('pairTricker', ['as' => 'pairTricker', 'uses' => 'API\ExchangeController@pairTricker']);
      Route::get('PrivateInfo', ['as' => 'PrivateInfo', 'uses' => 'API\ExchangeController@PrivateInfo']);

      Route::get('profile', ['as' => 'profile', 'uses' => 'API\ProfileController@profile']);

      Route::get('account',['as' => 'wallets', 'uses' =>'API\AccountController@index']); 
      Route::get('account/deposit/{coin}', ['as' => 'account.deposit', 'uses' =>'API\AccountController@getDeposit']);
  });

  Route::get('{conn}/marketTreicker', ['as' => 'marketTreicker', 'uses' => 'API\ExchangeController@returnTrickar']);
  
Route::get('{conn}/common/{pair}',function($conn,$pair){

   
        $return = [];
        $trade = new \App\Trade;
        $trade->setConnection($conn);
        $data = $trade->whereHas('coinPair', function($q) use ($pair) {
            $q->where('pair_name', $pair);
        })->onLimit()->ongoing()->groupBy('price','type')
            ->select(DB::raw('type, price, sum(volume) as amount'))->get();
		
        if($data){
            foreach($data as $row){
                if($row->type=='buy') {
                    $return['bids'][(string) $row->price] = [$row->price, floatval($row->amount)];
                }

                if($row->type=='sell') {
                    $return['asks'][(string) $row->price] = [$row->price, floatval($row->amount)];
                }
            }

            if(isset($return['asks']))
                sort($return['asks']);

            if(isset($return['bids']))
                rsort($return['bids']);
        }

        return $return;
   
});