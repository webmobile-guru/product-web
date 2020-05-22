<?php
namespace App\Repository\News;
use App\News;

class AdminNews {

    private $news;
    public $newsList = [];
    public function __construct()
    {
        $this->news = new News;
    }

    public function isNotification(){

        if($this->news->count()){
            return true;
        }

        return false;

    }

    public function news(){

        $all = $this->news->get();
        foreach($all as $k => $a){
            $this->newsList[$k] = ['title'=>$a->heading, 'des'=> $a->content];
        }

        return $this->newsList;

    }

    public static function instance()
     {
         return new AdminNews();
     }

}