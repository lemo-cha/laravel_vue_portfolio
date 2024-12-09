<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreProductRequest;
// use App\Http\Requests\UpdateProductRequest;

use App\Enums\CompanyType;
use App\Enums\ProductStatus;
use App\Helpers\FormatHelper;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Maker;
use App\Models\Product;
use App\Services\DeviceDetectionService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ProductController extends Controller
{

    protected $deviceDetectionService;

    public function __construct(DeviceDetectionService $deviceDetectionService)
    {
        $this->deviceDetectionService = $deviceDetectionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $perPage = $this->deviceDetectionService->getPaginationCountByDeviceType($request,10,20,30);

        $selectedCategory = $request->category ? 
            Category::find($request->category)->only('id','custom_id','name') : '';

        $selectedMaker = $request->maker ?
            Maker::find($request->maker)->only('id','custom_id','company_type','name','brand') : '';
        //selectedMakerにパラメータがある場合更にデータを整形
        if($selectedMaker){
            $selectedMaker['name'] = CompanyType::getAbbrName($selectedMaker['company_type'],$selectedMaker['name']);
        }

        $products = ProductService::getFilteredProducts($request,$perPage);

        $productsData = $products->map(function($product){
            $maker = CompanyType::getAbbrName($product->maker->company_type,$product->maker->name);
            return [
                'id' => $product->id,
                'category' => $product->category->name,
                'maker' => $product->maker->brand ? $maker.' '.$product->maker->brand : $maker,
                'name' => $product->name,
                'size' => $product->size,
                'product_number' => $product->product_number,
                'description' => $product->description,
                'image_1' => Storage::url($product->image_1),
                'status' => ProductStatus::getProductStatus($product->status),
                'status_description' => ProductStatus::getProductStatusDescription($product->status),
            ];
        })->values();

        $products->setCollection($productsData);

        return Inertia::render('Admin/Products/Index',array_filter([
            'category' => $selectedCategory,
            'maker' => $selectedMaker,
            'search_word' => $request->searchWord,
            'products' => $products,
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $statusList = ProductStatus::getLabelList();

        return Inertia::render('Admin/Products/Create',[
            'status_list' => $statusList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $product = new Product();

        foreach(Product::IMAGE_COLUMNS as $column){
            if($request->hasFile($column)){
                $product->storeImagePath($data,$column,$request->file($column));
            }
        }

        $product->fill($data);
        $product->save();

        return to_route('products.create')
        ->with([
            'message' => '登録しました',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = Product::with(
            'category:id,name',
            'maker:id,company_type,name,brand')
            ->select(
                'id','custom_id','category_id','maker_id',
                'name','size','product_number','description',
                'image_1','image_2','image_3','remarks','status')
            ->find($product->id);

        $maker = CompanyType::getFullName($product->maker->company_type,$product->maker->name);

        $productData = [
            'id' => $product->id,
            'custom_id' => $product->custom_id,
            'category' => $product->category->name,
            'maker' => $maker.' '.$product->maker->brand,
            'name' => $product->name,
            'size' => $product->size,
            'product_number' => $product->product_number,
            'description' => $product->description,
            'image_1' => Storage::url($product->image_1),
            'image_2' => FormatHelper::formatNullableImage($product->image_2,'/images/20200501_noimage_1.jpg'), // _1も_2も同じ画像。active判定のため、urlを分ける。
            'image_3' => FormatHelper::formatNullableImage($product->image_3,'/images/20200501_noimage_2.jpg'),
            'remarks' => $product->remarks,
            'status' => ProductStatus::getProductStatus($product->status),
            'status_description' => ProductStatus::getProductStatusDescription($product->status),
        ];

        // dd($productData);
        return Inertia::render('Admin/Products/Show',[
            'product' => $productData,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $productData = Product::with(
            'category:id,custom_id,name',
            'maker:id,custom_id,company_type,name,brand',
            'unit:id,custom_id,name')
        ->select([
            'id','custom_id','category_id','maker_id','unit_id','name',
            'size','product_number','description','image_1',
            'image_2','image_3','remarks','status'
        ])->findOrFail($product->id);

        $productData->maker->name = CompanyType::getAbbrName($productData->maker->company_type,$productData->maker->name);

        $productData->image_url_1 = Storage::url($product->image_1);
        $productData->image_url_2 = FormatHelper::formatNullableImage($product->image_2,'');
        $productData->image_url_3 = FormatHelper::formatNullableImage($product->image_3,'');

        $statusList = ProductStatus::getLabelList();

        return Inertia::render('Admin/Products/Edit',[
            'product' => $productData,
            'product_image_urls' => [
                'image_1' => $productData->image_url_1,
                'image_2' => $productData->image_url_2,
                'image_3' => $productData->image_url_3,
            ],
            'status_list' => $statusList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        foreach(Product::IMAGE_COLUMNS as $column){
            //requestデータがnullかつ既存データがある場合
            if(is_null($data[$column]) && !is_null($product[$column])){
                $product->deleteImagePath($data,$column);
            //requestデータがfileオブジェクトだった場合
            }elseif($data[$column] instanceof UploadedFile){
                //既存データがある場合
                if(!is_null($product[$column])){
                    $product->deleteImagePath($data,$column);
                }
                //既存データが無い場合
                $product->storeImagePath($data,$column,$request->file($column));
            }//requestデータがnullかつ既存データが無い、requestデータがstring型(既存データそのまま)の場合、何もしない
        }

        $product->update($data);

        return to_route('products.show',['product' => $product->id])
        ->with([
            'message' => '編集しました',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // softDeleteなので、画像は残しておく
        // foreach(Product::IMAGE_COLUMNS as $column){
        //     if(!empty($product[$column])){
        //         $product->deleteImagePath($data,$column);
        //     }
        // }
        $product->delete();

        return to_route('products.index')
        ->with([
            'message' => '削除しました',
        ]);
    }
}