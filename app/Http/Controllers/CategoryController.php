<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{
    public function index()
    {
        return Inertia::render('Categories/Index', [
            'categories' => Category::latest()->get()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create($request->all());

        return redirect()->back()->with('success', 'Category Created!');
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$id,
        ]);

        $category->update($request->all());

        return redirect()->back()->with('success', 'Category Updated!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        // Optional: Check if products exist in this category before deleting?
        $category->delete();
        return redirect()->back()->with('success', 'Category Deleted!');
    }
}