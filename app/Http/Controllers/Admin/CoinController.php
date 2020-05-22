<?php

namespace App\Http\Controllers\Admin;

use App\Coin;
use App\CoinForList;
use App\CoinPair;
use App\CoinTransaction;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\CoinRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CoinController extends Controller
{

  protected $coin, $redirectPath = '/admin/coin';

  public function __construct(Coin $coin)
  {
    
    $this->coin = $coin;
  }

  public function index()
  {
    //dd($this->coin);
    $coins = $this->coin->paginate(10);
    return view('admin.coin.index', compact('coins'));
  }

  public function create()
  {
    if(request()->ajax()) {
      return view('admin.coin.create');
    }
    return redirect($this->redirectPath);
  }

  public function store(Requests\CoinRequest $request) 
  {
    $this->coin->create([
      'name' => $request->coin_name,    
      'coin' => $request->short_name,
      'withdraw' => $request->withdraw_m,
      'is_base' => $request->base_info,
      'status' => $request->status,
    ]);

    return json_encode(['status' => true, 'message' => 'Success! Coin created']);   
  }

  public function edit(Coin $coin)
  {
    return view('admin.coin.edit', compact('coin'));
  }

  public function update(Requests\CoinRequest $request, Coin $coin)
  {    
    $coin->name = $request->coin_name;
    $coin->coin = $request->short_name;
    $coin->withdraw = $request->withdraw_m;
    $coin->currency_type = $request->coin_type;
    $coin->is_base = $request->base_info;
    $coin->status = $request->status;
    $coin->save();

    return json_encode(['status' => true, 'message' => 'Success! Coin updated']);   
  }

  public function destroy(Coin $coin)
  {
    if($coin->delete()) {
      return json_encode(['status' => true, 'message' => 'Success! Coin deleted.']);
    }
    return json_encode(['status' => false, 'message' => 'Error! deleting coin.']);
  }

  public function changeBase(Coin $coin)
  {  
    $coin->is_base = $coin->is_base?'0':'1';
    $coin->save();  
    return redirect()->back();    
  }

  public function changeStatus(Coin $coin)
  {
    $coin->status = $coin->status?0:1;
    $coin->save();  
    return redirect()->back();
  }

  public function transaction(CoinTransaction $transaction, Coin $coin)
  {
    $query = $transaction->latest();

    $request = request();

    if(strcasecmp($request->get('search'), 'true')==0)
    {
      if($request->input('from_date') && $request->input('to_date')) {

        $dates = [
			Carbon::parse($request->from_date)->toDateTimeString(), 
            Carbon::parse($request->to_date.' 23:59:59')->toDateTimeString()
            
        ];

        $query = $query->whereBetween('coin_transactions.created_at', $dates);

      }

      if($request->input('transaction_id')) {
        $query = $query->where('coin_transactions.reference_no', 'like', '%'.$request->transaction_id.'%');
      }

      if($request->input('address')) {
        $query = $query->where('coin_transactions.coin_address', 'like', '%'.$request->address.'%');
      }

      if($request->input('coin_id')) {
        $query = $query->where('coin_transactions.coin_id', '=', $request->coin_id);
      }

      if($request->input('type')) {
        $query = $query->where('coin_transactions.type', '=', $request->type);
      }
    }

    $transactions = $query->paginate(20)->appends($request->query());

    $coins = $coin->pluck('name', 'id');
    return view('admin.coin.transaction',compact('transactions', 'coins'));
  }

  public function getRequestForList(CoinForList $list)
  {
    $coinsForList = $list->latest()->paginate(10);

    return view('admin.coin.request.index', compact('coinsForList'));
  }

  public function showCoinRequest($request)
  {
    $item = CoinForList::find($request);

    return view('admin.coin.request.show', compact('item'));
  }

  public function approveCoin($coin)
  {
    try {

      $item = CoinForList::find($coin);

      $item->status = 1;

      // make a coin
      $coin = [
          'name' => ucfirst($item->coin_name),
          'coin' => $item->coin_symbol,
          'withdraw' => 'automatic',
          'currency_type' => 'Crypto',
          'is_base' => 0,
          'status' => 1,
      ];
      // now make a pair with btc

      DB::transaction(function() use ($item, $coin){
        $baseCoin = Coin::where('coin', 'BTC')->first();
        $coin = Coin::create($coin);

        CoinPair::create([
            'coin_id' => $coin->id,
            'base_coin_id' => $baseCoin->id,
            'listed_by' => $item->user_id,
            'pair_name' => $baseCoin->coin.'_'.$coin->coin,
            'status' => 1
        ]);

        $item->save();
      });

      flash()->success('Success! Coin has been approved and pair has been listed');

      return json_encode(['staus' => true]);

    } catch (\Exception $exception) {
      Log::error($exception);
      flash()->error('Error! Listing of coin failed');
    }
    return json_encode(['staus' => false]);
  }

  public function rejectCoin($coin)
  {
    try {
      $item = CoinForList::find($coin);

      $item->status = 2;

      $item->save();

      flash()->success('Success! Coin has been rejected from listing');

      return json_encode(['staus' => true]);

    } catch (\Exception $exception){
      flash()->error('Error! Listing of coin failed');
    }

    return json_encode(['staus' => false]);
  }
}
