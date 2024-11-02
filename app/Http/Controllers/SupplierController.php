<?php

namespace App\Http\Controllers;

use App\Enums\CompanyType;
use App\Helpers\FormatHelper;
// use App\Http\Requests\StoreSupplierRequest;
// use App\Http\Requests\UpdateSupplierRequest;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Inertia\Inertia;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::select('id','custom_id','company_type','name','kana','is_active')
        ->orderByRaw("kana COLLATE utf8mb4_unicode_ci ASC")->paginate(5);

        $formattedSuppliers = $suppliers->map(function($supplier){
            return [
                'id' => $supplier->id,
                'custom_id' => $supplier->custom_id,
                'name' => CompanyType::getFullName($supplier->company_type,$supplier->name),
                'is_active' => FormatHelper::formatActive($supplier->is_active),
            ];
        })->values();

        $suppliers->setCollection($formattedSuppliers);

        return Inertia::render('Admin/Suppliers/Index',[
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Suppliers/Create',[
            'company_types' => CompanyType::getLabelList(),
            'is_actives' => FormatHelper::getActiveLabelList(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SupplierRequest $request)
    {
        $validatedData = $request->validated();

        Supplier::Create($validatedData);

        return to_route('suppliers.create')
        ->with([
            'message' => '登録しました',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        $supplierData = [
            'id' => $supplier->id,
            'custom_id' => $supplier->custom_id,
            'full_name' => CompanyType::getFullName($supplier->company_type,$supplier->name),
            'kana' => $supplier->kana,
            'tel' => FormatHelper::formatTelNumber($supplier->tel),
            'address' => FormatHelper::formatZipCode($supplier->zip).' '.$supplier->address,
            'billing_address' => ($supplier->billing_zip === null && $supplier->billing_address === null) ? '住所と同じ' : FormatHelper::formatZipCode($supplier->billing_zip).' '.$supplier-> billing_address,
            'bank_name' => $supplier->bank_name,
            'bank_number' => $supplier->bank_number,
            'remarks' => $supplier->remarks,
            'is_active' => FormatHelper::formatActive($supplier->is_active),
            'created_at' => FormatHelper::formatDateYmd($supplier->created_at),
            'updated_at' => FormatHelper::formatDateYmd($supplier->updated_at),
        ];

        return Inertia::render('Admin/Suppliers/Show',[
            'supplier' => $supplierData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Supplier $supplier)
    {
        $supplier = Supplier::find($supplier->id,[
            'id','custom_id','company_type','name','kana','tel','zip',
            'address','billing_zip','billing_address','bank_name',
            'bank_number','remarks','is_active'
        ]);

        // nullでvueに渡るとエラーが出るので、''にする
        $supplier->billing_zip = $supplier->billing_zip ?: '';
        $supplier->billing_address = $supplier->billing_address ?: '';
        $supplier->remarks = $supplier->remarks ?: '';

        return Inertia::render('Admin/Suppliers/Edit',[
            'supplier' => $supplier,
            'company_types' => CompanyType::getLabelList(),
            'is_actives' => FormatHelper::getActiveLabelList()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SupplierRequest $request, Supplier $supplier)
    {
        $validatedData = $request->validated();
        $supplier->update($validatedData);

        return to_route('suppliers.show',['supplier' => $supplier->id])
        ->with([
            'message' => '編集しました',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return to_route('suppliers.index')
        ->with([
            'message' => '削除しました',
        ]);
    }
}
