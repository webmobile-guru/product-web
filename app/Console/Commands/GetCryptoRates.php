<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\PriceQuote;
use App\Coin;

class GetCryptoRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'crypto:rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {	
		$this->cryptoRates();
	}
	
	public function cryptoRates()
    {
		$coins = Coin::select('coin')->where('status',1)->pluck('coin')->toArray();
		$symbols = implode($coins,',');
		
		$url = 'https://pro-api.coinmarketcap.com/v1/cryptocurrency/quotes/latest';
		$parameters = [
		  'symbol' => $symbols
		];

		$headers = [
		  'Accepts: application/json',
		  'X-CMC_PRO_API_KEY: 351373b0-1a19-45a1-8703-571b75292809'
		];
		$qs = http_build_query($parameters); // query string encode the parameters
		$request = "{$url}?{$qs}"; // create the request URL


		$curl = curl_init(); // Get cURL resource
		// Set cURL options
		curl_setopt_array($curl, array(
		  CURLOPT_URL => $request,            // set the request URL
		  CURLOPT_HTTPHEADER => $headers,     // set the headers 
		  CURLOPT_RETURNTRANSFER => 1         // ask for raw response instead of bool
		));

		$response = curl_exec($curl); // Send the request, save the response
		//print_r(json_decode($response)); // print json decoded response
		curl_close($curl); // Close request
		
		$response = json_decode($response,true);
		//dd($response);
		if(isset($response['data'])){
			foreach($response['data'] as $data){
				if(isset($data['symbol']) and isset($data['quote']['USD']['price'])){
					
					PriceQuote::where('symbol',$data['symbol'])->where('type','CRYPTO')->update(['status'=>0]);
					
					PriceQuote::create([
							'symbol'=>$data['symbol'],
							'price'=>$data['quote']['USD']['price'],
							'type'=>'CRYPTO'
					]);
				}
				
			}
		}
	}

}
