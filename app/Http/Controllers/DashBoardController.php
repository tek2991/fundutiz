<?php

namespace App\Http\Controllers;

use App\Models\FinancialYear;
use App\Models\Fund;
use App\Models\Team;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashBoardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $financialYear = FinancialYear::current();
        $team = $user->currentTeam;
        $funds = $team->funds;

        $pieChartData = (object) [];
        foreach ($funds as $fund) {
            $data = (object) [];
            $data->name = $fund->name;
            $data->data = $this->getFundData($fund, $team, $financialYear);
            $pieChartData->{$fund->name} = $data;
        }

        return Inertia::render('Dashboard', compact('pieChartData'));
    }


    public function getFundData(Fund $fund, Team $team, FinancialYear $financialYear)
    {
        $total_allocatiions = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'allocation')->sum('amount_in_cents') / 100;

        $total_utilixation_incured = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'utilization')->where('status', 'incured')->sum('amount_in_cents') / 100;

        $total_utilization_proposed = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'utilization')->where('status', 'proposed')->sum('amount_in_cents') / 100;

        $fund_balance = $total_allocatiions - $total_utilixation_incured - $total_utilization_proposed;

        return (object)[
            'labels' => [
                'Utilization Incured',
                'Utilization Proposed',
                'Fund Balance',
            ],
            'backgroundColors' => [
                'coral',
                'cornflowerblue',
                'teal',
            ],
            'data' => [
                $total_utilixation_incured,
                $total_utilization_proposed,
                $fund_balance,
            ],
        ];
    }
}
