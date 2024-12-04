<?php

namespace App\Http\Controllers;

// use App\Http\Requests\StoreCategoryRequest;
// use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::select('id','custom_id','name')->get();
        return Inertia::render('Admin/Categories/Index',[
            'categories' => $categories,
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
    public function store(CategoryRequest $request)
    {
        $validatedData = $request->validated();

        Category::create($validatedData);

        return to_route('categories.index')
        ->with([
            'message' => '登録しました',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //unnecessary
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //unnecessary
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $validatedData = $request->validated();
        $category->update($validatedData);

        return to_route('categories.index')
        ->with([
            'message' => '編集しました',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return to_route('categories.index')
        ->with([
            'message' => '削除しました',
        ]);
    }

    public function search(Request $request)
    {
        try{
            $query = $request->get('q');
            $categories = Category::where('custom_id','LIKE',"%$query%")
                                ->orWhere('name','LIKE',"%$query%")
                                ->select('id','custom_id','name')
                                ->get();

            return response()->json($categories);
        }catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()],500);
        }
    }
}
