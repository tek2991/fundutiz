<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\FinancialYear;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FinancialYearResource;
use Inertia\Inertia;

class FinancialYearController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $financialYears = FinancialYearResource::collection(FinancialYear::orderBy('is_active', 'desc')->orderBy('updated_at', 'desc')->paginate());
        return Inertia::render('Admin/FinancialYears/Index', compact('financialYears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/FinancialYears/Create');
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
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $financialYear = FinancialYear::create([
            'name' => $request->name,
        ]);

        if ($request->is_active === true) {
            $financialYear->activate();
        }

        return redirect()->route('admin.financial_year.index')->banner("New financial year created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinancialYear  $financialYear
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialYear $financialYear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FinancialYear  $financialYear
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialYear $financialYear)
    {
        $currentFinancialYear = new FinancialYearResource(FinancialYear::where('is_active', true)->first());
        $financialYear = new FinancialYearResource($financialYear);

        return Inertia::render('Admin/FinancialYears/Edit', compact('financialYear', 'currentFinancialYear'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinancialYear  $financialYear
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialYear $financialYear)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $financialYear->update([
            'name' => $request->name,
        ]);

        if ($request->is_active === true) {
            $financialYear->activate();
        } else {
            $financialYear->deactivate();
        }

        return redirect()->route('admin.financial_year.index')->banner("Financial year updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinancialYear  $financialYear
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialYear $financialYear)
    {
        //
    }
}
