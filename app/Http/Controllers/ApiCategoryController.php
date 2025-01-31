<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ApiCategoryController extends Controller
{
    public function store(Request $request)
    {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:categories,code',
            'desc' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Create the category
        $category = Category::create([
            'name' => $request->name,
            'code' => $request->code,
            'desc' => $request->desc,
        ]);

        return response()->json(['message' => 'Category created successfully', 'data' => $category], 201);
    }

    public function update(Request $request, $id)
{
    // Find the category by ID
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    // Validation
    $validator = Validator::make($request->all(), [
        'name' => 'sometimes|string|max:255',
        'code' => 'sometimes|string|max:50|unique:categories,code,' . $id,
        'desc' => 'nullable|string|max:500',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    // Update the category
    $category->update($request->only('name', 'code', 'desc'));

    return response()->json(['message' => 'Category updated successfully', 'data' => $category], 200);
}


public function destroy($id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    $category->delete();

    return response()->json(['message' => 'Category deleted successfully'], 200);
}
public function show($id)
{
    $category = Category::find($id);

    if (!$category) {
        return response()->json(['message' => 'Category not found'], 404);
    }

    return response()->json(['data' => $category], 200);
}

}




