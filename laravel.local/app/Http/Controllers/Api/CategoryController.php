<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        $new_category = Category::create($request->validated());

        return response()->json($new_category);
    }
}
