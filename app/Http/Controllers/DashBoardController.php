<?php

namespace App\Http\Controllers;

use App\Models\Fund;
use App\Models\Team;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FinancialYear;
use Illuminate\Support\Facades\DB;

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

        $barChartData = $this->getUserWiseData($team, $financialYear);


        return Inertia::render('Dashboard', compact('pieChartData', 'barChartData'));
    }


    public function getFundData(Fund $fund, Team $team, FinancialYear $financialYear)
    {
        $total_allocations = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'allocation')->sum('amount_in_cents') / 100;

        $total_utilization_incured = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'utilization')->where('status', 'incured')->sum('amount_in_cents') / 100;

        $total_utilization_proposed = Transaction::where('fund_id', $fund->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'utilization')->where('status', 'proposed')->sum('amount_in_cents') / 100;

        $fund_balance = $total_allocations - $total_utilization_incured - $total_utilization_proposed;

        return (object)[
            'labels' => [
                'Incured',
                'Proposed',
                'Balance',
            ],
            'backgroundColors' => [
                'coral',
                'cornflowerblue',
                'teal',
            ],
            'data' => [
                $total_utilization_incured,
                $total_utilization_proposed,
                $fund_balance,
            ],
            'fund_data' => [
                'total_allocations' => $total_allocations,
                'total_utilization_incured' => $total_utilization_incured,
                'total_utilization_proposed' => $total_utilization_proposed,
                'fund_balance' => $fund_balance,
            ]
        ];
    }

    public function getUserWiseData(Team $team, FinancialYear $financialYear)
    {
        $users_in_team = $team->allUsers();
        $labels = [];
        $data = [];
        $backgroundColors = [];
        foreach ($users_in_team as $user) {
            $labels[] = $user->name;
            $backgroundColors[] = '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
            $data[] = $this->getUserData($user, $team, $financialYear);
        }

        return (object)[
            'labels' => $labels,
            'backgroundColors' => $backgroundColors,
            'data' => $data,
            'team' => $team,
        ];
    }

    public function getUserData(User $user, Team $team, FinancialYear $financialYear)
    {
        return Transaction::where('user_id', $user->id)->where('team_id', $team->id)->where('financial_year_id', $financialYear->id)->where('type', 'utilization')->sum('amount_in_cents') / 100;
    }
}
