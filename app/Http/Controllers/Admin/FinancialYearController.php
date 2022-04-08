<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\FinancialYear;
use App\Http\Controllers\Controller;
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
        $financialYears = FinancialYear::paginate();
        return Inertia::render('Admin/FinancialYears/Show', compact('financialYears'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
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
