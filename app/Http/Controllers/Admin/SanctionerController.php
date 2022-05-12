<?php

namespace App\Http\Controllers\Admin;

use Inertia\Inertia;
use App\Models\Sanctioner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\v1\SanctionerResource;

class SanctionerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Sanctioner::class);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sanctioners= SanctionerResource::collection(Sanctioner::orderBy('updated_at', 'desc')->paginate());
        return Inertia::render('Admin/Sanctioners/Index', compact('sanctioners'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('Admin/Sanctioners/Create');
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
        ]);

        Sanctioner::create([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.sanctioner.index')->banner("New sanctioning authority created successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sanctioner  $sanctioner
     * @return \Illuminate\Http\Response
     */
    public function show(Sanctioner $sanctioner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sanctioner  $sanctioner
     * @return \Illuminate\Http\Response
     */
    public function edit(Sanctioner $sanctioner)
    {
        $sanctioner = new SanctionerResource($sanctioner);
        return Inertia::render('Admin/Sanctioners/Edit', compact('sanctioner'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sanctioner  $sanctioner
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sanctioner $sanctioner)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);

        $sanctioner->update([
            'name' => $request->name,
        ]);

        return redirect()->route('admin.sanctioner.index')->banner("Sanctioning authority updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sanctioner  $sanctioner
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sanctioner $sanctioner)
    {
        //
    }
}
