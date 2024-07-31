<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

class CategoryService
{

    public function create(array $data, Category $categoryModel): Category
    {
        return $categoryModel::create($this->data($data));
    }


    public function edit(Category $category, array $data): void
    {
        $category->update($this->data($data));
    }


    public function delete(Category $category): void
    {
        $category->delete();
    }


    public function getById(int $id, Category $categoryModel)
    {
        return $categoryModel::where('id', $id)->first();
    }

    public function getAll(Category $categoryModel): Collection
    {
        return $categoryModel::all();
    }
    public function filterByPriceRange($minPrice,$maxPrice):Collection
    {
        return Category::whereBetween('price',[$minPrice,$maxPrice])->get();
    }

    public function data($data): array
    {
        return
            [
                'rating' => $data['rating'] ?? null,
                'price' => $data['price'] ?? null,
                'place' => $data['place'] ?? null,
            ];
    }
}
