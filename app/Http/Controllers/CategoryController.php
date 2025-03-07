<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    // Display category list
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    // Show create category form
    public function create()
    {
        return view('admin.categories.create');
    }

    // Store category data
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Category::create(['name' => $request->name]);
        return redirect()->route('admin.categories.index')->with('success', 'Category added successfully.');
    }

   // Fetch category for edit modal via AJAX
   public function edit($id)
   {
       $category = Category::findOrFail($id);
       return response()->json($category);
   }

   // Update category via AJAX
   public function update(Request $request, $id)
   {
       $request->validate([
           'name' => 'required|string|max:255'
       ]);

       $category = Category::findOrFail($id);
       $category->update([
           'name' => $request->name
       ]);

       return response()->json(['success' => true, 'message' => 'Category updated successfully!', 'category' => $category]);
   }

   // Delete category via AJAX
   public function destroy($id)
   {
       $category = Category::findOrFail($id);
       $category->delete();

       return response()->json(['success' => true, 'message' => 'Category deleted successfully!']);
   }

}
