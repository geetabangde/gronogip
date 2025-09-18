<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{

    public function index()
    {
        $brands = Brand::with('manufacturer')
            ->where('manufacturer_id', auth()->id()) // only logged in manufacturer
            ->get()
            ->map(function ($brand) {
                if ($brand->image) {
                    $brand->image = url('uploads/' . basename($brand->image));
                }
                return $brand;
            });

        return view('manufacturer.brands.index', compact('brands'));
    }

        // ✅ Show Create Form
        public function create()
        {
            return view('manufacturer.brands.create'); // no manufacturer dropdown
        }

    // Store a new brand
        public function store(Request $request)
       {
        
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ]);

        $imageUrl = null;

        // Image upload logic
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $imageName = 'image_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);

            // full URL path
            $imageUrl = url('uploads/' . $imageName);
        }
        

         $brand = Brand::create([
            'name'            => $request->name,
            'description'     => $request->description,
            'image' => $imageUrl, 
            'status'          => 1,
            'manufacturer_id' => auth()->id(),
         ]);
        
        return redirect()->route('admin.brand.index')
            ->with('success', 'Brand created successfully.');
    }

    // ✅ Edit Form
    
    public function edit($id)
    {
        $brand = Brand::where('id', $id)
            ->where('manufacturer_id', auth()->id()) // security: only own brand
            ->first();

        if (!$brand) {
            return redirect()->route('admin.brand.index')
                            ->with('error', 'Brand not found');
        }

        return view('manufacturer.brands.edit', compact('brand'));
    }

    // ✅ Update Brand
       public function update(Request $request, $id)
        {
            // Find the brand belonging to authenticated manufacturer
            $brand = Brand::where('id', $id)
                ->where('manufacturer_id', auth()->id())
                ->first();

            if (!$brand) {
                return redirect()->route('admin.brand.index')
                ->with('error', 'Brand not found');
            }

            // Validate request
            $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
                'image'       => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            ]);

            // Update fields
            $brand->name = $request->name;
            $brand->description = $request->description;

            // Handle image upload
            if ($request->hasFile('image') && $request->file('image')->isValid()) {
                $file = $request->file('image');

                // Delete old image if exists
                if ($brand->image && file_exists(public_path('uploads/' . $brand->image))) {
                    unlink(public_path('uploads/' . $brand->image));
                }

                $imageName = 'brand_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads'), $imageName);

            
                $brand->image = $imageName;
            }

            // Save changes to the database
            $brand->save();

            return redirect()->route('admin.brand.index')
                            ->with('success', 'Brand updated successfully');
        }


    // ✅ Delete Brand
    public function destroy($id)
    {
        $brand = Brand::where('id', $id)
            ->where('manufacturer_id', auth()->id())
            ->first();

        if (!$brand) {
            return redirect()->route('manufacturer.brands.index')
                ->with('error', 'Brand not found');
        }

        $brand->delete();

        return redirect()->route('admin.brand.index')
            ->with('success', 'Brand deleted successfully');
    }
}
