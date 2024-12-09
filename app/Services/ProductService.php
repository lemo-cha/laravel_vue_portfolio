<?php
namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
    public static function getFilteredProducts(Request $request,$perPage)
    {
        return Product::query()
            ->when($request->category,function($query,$category){
                $query->where('category_id',$category);
            })
            ->when($request->maker,function($query,$maker){
                $query->where('maker_id',$maker);
            })
            ->when($request->searchWord,function($query,$searchWord){
                $query->where(function($subQuery) use ($searchWord){
                    $subQuery->where('name', 'like', "%{$searchWord}%")
                        ->orWhere('size', 'like', "%{$searchWord}%")
                        ->orWhere('product_number', 'like', "%{$searchWord}%")
                        ->orWhere('description', 'like', "%{$searchWord}%")
                        ->orWhere('remarks', 'like', "%{$searchWord}%");
                });
            })
            ->with([
                'category:id,name',
                'maker:id,company_type,name,brand'
            ])
            ->select(
                'id','category_id','maker_id','name','size',
                'product_number','description','image_1','status'
            )
            ->paginate($perPage);
    }
}