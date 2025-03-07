<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();
        return view('admin.banners.index', compact('banners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner = new Banner();
        if ($request->hasFile('image')) {
            $banner->image = $request->file('image')->store('banners', 'public');
        }

        $banner->save();
        return back()->with('success', 'Banner added successfully.');
    }
    public function edit($id)
    {
        $banner = Banner::find($id);
        return response()->json($banner);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $banner = Banner::find($id);
       

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('subcategories', 'public');
            $banner->image = $imagePath;
        }

        $banner->save();

        return response()->json(['success' => 'banner updated successfully.']);
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);
        if ($banner) {
            $banner->delete();
        }
        return response()->json(['success' => 'banner deleted successfully.']);
    }
}
