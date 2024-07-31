<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class CategoryController extends Controller
{private Category $categoryModel;
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService, Category $categoryModel)
    {
        $this->categoryService = $categoryService;
        $this->categoryModel = $categoryModel;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->categoryModel::paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
        $category = $this->categoryService->create(
            $request->validated([
                'rating'=>'nullable|integer|min:1|max:5',
                'price'=>'nullable|numeric|min:0',
                'place'=>'nullable|integer|min:1|max:255',
            ]),
            $this->categoryModel,
        );
        return response($category);
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $category = $this->categoryService->getById($id, $this->categoryModel);
        if (!$category) {
            return response([
                "message" => "Not Found",
            ], 404);
        }
        return response($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, int $id)
    {
        $category = $this->categoryService->getById($id, $this->categoryModel);
        if (!$category) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->categoryService->edit(
            $category,
            $request->validated(),
        );
        return response($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $category = $this->categoryService->getById($id, $this->categoryModel);
        if (!$category) {
            return response([
                "message" => "Not Found",
            ], 404);
        }

        $this->categoryService->delete(
            $category,
        );
        return response([
            "message" => "success",
        ]);
    }
    public function filterByPriceRange(Request $request )
    {
        $validated = $request->validate([
            'min_price' => 'required|numeric|min:0',
            'max_price' =>'required|numeric|min:0',
        ]);
         $categories = $this->categoryService->filterByPriceRange($validated['min_price'], $validated['max_price']);

        return response()->json($categories);
    }
}
