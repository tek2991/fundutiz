<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Sanctioner;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FinancialYear;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FundResource;
use App\Http\Resources\v1\SanctionerResource;
use App\Http\Resources\v1\TransactionResource;
use Exception;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transactions = TransactionResource::collection(Transaction::orderBy('updated_at', 'desc')->paginate());
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

        $request->validate([
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

        $additional_fields = [
            'team_id' => auth()->user()->currentTeam->id,
            'user_id' => auth()->user()->id,
            'financial_year_id' => FinancialYear::current()->id,
        ];

        try {
            Transaction::create(array_merge($request->all(), $additional_fields));
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
        //
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
        //
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
