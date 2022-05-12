<?php

namespace App\Http\Controllers\Admin;

use App\Models\Fund;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\FundResource;
use App\Rules\TeamObjectRule;

class FundController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Fund::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funds = FundResource::collection(Fund::orderBy('updated_at', 'desc')->paginate());
        return Inertia::render('Admin/Funds/Index', compact('funds'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Funds/Create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Fund::create($request->validate([
            'name' => 'required|string|max:255',
        ]));

        return redirect()->route('admin.fund.index')->banner("Fund created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function show(Fund $fund)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function edit(Fund $fund)
    {
        $fund = new FundResource($fund);
        $assignedTeams = $fund->teams;
        return Inertia::render('Admin/Funds/Edit', compact('fund', 'assignedTeams'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Fund $fund)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'teams' => ['bail', 'nullable', 'array', new TeamObjectRule],
        ]);

        $fund->update([
            'name' => $request->name,
        ]);

        $teams = [];
        if ($request->teams) {
            foreach ($request->teams as $team => $status) {
                $status == true ? $teams[] = $team : null;
            }
        }
        $fund->teams()->sync($teams);

        return redirect()->route('admin.fund.index')->banner("Fund updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Fund  $fund
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fund $fund)
    {
        //
    }
}
