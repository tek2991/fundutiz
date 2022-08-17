<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Fund;
use Inertia\Inertia;
use App\Models\Sanctioner;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\FinancialYear;
use App\Exports\TransactionsExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Actions\Fundutiz\FundBalance;
use App\Http\Resources\v1\FundResource;
use App\Http\Resources\v1\UserResource;
use App\Http\Resources\v1\SanctionerResource;
use App\Http\Resources\v1\TransactionResource;
use App\Http\Resources\v1\FinancialYearResource;

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
    public function index(Request $request)
    {
        $this->validate($request, [
            'fund_id' => 'nullable|exists:funds,id',
            'user_id' => 'nullable|exists:sanctioners,id',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'financial_year_id' => 'nullable|exists:financial_years,id',
            'sort_by' => 'nullable|in:fund_id,sanctioned_at,amount_in_cents,user_id',
            'sort_direction' => 'nullable|in:asc,desc',
        ]);
        $transactions = Transaction::query();
        if ($request->filled('fund_id')) {
            $transactions->where('fund_id', $request->fund_id);
        }
        if ($request->filled('user_id')) {
            $transactions->where('user_id', $request->user_id);
        }
        if ($request->filled('from')) {
            $transactions->where('sanctioned_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $transactions->where('sanctioned_at', '<=', $request->to);
        }

        $current_team = auth()->user()->currentTeam;
        $transactions = $transactions->where('team_id', $current_team->id)->where('financial_year_id', $request->financial_year_id ?? FinancialYear::current()->id);
        $transactions = $transactions->orderBy($request->sort_by ?? 'sanctioned_at', $request->sort_direction ?? 'desc')->paginate();

        $transactions = TransactionResource::collection($transactions);
        $funds = FundResource::collection(Fund::all());
        $users = UserResource::collection($current_team->users);
        $financialYears = FinancialYearResource::collection(FinancialYear::all());
        return Inertia::render('Admin/Transactions/Index', compact('transactions', 'funds', 'users', 'financialYears', 'request'));
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
            'oa_name' => ['nullable', 'string', 'max:255'],
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
            'oa_name' => ['nullable', 'string', 'max:255'],
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


    public function downloadReport(Request $request){
        $this->validate($request, [
            'fund_id' => 'nullable|exists:funds,id',
            'user_id' => 'nullable|exists:sanctioners,id',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'financial_year_id' => 'nullable|exists:financial_years,id',
            'sort_by' => 'nullable|in:fund_id,sanctioned_at,amount_in_cents,user_id',
            'sort_direction' => 'nullable|in:asc,desc',
        ]);
        $transactions = Transaction::query();
        if ($request->filled('fund_id')) {
            $transactions->where('fund_id', $request->fund_id);
        }
        if ($request->filled('user_id')) {
            $transactions->where('user_id', $request->user_id);
        }
        if ($request->filled('from')) {
            $transactions->where('sanctioned_at', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $transactions->where('sanctioned_at', '<=', $request->to);
        }

        $current_team = auth()->user()->currentTeam;
        $transactions = $transactions->where('team_id', $current_team->id)->where('financial_year_id', $request->financial_year_id ?? FinancialYear::current()->id);
        $transactions = $transactions->orderBy($request->sort_by ?? 'sanctioned_at', $request->sort_direction ?? 'desc')->get();

        $export = new TransactionsExport($transactions);

        return Excel::download($export, 'transactions.xlsx');
    }
}
