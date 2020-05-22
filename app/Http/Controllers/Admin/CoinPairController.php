<?php

namespace App\Http\Controllers\Admin;

use App\Coin;
use App\CoinPair;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests;
use App\Http\Requests\CoinPairRequest;

class CoinPairController extends Controller
{
  protected $coinPair, $redirectPath = '/admin/coin-pair';

  public function __construct(CoinPair $coinPair)
  {
    $this->coinPair = $coinPair;
  }

  public function index()
  {
    $coinPairs = $this->coinPair->paginate(10);
    return view('admin.coin-pair.index', compact('coinPairs'));
  }

  public function create(Coin $coin)
  {
    $base = $coin->base()->active()->pluck('name', 'id');
    $others = $coin->/*notBase()->*/active()->pluck('name', 'id');
    return view('admin.coin-pair.create', compact('base', 'others'));
  }

  public function store(Requests\CoinPairRequest $request)
  {
    $this->coinPair->create([
      'base_coin_id' =>  $request->base_coin,
      'coin_id' => $request->secondary_coin,
      'pair_name' => $request->pair_name,
      'status' => $request->status,      
    ]);

    return json_encode(['status' => true, 'message' => 'Success! Coin Pair created']);   
  }

  public function edit(CoinPair $coinpair, Coin $coin)
  {
    $base = $coin->base()->active()->pluck('name', 'id');
    $others = $coin/*->notBase()*/->active()->pluck('name', 'id');
    return view('admin.coin-pair.edit',compact('coinpair','base', 'others'));
  }

  public function update(Requests\CoinPairRequest $request, CoinPair $coinpair)
  {
    $data= [
      'coin_id' => $request->secondary_coin,
      'base_coin_id' => $request->base_coin,
      'pair_name' => $request->pair_name,
      'status' => $request->status,      
    ]; 
    try {
		$coinpair->update($data); 
	}catch (\Exception $exception) {
	  Log::error('Error from CoinPair controller '.$exception->getMessage());
	  return json_encode(['status' => false, 'message' => 'Error! User creation failed']);
	}
    return json_encode(['status' => true, 'message' => 'Success! Coin Pair updated']);   
  }

  public function changeStatus(CoinPair $coinpair)
  {
    $coinpair->status = $coinpair->status?'0':'1';
    $coinpair->save();  
    return redirect()->back();
  }

  public function destroy(CoinPair $coinpair)
  {
    if($coinpair->delete()) {
      return json_encode(['status' => true, 'message' => 'Success! Coin Pair deleted.']);
    }
    return json_encode(['status' => false, 'message' => 'Error! deleting Coin Pair.']);
  }
}
