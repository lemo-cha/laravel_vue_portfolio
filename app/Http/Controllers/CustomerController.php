<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreCustomerRequest;
// use App\Http\Requests\UpdateCustomerRequest;

use App\Enums\CompanyType;
use App\Helpers\FormatHelper;
use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Inertia\Inertia;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::select('id', 'custom_id', 'company_type', 'name', 'kana', 'is_active')
        ->orderByRaw("kana COLLATE utf8mb4_unicode_ci ASC")->paginate(5);

        $formattedCustomers = $customers->map(function($customer){
            return [
                'id' => $customer->id,
                'custom_id' => $customer->custom_id,
                'name' => CompanyType::getFullName($customer->company_type,$customer->name),
                'is_active' => FormatHelper::formatActive($customer->is_active),
            ];
        })->values();

        $customers->setCollection($formattedCustomers);
        
        return Inertia::render('Admin/Customers/Index',[
            'customers' => $customers,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Admin/Customers/Create',[
            'company_types' => CompanyType::getLabelList(),
            'closing_types' => FormatHelper::getClosingLabelList(),
            'is_actives' => FormatHelper::getActiveLabelList(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {
        $validatedData = $request->validated();

        Customer::Create($validatedData);

        return to_route('customers.create')
        ->with([
            'message' => '登録しました',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        $customerData = [
            'id' => $customer->id,
            'custom_id' => $customer->custom_id,
            'full_name' => CompanyType::getFullName($customer->company_type,$customer->name),
            'kana' => $customer->kana,
            'tel' => FormatHelper::formatTelNumber($customer->tel),
            'address' => FormatHelper::formatZipCode($customer->zip).' '.$customer->address,
            'billing_address' => ($customer->billing_zip === null && $customer->billing_address === null) ? '住所と同じ' : FormatHelper::formatZipCode($customer->billing_zip).' '.$customer-> billing_address,
            'closing_date' => FormatHelper::formatClosingDate($customer->closing_date),
            'bank_name' => $customer->bank_name,
            'bank_number' => $customer->bank_number,
            'remarks' => $customer->remarks,
            'is_active' => FormatHelper::formatActive($customer->is_active),
            'created_at' => FormatHelper::formatDateYmd($customer->created_at),
            'updated_at' => FormatHelper::formatDateYmd($customer->updated_at),
        ];

        return Inertia::render('Admin/Customers/Show',[
            'customer' => $customerData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        $customer = Customer::find($customer->id,[
            'id','custom_id','company_type','name','kana','tel',
            'zip','address','billing_zip','billing_address','closing_date',
            'bank_name','bank_number','remarks','is_active'
        ]);
        
        // nullでvueに渡るとエラーが出るので''にする
        $customer->billing_zip = $customer->billing_zip ?: '';
        $customer->billing_address = $customer->billing_address ?: '';
        $customer->remarks = $customer->remarks ?: '';

        return Inertia::render('Admin/Customers/Edit',[
            'customer' => $customer,
            'company_types' => CompanyType::getLabelList(),
            'closing_types' => FormatHelper::getClosingLabelList(),
            'is_actives' => FormatHelper::getActiveLabelList(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CustomerRequest $request, Customer $customer)
    {
        $validatedData = $request->validated();
        $customer->update($validatedData);

        return to_route('customers.show',['customer' =>$customer->id])
        ->with([
            'message' => '編集しました',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return to_route('customers.index')
        ->with([
            'message' => '削除しました',
        ]);
    }
}
