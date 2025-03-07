<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subcategory;
use App\Models\Category;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        $categories = Category::all();
        return view('admin.subcategories.index', compact('subcategories', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $subcategory = new Subcategory();
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            
            $imagePath = $request->file('image')->store('subcategories', 'public');
            $subcategory->image = $imagePath;
        }

        $subcategory->save();

        return response()->json(['success' => 'Subcategory added successfully.']);
    }

    public function edit($id)
    {
        $subcategory = Subcategory::find($id);
        return response()->json($subcategory);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $subcategory = Subcategory::find($id);
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category_id;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('subcategories', 'public');
            $subcategory->image = $imagePath;
        }

        $subcategory->save();

        return response()->json(['success' => 'Subcategory updated successfully.']);
    }

    public function destroy($id)
    {
        $subcategory = Subcategory::find($id);
        if ($subcategory) {
            $subcategory->delete();
        }

        return response()->json(['success' => 'Subcategory deleted successfully.']);
    }
}
