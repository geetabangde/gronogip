<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index() {
       $brands = Brand::with('manufacturer')
                   ->orderBy('id','desc')
                   ->get();
                   // add full image path
        $brands = $brands->map(function ($brand) {
            if ($brand->image) {
                $brand->image = url('uploads/' . basename($brand->image));
            }
            return $brand;
        });
       return response()->json(['brands'=>$brands],200);
    }


    public function store(Request $request){
    $request->validate([
        'name'            => 'required|string|max:255',
        'description'     => 'nullable|string',
        'status'          => 'nullable|in:0,1',
        'image'           => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        'manufacturer_id' => 'required|exists:admins,id', // validate manufacturer exists
    ]);

    $imageUrl = null;

    // ✅ Image upload logic
    if ($request->hasFile('image') && $request->file('image')->isValid()) {
        $file = $request->file('image');
        $imageName = 'brand_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads'), $imageName);

        // full URL path
        $imageUrl = url('uploads/' . $imageName);
    }

    // ✅ Brand create
    $brand = Brand::create([
        'name'            => $request->name,
        'description'     => $request->description,
        'status'          => $request->status,
        'manufacturer_id' => $request->manufacturer_id,
        'image'           => $imageUrl, // column "image" me URL save hoga
    ]);

    return response()->json([
        'message' => 'Brand created successfully',
        'brand'   => $brand
    ], 201);
}


    public function show($id){
        $brand = Brand::find($id);
        // add full image path
        if ($brand->image) {
            $brand->image = url('uploads/' . basename($brand->image));
        }
        if(!$brand) return response()->json(['message'=>'Brand not found'],404);
        return response()->json(['brand'=>$brand],200);
    }

    public function update(Request $request,$id){
        $brand = Brand::find($id);
        if(!$brand) return response()->json(['message'=>'Brand not found'],404);

        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'status'=>'nullable|in:0,1',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'manufacturer_id'=>'required|exists:admins,id', // validate manufacturer exists
        ]);
       // Handle image upload
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $imageName = 'image_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $imageName);

            // full URL
            $brand->image = url('uploads/' . $imageName);
        }

        // Update other fields
        $brand->fill($request->except('image'));

        $brand->update($request->only('name','description','status','manufacturer_id'));
        return response()->json(['message'=>'Brand updated successfully','brand'=>$brand],200);
    }

    public function destroy($id){
        $brand = Brand::find($id);
        // Delete image if exists
        if ($brand->image) {
            $imagePath = public_path('uploads/' . basename($brand->image));
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        if(!$brand) return response()->json(['message'=>'Brand not found'],404);
        $brand->delete();
        return response()->json(['message'=>'Brand deleted successfully'],200);
    }
}
