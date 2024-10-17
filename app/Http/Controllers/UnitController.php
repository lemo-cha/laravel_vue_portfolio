<?php

namespace App\Http\Controllers;

//use App\Http\Requests\StoreUnitRequest;
//use App\Http\Requests\UpdateUnitRequest;
use App\Http\Requests\UnitRequest;
use App\Models\Unit;
use Inertia\Inertia;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $units = Unit::select('id','custom_id','name')->get();
        return Inertia::render('Admin/Units/Index',[
            'units' => $units,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //unnecessary
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UnitRequest $request)
    {
        $validatedData = $request->validated();

        Unit::create($validatedData);

        return to_route('units.index')
        ->with([
            'message' => '登録しました'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //unnecessary
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //unnecessary
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UnitRequest $request, Unit $unit)
    {
        $validatedData = $request->validated();
        $unit->update($validatedData);

        return to_route('units.index')
        ->with([
            'message' => '編集しました',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        
        return to_route('units.index')
        ->with([
            'message' => '削除しました',
        ]);
    }
}
