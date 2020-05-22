<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SocketTrigger extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socket:trigger';

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
	 
	private $_Socket = null;
	
    public function __construct()
    {
        parent::__construct();		
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
	 
	public function sendData($data) {
        fwrite($this->_Socket, "\x00" . $data . "\xff") or die('Error:' . $errno . ':' . $errstr);
        $wsData = fread($this->_Socket, 2000);
        $retData = trim($wsData, "\x00\xff");
        return $retData;
    }

    private function connect($host, $port) {
        $key1 = $this->generateRandomString(32);
        $key2 = $this->generateRandomString(32);
        $key3 = $this->generateRandomString(8, false, true);
		
		$header = "GET /?token={".csrf_token()."} HTTP/1.1\r\n";
        $header.= "Upgrade: WebSocket\r\n";
        $header.= "Connection: Upgrade\r\n";
        $header.= "Host: " . $host . ":" . $port . "\r\n";
        $header.= "Origin: https://app.hotbtc.exchange\r\n";
        $header.= "Sec-WebSocket-Key1: " . $key1 . "\r\n";
        $header.= "Sec-WebSocket-Key2: " . $key2 . "\r\n";
        $header.= "\r\n";
        $header.= $key3;

        $this->_Socket = fsockopen($host, $port, $errno, $errstr, 2);
        fwrite($this->_Socket, $header) or die('Error: ' . $errno . ':' . $errstr);
        $response = fread($this->_Socket, 2000);
        return true;
    }

    private function disconnect() {
        fclose($this->_Socket);
    }

    private function generateRandomString($length = 10, $addSpaces = true, $addNumbers = true) {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!"§$%&/()=[]{}';
        $useChars = array();
        // select some random chars:    
        for ($i = 0; $i < $length; $i++) {
            $useChars[] = $characters[mt_rand(0, strlen($characters) - 1)];
        }
        // add spaces and numbers:
        if ($addSpaces === true) {
            array_push($useChars, ' ', ' ', ' ', ' ', ' ', ' ');
        }
        if ($addNumbers === true) {
            array_push($useChars, rand(0, 9), rand(0, 9), rand(0, 9));
        }
        shuffle($useChars);
        $randomString = trim(implode('', $useChars));
        $randomString = substr($randomString, 0, $length);
        return $randomString;
    }
	
    public function handle()
    {
		$message = json_encode(["channel" => 1230,"currencyPair"=>"BTC_ETH","params"=> null]);
		
		$this->connect('localhost', 8096);
		$this->sendData($message);
		$this->disconnect();
		
		dd('done');
    }
}
