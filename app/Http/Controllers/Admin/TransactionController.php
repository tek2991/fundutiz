<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Fund;
use Inertia\Inertia;
use App\Models\Sanctioner;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FinancialYear;
use App\Http\Controllers\Controller;
use App\Actions\Fundutiz\FundBalance;
use App\Http\Resources\v1\FundResource;
use App\Http\Resources\v1\SanctionerResource;
use App\Http\Resources\v1\TransactionResource;

class TransactionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Transaction::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $current_team_id = auth()->user()->currentTeam->id;
        $transactions = TransactionResource::collection(Transaction::where('team_id', $current_team_id)->orderBy('updated_at', 'desc')->paginate());
        return Inertia::render('Admin/Transactions/Index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $current_team = auth()->user()->currentTeam;
        $funds = FundResource::collection($current_team->funds);
        $sanctioners = SanctionerResource::collection(Sanctioner::all());
        return Inertia::render('Admin/Transactions/Create', compact('funds', 'sanctioners'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'fund_id' => ['required', 'integer'],
            'type' => ['nullable', 'in:allocation,utilization'],
            'status' => ['nullable', 'in:incured,proposed'],
            'sanctioned_at' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'item' => ['nullable', 'string', 'max:2550'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'file_number' => ['required', 'string', 'max:255'],
            'is_gem' => ['nullable', 'boolean'],
            'gem_non_availability' => ['nullable', 'boolean'],
            'gem_non_availability_remark' => ['nullable', 'string', 'max:255'],
            'non_gem_remark' => ['nullable', 'string', 'max:255'],
            'sanctioner_id' => ['nullable', 'exists:sanctioners,id'],
        ]);

        $fund = Fund::findOrFail($request->fund_id);
        $current_team = auth()->user()->currentTeam;
        $financialYear = FinancialYear::current();
        $current_balance = FundBalance::current($fund, $current_team, $financialYear);

        if ($request->type == 'utilization') {
            if ($current_balance - $request->amount < 0) {
                return redirect()->back()->dangerBanner('Utilization amount cannot be greater than fund balance!');
            }
        }

        $additional_fields = [
            'team_id' => $current_team->id,
            'user_id' => auth()->user()->id,
            'financial_year_id' => $financialYear->id,
        ];

        try {
            Transaction::create(array_merge($validated, $additional_fields));
            return redirect()->route('admin.transaction.index')->banner("Transaction created successfully.");
        } catch (Exception $e) {
            return redirect()->back()->dangerBanner("Something went wrong: " . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function show(Transaction $transaction)
    {
        $transaction = new TransactionResource($transaction);
        $current_team = auth()->user()->currentTeam;
        $funds = FundResource::collection($current_team->funds);
        $sanctioners = SanctionerResource::collection(Sanctioner::all());
        return Inertia::render('Admin/Transactions/Show', compact('funds', 'sanctioners', 'transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $transaction = new TransactionResource($transaction);
        $current_team = auth()->user()->currentTeam;
        $funds = FundResource::collection($current_team->funds);
        $sanctioners = SanctionerResource::collection(Sanctioner::all());
        return Inertia::render('Admin/Transactions/Edit', compact('funds', 'sanctioners', 'transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated_data = $request->validate([
            'fund_id' => ['required', 'integer'],
            'type' => ['nullable', 'in:allocation,utilization'],
            'status' => ['nullable', 'in:incured,proposed'],
            'sanctioned_at' => ['required', 'date'],
            'amount' => ['required', 'numeric'],
            'item' => ['nullable', 'string', 'max:2550'],
            'vendor_name' => ['nullable', 'string', 'max:255'],
            'file_number' => ['required', 'string', 'max:255'],
            'is_gem' => ['nullable', 'boolean'],
            'gem_non_availability' => ['nullable', 'boolean'],
            'gem_non_availability_remark' => ['nullable', 'string', 'max:255'],
            'non_gem_remark' => ['nullable', 'string', 'max:255'],
            'sanctioner_id' => ['nullable', 'exists:sanctioners,id'],
        ]);

        $fund = Fund::findOrFail($request->fund_id);
        $current_team = auth()->user()->currentTeam;
        $financialYear = FinancialYear::current();
        $current_balance = FundBalance::current($fund, $current_team, $financialYear);

        if ($request->type == 'utilization') {
            if ($current_balance - $request->amount < 0) {
                return redirect()->back()->dangerBanner('Utilization amount cannot be greater than fund balance!');
            }
        }

        $additional_fields = [
            'user_id' => auth()->user()->id,
        ];

        try {
            $transaction->update(array_merge($validated_data, $additional_fields));
            return redirect()->route('admin.transaction.index')->banner("Transaction updated successfully.");
        } catch (Exception $e) {
            return redirect()->back()->dangerBanner("Something went wrong: " . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
