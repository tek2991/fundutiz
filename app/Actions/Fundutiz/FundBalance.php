<?php

namespace App\Actions\Fundutiz;

use App\Models\Transaction;


class FundBalance
{
    public static function current($fund, $team, $financialYear)
    {
        $total_allocations = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'allocation')->sum('amount_in_cents') / 100;

        $total_utilization_incured = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'utilization')->where('status', 'incured')->sum('amount_in_cents') / 100;

        $total_utilization_proposed = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'utilization')->where('status', 'proposed')->sum('amount_in_cents') / 100;

        $fund_balance = $total_allocations - $total_utilization_incured - $total_utilization_proposed;

        return $fund_balance;
    }
}
