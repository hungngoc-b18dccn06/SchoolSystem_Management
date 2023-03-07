<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'categories' => 'required|array',
            'categories.*.id' => 'nullable|integer',
            'categories.*.name' => 'required|string',
            'categories.*.status' => 'required|integer|in:' . implode(",", Status::asArray()),
            'categories.*.display_order' => 'required|integer',
        ];
    }

    public function data()
    {
        $data = [];
        foreach ($this->categories as $category) {
            $item = [
                'name' => $category['name'],
                'status' => $category['status'],
                'display_order' => $category['display_order'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            if (isset($category['id'])) {
                $item['id'] = $category['id'];
            }
            $data[] = $item;
        }

        return $data;
    }
}
