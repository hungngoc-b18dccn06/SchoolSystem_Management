<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CategoryService
{
    protected Category $categoryModel;

    public function __construct(Category $categoryModel)
    {
        $this->categoryModel = $categoryModel;
    }


    public function getAllCategories($data)
    {
        return $this->categoryModel->get();
    }

    public function update($data)
    {
        DB::beginTransaction();
        $deletedIds = [];
        try {
            foreach ($data as $category) {
                if (isset($category['id'])) {
                    $existedCategory = $this->categoryModel->where('id', $category['id'])->first();
                    if ($existedCategory) {
                        array_push($deletedIds, $category['id']);
                        $existedCategory->update($category);
                    }
                } else {
                    $newCategory = $this->categoryModel->create($category);
                    array_push($deletedIds, $newCategory->id);
                }
            }
            $this->categoryModel->whereNotIn('id', $deletedIds)->delete();
            DB::commit();

            return [
                'status' => true
            ];
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            DB::rollBack();

            return [
                'status' => false
            ];
        }
    }

    public function getById($id)
    {
        return $this->categoryModel->find($id);
    }
}
