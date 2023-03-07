<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateCategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    protected CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->authorize('category.index', Auth::user());

        return $this->respondOk([
            'message' => __('messages.ok'),
            'data' => $this->categoryService->getAllCategories($request->all())
        ]);
    }

    public function updateOrCreate(UpdateCategoryRequest $request)
    {
        $this->authorize('category.updateOrCreate', Auth::user());

        $response = $this->categoryService->update($request->data());

        if ($response['status']) {
            return $this->respondOk([
                'message' => __('messages.create_success'),
            ]);
        }

        return $this->respondInternalServerError([
            'message' => __('messages.server_error')
        ]);
    }

    public function delete($id)
    {
        $this->authorize('category.delete', Auth::user());
        $category = $this->categoryService->getById($id);

        if (!$category) {
            return $this->respondNotFound([
                'message' => __('messages.not_found')
            ]);
        }

        $category->delete();

        return $this->respondOk([
            'message' => __('messages.delete_success')
        ]);
    }
}
