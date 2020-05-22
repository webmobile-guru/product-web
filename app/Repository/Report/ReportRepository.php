<?php
/**
 * Created by PhpStorm.
 * User: its-04
 * Date: 11/3/19
 * Time: 1:27 PM
 */

namespace App\Repository\Report;

use Illuminate\Support\Facades\DB;

class ReportRepository
{
    public function getTradeSummary(array $search)
    {
        return DB::select('call sp_get_trade_summary(?,?,?,?)', $search);
    }
}