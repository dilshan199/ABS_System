<?php

namespace App\Http\Controllers;

use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all product list
        $product = Products::paginate(50);

        $category = DB::table('category')
        ->select('*')
        ->get();

        $maxID = DB::table('products')
        ->select(DB::raw('max(p_id) as max_id'))
        ->first();

        $p_id = $maxID->max_id + 1;

        if(session()->has('loggedin')){
            $user = DB::table('users')->select('*')->where('id', '=', session('loggedin'))->first();

            $user_data = [
                'user' => $user
            ];
        }

        return view('products.product', compact('product', 'category', 'p_id', 'user'));
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
        //
        $validate = $request->validate([
            'cat_id' => ['required'],
            'item' => ['required','unique:products,item'],
            'selling_price' => ['required']
        ]);

        $product            = new Products();
        $product->cat_id    = $request->get('cat_id');
        $product->item      = $request->get('item');
        $product->description   = $request->get('description');
        $product->unit      = $request->get('unit');
        $product->line_no   = $request->get('line_no');
        $product->department  = $request->get('department');
        $product->cost      = $request->get('cost');
        $product->selling_price = $request->get('selling_price');
        $product->rol       = $request->get('rol');
        $product->capacity  = $request->get('capacity');
        $product->open_stock    = $request->get('open_stock');
        $product->save();

        return redirect()->back()->with('success', 'product added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $p_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $p_id)
    {
        // Edit selected row
        $product = Products::find($p_id);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $p_id)
    {
        //
        $product = Products::find($p_id);
        $product->cat_id    = $request->get('cat_id');
        $product->item      = $request->get('item');
        $product->description   = $request->get('description');
        $product->unit      = $request->get('unit');
        $product->line_no   = $request->get('line_no');
        $product->department  = $request->get('department');
        $product->cost      = $request->get('cost');
        $product->selling_price = $request->get('selling_price');
        $product->rol       = $request->get('rol');
        $product->capacity  = $request->get('capacity');
        $product->open_stock    = $request->get('open_stock');
        $product->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $p_id)
    {
        // Delete selected row
        $product = Products::find($p_id);
        $product->delete();
    }

    // Search products
    public function search(Request $request)
    {
        // Get form data
        $p_id = $request->get('p_id');
        $item = $request->get('item');
        $description = $request->get('description');

        $product = DB::table('products')
        ->select('*')
        ->where('p_id', '=', $p_id)
        ->orWhere('item', 'like', '%'.$item.'%')
        ->orWhere('description', 'like', '%'.$description.'%')
        ->paginate(50);

        $category = DB::table('category')
        ->select('*')
        ->get();

        $maxID = DB::table('products')
        ->select(DB::raw('max(p_id) as max_id'))
        ->first();

        $p_id = $maxID->max_id + 1;

        if(session()->has('loggedin')){
            $user = DB::table('users')->select('*')->where('id', '=', session('loggedin'))->first();

            $user_data = [
                'user' => $user
            ];
        }

        return view('products.product', compact('product', 'p_id', 'category', 'user'));
    }
}
