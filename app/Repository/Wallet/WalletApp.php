<?php
namespace App\Repository\Wallet;
use PhanAn\Remote\Remote;



class WalletApp
{
    private $conn;

    const LOCATION = './bitnitron/src/bitnitrond ';

    public function __construct()
    {
        //$this->conn = new Remote('bitnitron');
    }


    public function isValidAddress($address)
    {
        $return = $this->conn->exec(self::LOCATION.'validateaddress '.$address);
        $data = json_decode($return);
        return $data->isvalid;
    }

    public function getNewAddress()
    {
        return $this->conn->exec(self::LOCATION.'getnewaddress');
    }

    public function sendToAddress($coinAddress,$amount)
    {
        $return  = $this->conn->exec(self::LOCATION.' sendtoaddress '.$coinAddress.' '.$amount);
        if (strpos($return, 'message') == false) {
            return ['hash' => $return, 'message' => 'success'];
        }else{
            //$msg =  str_replace("error:","",$return);
            //$jsonDcode = json_decode($msg, true);
            return ['hash' => null, 'message' => 'We are processing many requests at the same time. Please try after sometimes.'];//$jsonDcode['message']];
        }
    }

    public function listReceivedByAddress()
    {
        //~ $return = $this->ssh->exec(self::LOCATION.'listreceivedbyaddress');
        $return = $this->conn->exec(self::LOCATION.'listreceivedbyaddress');
        return json_decode($return,true);
    }

    public function getTransaction($txn) {

        $return = $this->conn->exec(self::LOCATION.'gettransaction '.$txn);
        return json_decode($return,true);
    }

    public function getBalance() {
        $return = $this->conn->exec(self::LOCATION.'getbalance');
        return json_decode($return,true);
    }

    public function listTransactions($account = '*', $limit = 100000, $offset = 0) {

        $commandString = self::LOCATION.'listtransactions "'.$account.'" '.$limit.' '.$offset;
        $return = $this->conn->exec($commandString);
        return json_decode($return,true);
    }
}
