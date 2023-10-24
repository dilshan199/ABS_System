<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuotationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        // Save quotation

        $quotation = new Quotation();

        // Check customer exit or not
        $exitCustomer = DB::table('customer')
        ->select(DB::raw('count(*) as user_count'))
        ->where('contact_no', '=', $request->get('contact_no'))
        ->first();

        // if exit get customer id from customer table
        if($exitCustomer->user_count > 0){
            $customerId = DB::table('customer')
            ->select('customer_id')
            ->where('contact_no', '=', $request->get('contact_no'))
            ->first();

            $customer_id = $customerId->customer_id;
        }else{
            if(!empty($request->get('customer_id'))){
                $customer_id = $request->get('customer_id');
            }else{
                // else generate customer id using customer table max id
                $customerMaxId = DB::table('customer')
                ->select(DB::raw('max(customer_id) as max_customer_id'))
                ->first();

                $customer_id = $customerMaxId->max_customer_id + 1;
            }
        }

        $supMaxId = DB::table('supplimentry_quotation')
        ->select(DB::raw('max(supplimentry_quotation_id) as max_supp_id'))
        ->first();

        $supp_id = $supMaxId->max_supp_id + 1;

        // Get quotation total amount in separately(Quotation and Supplimentry quotation)
        $total_of_quotation = $total_of_sup_quotation = 0;
        $sup_flage = false;
        if(session('cart')){
            foreach(session('cart') as $cart){
                if($cart['supp_type'] == "Estimated"){
                    $total_of_quotation += $cart['amount'];
                }else{
                    $sup_flage = true;
                    $total_of_sup_quotation += $cart['amount'];
                }
            }
        }

        // Save customer details
        DB::table('customer')
        ->updateOrInsert(
            ['customer_id' => $customer_id],
            ['customer_name' => $request->get('customer_name'), 'contact_no' => $request->get('contact_no')]
        );

        // Save quotation
        DB::table('quotation')
         ->updateOrInsert(
             ['quotation_id' => $request->get('quotation_id')],
             [
                 'quotation_id' => $request->get('quotation_id'),
                 'customer_id' => $customer_id,
                 'insurance_company' => $request->get('insurance_company'),
                 'vehicle_no' => $request->get('vehicle_no'),
                 'year' => $request->get('year'),
                 'chasis_no' => $request->get('chasis_no'),
                 'color' => $request->get('color'),
                 'meter_reading' => $request->get('meter_reading'),
                 'model' => $request->get('model'),
                 'engine_no' => $request->get('engine_no'),
                 'remarks' => $request->get('remarks'),
                 'quo_amount' => $total_of_quotation,
                 'quotation_date' => $request->get('quotation_date')
             ]
         );
        if($sup_flage){
            // Save Supplimentry quotation
            DB::table('supplimentry_quotation')
            ->updateOrInsert(
                ['quotation_id' => $request->get('quotation_id')],
                [
                    'quotation_id' => $request->get('quotation_id'),
                    'customer_id' => $customer_id,
                    'insurance_company' => $request->get('insurance_company'),
                    'vehicle_no' => $request->get('vehicle_no'),
                    'year' => $request->get('year'),
                    'chasis_no' => $request->get('chasis_no'),
                    'color' => $request->get('color'),
                    'meter_reading' => $request->get('meter_reading'),
                    'model' => $request->get('model'),
                    'engine_no' => $request->get('engine_no'),
                    'remarks' => $request->get('remarks'),
                    'sup_quo_amount' => $total_of_sup_quotation,
                    'supplimentry_quotation_date' => $request->get('quotation_date')
                 ]
            );
        }

        // Add cart item to quotation and supplimentry quotation
        if(session('cart')){
            foreach(session('cart') as $cart){
                //if supp type is "Estimated" send item to quotation item table
                if($cart['supp_type'] == "Estimated"){
                    DB::table('quotation_item')
                    ->updateOrInsert(
                        ['p_id' => $cart['p_id']],
                        ['quotation_id' => $request->get('quotation_id'), 'cat_id' => $cart['cat_id'], 'p_id' => $cart['p_id'], 'supp_type' => $cart['supp_type'], 'hours' => $cart['hours'], 'amount' => $cart['amount'], 'amount2' => $cart['amount2']]
                    );
                }else{
                    // Else supp type is "Supplimentry Quotation" send to the item to supplimentry quotation
                    DB::table('supplimentry_quotation_item')
                    ->updateOrInsert(
                        ['p_id' => $cart['p_id']],
                        ['supplimentry_quotation_id' => $supp_id, 'cat_id' => $cart['cat_id'], 'p_id' => $cart['p_id'], 'supp_type' => $cart['supp_type'], 'hours' => $cart['hours'], 'amount' => $cart['amount'], 'amount2' => $cart['amount2']]
                    );
                }
            }
        }

        return redirect()->back()->with('success', 'Quotation saved successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $quotation_id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // Refresh all sessions
        $request->session()->forget('cart');
        $request->session()->forget('quotation_id');
        $request->session()->forget('customer_id');
        $request->session()->forget('customer_name');
        $request->session()->forget('contact_no');
        $request->session()->forget('insurance_company');
        $request->session()->forget('vehicle_no');
        $request->session()->forget('year');
        $request->session()->forget('chasis_no');
        $request->session()->forget('color');
        $request->session()->forget('model');
        $request->session()->forget('remarks');
        $request->session()->forget('quotation_date');

        // Fetch selected quotation using quotation id
        $quotation = DB::table('quotation')
        ->select('*')
        ->join('customer', 'quotation.customer_id', '=', 'customer.customer_id', 'inner')
        ->where('quotation_id', '=', $request->get('quotation_id'))
        ->first();

        session()->put([
            'quotation_id' => $quotation->quotation_id,
            'customer_name' => $quotation->customer_name,
            'customer_id' => $quotation->customer_id,
            'contact_no' => $quotation->contact_no,
            'insurance_company' => $quotation->insurance_company,
            'vehicle_no' => $quotation->vehicle_no,
            'year' => $quotation->year,
            'chasis_no' => $quotation->chasis_no,
            'color' => $quotation->color,
            'meter_reading' => $quotation->meter_reading,
            'model' => $quotation->model,
            'engine_no' => $quotation->engine_no,
            'remarks' => $quotation->remarks,
            'quotation_date' => $quotation->quotation_date,
        ]);

        // Cart session
        $cart = session()->get('cart', []);

        // Select all item for related quotation using quotation table
        $quotation_item = DB::table('quotation_item')
        ->select('*')
        ->join('category', 'quotation_item.cat_id', '=', 'category.cat_id')
        ->join('products', 'quotation_item.p_id', '=', 'products.p_id')
        ->where('quotation_id', '=', $request->get('quotation_id'))
        ->get();


        //Check supplimentry quotation is create realted quotation
        $count = DB::table('supplimentry_quotation')
        ->select(DB::raw('count(*) as id_count'))
        ->where('quotation_id', '=', $request->get('quotation_id'))
        ->first();

        foreach($quotation_item as $qti){
            $c_id = uniqid();
            if(empty($cart)){
                $cart = [
                    $c_id => [
                        'c_id' => $c_id,
                        'p_id' => $qti->p_id,
                        'item' => $qti->item,
                        'cat_id' => $qti->cat_id,
                        'category' => $qti->category,
                        'amount' => $qti->amount,
                        'hours' => $qti->hours,
                        'amount2' => $qti->amount2,
                        'supp_type' => $qti->supp_type,
                    ]
                ];

                session()->put('cart', $cart);
            } else{
                $cart[$c_id] = [
                    'c_id' => $c_id,
                    'p_id' => $qti->p_id,
                    'item' => $qti->item,
                    'cat_id' => $qti->cat_id,
                    'category' => $qti->category,
                    'amount' => $qti->amount,
                    'hours' => $qti->hours,
                    'amount2' => $qti->amount2,
                    'supp_type' => $qti->supp_type,
                ];

                session()->put('cart', $cart);
            }

            if($count->id_count > 0){

                $su_id = DB::table('supplimentry_quotation')
                ->select('supplimentry_quotation_id')
                ->where('quotation_id', '=', $request->get('quotation_id'))
                ->first();

                $supp_quotation_item = DB::table('supplimentry_quotation_item')
                ->select('*')
                ->join('category', 'supplimentry_quotation_item.cat_id', '=', 'category.cat_id')
                ->join('products', 'supplimentry_quotation_item.p_id', '=', 'products.p_id')
                ->where('supplimentry_quotation_id', '=', $su_id->supplimentry_quotation_id)
                ->get();

                foreach($supp_quotation_item as $qti){
                    $c_id = uniqid();
                    if(empty($cart)){
                        $cart = [
                            $c_id => [
                                'c_id' => $c_id,
                                'p_id' => $qti->p_id,
                                'item' => $qti->item,
                                'cat_id' => $qti->cat_id,
                                'category' => $qti->category,
                                'amount' => $qti->amount,
                                'hours' => $qti->hours,
                                'amount2' => $qti->amount2,
                                'supp_type' => $qti->supp_type,
                            ]
                        ];

                        session()->put('cart', $cart);
                    } else{
                        $cart[$c_id] = [
                            'c_id' => $c_id,
                            'p_id' => $qti->p_id,
                            'item' => $qti->item,
                            'cat_id' => $qti->cat_id,
                            'category' => $qti->category,
                            'amount' => $qti->amount,
                            'hours' => $qti->hours,
                            'amount2' => $qti->amount2,
                            'supp_type' => $qti->supp_type,
                        ];

                        session()->put('cart', $cart);
                    }
                }
            }
        }

        return redirect()->back();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $quotation_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $quotation_id)
    {
        // Deelete selected quotation
        $quotation = Quotation::find($quotation_id);
        $quotation->delete();
    }

    public function quotationPage(){
        if(session()->has('loggedin')){
            $user = DB::table('users')->select('*')->where('id', '=', session('loggedin'))->first();

            $user_data = [
                'user' => $user
            ];
        }

        // Generate quotation id using quotation table max id
        $max_quotation_id = DB::table('quotation')
        ->select(DB::raw('max(quotation_id) as maxQuotationId'))
        ->first();

        $quotation_id = $max_quotation_id->maxQuotationId + 1;

        // Get all categories
        $category = DB::table('category')
        ->select('*')
        ->get();

        return view('quotation.quotation', compact('user', 'quotation_id', 'category'));
    }

    // Get all quotation related to vehicle no
    public function getAllQuotation(Request $request)
    {
        // Get form input
        $vehicle_no = $request->get('vehicle_no');

        // Fetch all quotation for related vehicle no
        $quotation = DB::table('quotation')
        ->select('quotation_id')
        ->where('vehicle_no', '=', $vehicle_no)
        ->get();

        return redirect()->back()->with('quotation', $quotation);
    }

    public function getTypeItem(Request $request)
    {
        $products = DB::table('products')
        ->select('*')
        ->join('category', 'products.cat_id', '=', 'category.cat_id', 'inner')
        ->where('item', 'like', '%'.$request->get('item').'%')
        ->get();

        $table = '';
        $table .= '<table class="w-full border border-gray-400 text-sm">';
        $table .= '<tbody';
        $table .= '<tr></tr>';
        foreach($products as $pr){
            $table .= '<tr class="cursor-pointer hover:bg-gray-100" onclick="selectItem('.$pr->p_id.')">';
            $table .= '<td class="px-1 py-1 border border-gray-400 w-[55%]">'.$pr->item.'</td>';
            $table .= '<td class="px-1 py-1 border border-gray-400">'.$pr->category.'</td>';
            $table .= '<td class="px-1 py-1 border border-gray-400">'.$pr->selling_price.'</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';

        echo $table;
    }

    public function getItem(string $p_id)
    {
        $products = DB::table('products')
        ->select('products.p_id', 'products.item', 'products.cat_id', 'products.selling_price')
        ->where('p_id', '=', $p_id)
        ->first();

        return response()->json($products);
    }

    public function addToCart(Request $request)
    {

        // Add basic quotation information to array
        session()->put([
            'customer_name' => $request->get('customer_name'),
            'customer_id' => $request->get('customer_id'),
            'contact_no' => $request->get('contact_no'),
            'insurance_company' => $request->get('insurance_company'),
            'vehicle_no' => $request->get('vehicle_no'),
            'year' => $request->get('year'),
            'chasis_no' => $request->get('chasis_no'),
            'color' => $request->get('color'),
            'meter_reading' => $request->get('meter_reading'),
            'model' => $request->get('model'),
            'engine_no' => $request->get('engine_no'),
            'remarks' => $request->get('remarks'),
            'quotation_date' => $request->get('quotation_date'),
        ]);

        //Fetch category name for related category
        $category = DB::table('category')
        ->select('category')
        ->where('cat_id', '=', $request->get('cat_id'))
        ->first();

        $category = $category->category;

        $cart = session()->get('cart', []);

        /*
        First, check cart is empty
        if cart is empty add first item for a cart session
        */
        $c_id = uniqid();
        if(empty($cart)){
            $cart = [
                $c_id => [
                    'c_id' => $c_id,
                    'p_id' => $request->get('p_id'),
                    'item' => $request->get('item'),
                    'cat_id' => $request->get('cat_id'),
                    'category' => $category,
                    'amount' => $request->get('amount'),
                    'hours' => (!empty($request->get('hours'))) ? $request->get('hours') : '0.00',
                    'amount2' => (!empty($request->get('amount2'))) ? $request->get('amount2') : '0.00',
                    'supp_type' => (!empty($request->get('supp_type'))) ? $request->get('supp_type') : 'Estimated',
                ]
            ];

            session()->put('cart', $cart);

            return redirect()->back();
        } else{
            $cart[$c_id] = [
                'c_id' => $c_id,
                'p_id' => $request->get('p_id'),
                'item' => $request->get('item'),
                'cat_id' => $request->get('cat_id'),
                'category' => $category,
                'amount' => $request->get('amount'),
                'hours' => (!empty($request->get('hours'))) ? $request->get('hours') : '0.00',
                'amount2' => (!empty($request->get('amount2'))) ? $request->get('amount2') : '0.00',
                'supp_type' => (!empty($request->get('supp_type'))) ? $request->get('supp_type') : 'Estimated',

            ];

            session()->put('cart', $cart);
            return redirect()->back();
        }
    }

    public function emptyCart(Request $request)
    {
        $request->session()->forget('cart');
        $request->session()->forget('quotation_id');
        $request->session()->forget('customer_id');
        $request->session()->forget('customer_name');
        $request->session()->forget('contact_no');
        $request->session()->forget('insurance_company');
        $request->session()->forget('vehicle_no');
        $request->session()->forget('year');
        $request->session()->forget('chasis_no');
        $request->session()->forget('color');
        $request->session()->forget('model');
        $request->session()->forget('remarks');
        $request->session()->forget('quotation_date');
        return redirect()->back();
    }

    public function removeCartItem(string $c_id)
    {
        $cart = session()->get('cart');

        // Remove selected cart item
        if(isset($cart[$c_id]))
        {
            unset($cart[$c_id]);
            session()->put('cart', $cart);
        }

        return redirect()->back();
    }

    public function getOldQuotation(Request $request, string $quotation_id)
    {
         // Refresh all sessions
         $request->session()->forget('cart');
         $request->session()->forget('quotation_id');
         $request->session()->forget('customer_id');
         $request->session()->forget('customer_name');
         $request->session()->forget('contact_no');
         $request->session()->forget('insurance_company');
         $request->session()->forget('vehicle_no');
         $request->session()->forget('year');
         $request->session()->forget('chasis_no');
         $request->session()->forget('color');
         $request->session()->forget('model');
         $request->session()->forget('remarks');
         $request->session()->forget('quotation_date');

         // Fetch selected quotation using quotation id
         $quotation = DB::table('quotation')
         ->select('*')
         ->join('customer', 'quotation.customer_id', '=', 'customer.customer_id', 'inner')
         ->where('quotation_id', '=', $quotation_id)
         ->first();

         session()->put([
             'quotation_id' => $quotation->quotation_id,
             'customer_name' => $quotation->customer_name,
             'customer_id' => $quotation->customer_id,
             'contact_no' => $quotation->contact_no,
             'insurance_company' => $quotation->insurance_company,
             'vehicle_no' => $quotation->vehicle_no,
             'year' => $quotation->year,
             'chasis_no' => $quotation->chasis_no,
             'color' => $quotation->color,
             'meter_reading' => $quotation->meter_reading,
             'model' => $quotation->model,
             'engine_no' => $quotation->engine_no,
             'remarks' => $quotation->remarks,
             'quotation_date' => $quotation->quotation_date,
         ]);

        // Cart session
        $cart = session()->get('cart', []);

        // Select all item for related quotation using quotation table
        $quotation_item = DB::table('quotation_item')
        ->select('*')
        ->join('category', 'quotation_item.cat_id', '=', 'category.cat_id')
        ->join('products', 'quotation_item.p_id', '=', 'products.p_id')
        ->where('quotation_id', '=', $request->get('quotation_id'))
        ->get();


        //Check supplimentry quotation is create realted quotation
        $count = DB::table('supplimentry_quotation')
        ->select(DB::raw('count(*) as id_count'))
        ->where('quotation_id', '=', $request->get('quotation_id'))
        ->first();

        foreach($quotation_item as $qti){
            $c_id = uniqid();
            if(empty($cart)){
                $cart = [
                    $c_id => [
                        'c_id' => $c_id,
                        'p_id' => $qti->p_id,
                        'item' => $qti->item,
                        'cat_id' => $qti->cat_id,
                        'category' => $qti->category,
                        'amount' => $qti->amount,
                        'hours' => $qti->hours,
                        'amount2' => $qti->amount2,
                        'supp_type' => $qti->supp_type,
                    ]
                ];

                session()->put('cart', $cart);
            } else{
                $cart[$c_id] = [
                    'c_id' => $c_id,
                    'p_id' => $qti->p_id,
                    'item' => $qti->item,
                    'cat_id' => $qti->cat_id,
                    'category' => $qti->category,
                    'amount' => $qti->amount,
                    'hours' => $qti->hours,
                    'amount2' => $qti->amount2,
                    'supp_type' => $qti->supp_type,
                ];

                session()->put('cart', $cart);
            }

            if($count->id_count > 0){

                $su_id = DB::table('supplimentry_quotation')
                ->select('supplimentry_quotation_id')
                ->where('quotation_id', '=', $request->get('quotation_id'))
                ->first();

                $supp_quotation_item = DB::table('supplimentry_quotation_item')
                ->select('*')
                ->join('category', 'supplimentry_quotation_item.cat_id', '=', 'category.cat_id')
                ->join('products', 'supplimentry_quotation_item.p_id', '=', 'products.p_id')
                ->where('supplimentry_quotation_id', '=', $su_id->supplimentry_quotation_id)
                ->get();

                foreach($supp_quotation_item as $qti){
                    $c_id = uniqid();
                    if(empty($cart)){
                        $cart = [
                            $c_id => [
                                'c_id' => $c_id,
                                'p_id' => $qti->p_id,
                                'item' => $qti->item,
                                'cat_id' => $qti->cat_id,
                                'category' => $qti->category,
                                'amount' => $qti->amount,
                                'hours' => $qti->hours,
                                'amount2' => $qti->amount2,
                                'supp_type' => $qti->supp_type,
                            ]
                        ];

                        session()->put('cart', $cart);
                    } else{
                        $cart[$c_id] = [
                            'c_id' => $c_id,
                            'p_id' => $qti->p_id,
                            'item' => $qti->item,
                            'cat_id' => $qti->cat_id,
                            'category' => $qti->category,
                            'amount' => $qti->amount,
                            'hours' => $qti->hours,
                            'amount2' => $qti->amount2,
                            'supp_type' => $qti->supp_type,
                        ];

                        session()->put('cart', $cart);
                    }
                }
            }
        }

        return redirect()->back();
    }

}
