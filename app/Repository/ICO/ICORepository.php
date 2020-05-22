<?php

namespace App\Repository\ICO;


use App\Ico;

class ICORepository
{
    private $ico;

    public function __construct(Ico $ico)
    {
        $this->ico = $ico;
    }

    public function __call($method, $args)
    {
        return call_user_func_array([$this->ico, $method], $args);
    }
}