<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index() {
        
        $brands = Brand::all() ? Brand::all() : false;
      return view('manufacturer.brands.index', compact('brands'));
        
        
    }

    public function create(){
        return view('manufacturer.brands.create');
    }

    public function store(Request $request)
   {
    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    Brand::create($request->only('name','description'));
    return redirect()->route('admin.brand.index')
    ->with('success', 'Brand created successfully.');
    }  
    public function edit($id)
    {
        $brand = Brand::find($id);

        if (!$brand) {
            return redirect()->route('admin.brand.index')
                            ->with('error', 'Brand not found');
        }

        return view('manufacturer.brands.edit', compact('brand'));
    }
    public function update(Request $request, $id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('admin.brand.index')
                            ->with('error', 'Brand not found');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $brand->update($request->only('name','description'));

        return redirect()->route('admin.brand.index')
                        ->with('success', 'Brand updated successfully');
    }
    public function destroy($id)
    {
        $brand = Brand::find($id);
        if (!$brand) {
            return redirect()->route('admin.brand.index')
                            ->with('error', 'Brand not found');
        }

        $brand->delete();

        return redirect()->route('admin.brand.index')
                        ->with('success', 'Brand deleted successfully');
    }

}
