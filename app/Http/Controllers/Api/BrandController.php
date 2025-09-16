<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index() {
        $brands = Brand::orderBy('id','desc')->get();
        return response()->json(['brands'=>$brands],200);
    }

    public function store(Request $request){
        $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'status'=>'nullable|in:0,1',
        ]);
        $brand = Brand::create($request->only('name','description','status'));
        return response()->json(['message'=>'Brand created successfully','brand'=>$brand],201);
    }

    public function show($id){
        $brand = Brand::find($id);
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
        ]);

        $brand->update($request->only('name','description','status'));
        return response()->json(['message'=>'Brand updated successfully','brand'=>$brand],200);
    }

    public function destroy($id){
        $brand = Brand::find($id);
        if(!$brand) return response()->json(['message'=>'Brand not found'],404);
        $brand->delete();
        return response()->json(['message'=>'Brand deleted successfully'],200);
    }
}
