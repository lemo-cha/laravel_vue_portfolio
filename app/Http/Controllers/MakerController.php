<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreMakerRequest;
// use App\Http\Requests\UpdateMakerRequest;

use App\Enums\CompanyType;
use App\Http\Requests\MakerRequest;
use App\Models\Maker;
use App\Services\MakerService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MakerController extends Controller
{
    protected $makerService;

    public function __construct(MakerService $makerService)
    {
        $this->makerService = $makerService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $makers = $this->makerService->getSortedMakers();
        $companyTypes = CompanyType::getLabelList();

        return Inertia::render('Admin/Makers/Index',[
            'makers' => $makers,
            'company_types' => $companyTypes,
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
    public function store(MakerRequest $request)
    {

        $validatedData = $request->validated();

        Maker::Create($validatedData);

        return to_route('makers.index')
        ->with([
            'message' => '登録しました',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Maker $maker)
    {
        //unnecessary
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maker $maker)
    {
        //unnecessary
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MakerRequest $request, Maker $maker)
    {
        $validatedData = $request->validated();
        $maker->update($validatedData);

        return to_route('makers.index')
        ->with([
            'message' => '編集しました',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maker $maker)
    {
        $maker->delete();

        return to_route('makers.index')
        ->with([
            'message' => '削除しました',
        ]);
    }

    public function search(Request $request)
    {
        try{
            $query = $request->get('q');
            $makers = Maker::where('custom_id','LIKE',"%$query%")
                        ->orWhere('name','LIKE',"%$query%")
                        ->orWhere('brand','LIKE',"%$query%")
                        ->select('id','custom_id','company_type','name','brand')
                        ->get()
                        ->map(function($maker){
                            return [
                                'id' => $maker->id,
                                'custom_id' => $maker->custom_id,
                                'name' => CompanyType::getAbbrName($maker->company_type,$maker->name),
                                'brand' => $maker->brand,
                                ];
                            });
                return response()->json($makers);
            }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()],500);
        }
    }
}
