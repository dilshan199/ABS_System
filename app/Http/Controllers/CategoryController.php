<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $category = Category::paginate(50);

        return view('category.category', compact('category'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Valodate form data
        $validate = $request->validate([
            'category' => ['required', 'unique:category,category'],
            'category_status' => ['required']
        ]);

        $category = new Category();
        $category->category = $request->get('category');
        $category->category_status = $request->get('category_status');
        $category->save();

        return redirect()->back()->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $cat_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $cat_id)
    {
        //
        $category = Category::find($cat_id);

        return response()->json($category);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $cat_id)
    {
        //
        $category = Category::find($cat_id);
        $category->cat_id = $request->get('cat_id');
        $category->category = $request->get('category');
        $category->category_status = $request->get('category_status');
        $category->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $cat_id)
    {
        $category = Category::find($cat_id);
        $category->delete();
    }
}
