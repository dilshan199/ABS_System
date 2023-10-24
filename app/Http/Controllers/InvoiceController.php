<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

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

        // Save customer details
        DB::table('customer')
        ->updateOrInsert(
            ['customer_id' => $customer_id],
            ['customer_name' => $request->get('customer_name'), 'contact_no' => $request->get('contact_no')]
        );

        // Save quotation
        DB::table('invoice')
        ->updateOrInsert(
            ['invoice_id' => $request->get('invoice_id')],
            [
                'invoice_id' => $request->get('invoice_id'),
                'customer_id' => $customer_id,
                'insurance_company' => $request->get('insurance_company'),
                'vehicle_no' => $request->get('vehicle_no'),
                'model' => $request->get('model'),
                'vat_number' => $request->get('vat_number'),
                'with_out_tax_amount' => $request->get('with_out_tax_amount'),
                'cash_discount' => $request->get('cash_discount'),
                'vat' => $request->get('vat'),
                'nbt' => $request->get('nbt'),
                'net_amount' => $request->get('net_amount'),
                'paid_amount' => $request->get('paid_amount'),
                'balance' => $request->get('balance'),
                'invoice_date' => $request->get('invoice_date'),
            ]
        );

        // Add cart item to quotation and supplimentry quotation
        if(session('in_cart')){
            foreach(session('in_cart') as $incart){
                    DB::table('invoice_item')
                    ->updateOrInsert(
                        ['p_id' => $incart['p_id']],
                        ['invoice_id' => $request->get('invoice_id'), 'cat_id' => $incart['cat_id'], 'p_id' => $incart['p_id'], 'item_description' => $incart['description'], 'qty' => $incart['qty'], 'cost' => $incart['cost'], 'rate' => $incart['rate']]
                    );
            }
        }

        return redirect()->back()->with('success', 'Invoice saved successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        // Refresh all sessions
        $request->session()->forget('in_cart');
        $request->session()->forget('invoice_id');
        $request->session()->forget('customer_id_2');
        $request->session()->forget('customer_name_2');
        $request->session()->forget('contact_no_2');
        $request->session()->forget('insurance_company_2');
        $request->session()->forget('vehicle_no_2');
        $request->session()->forget('model_2');
        $request->session()->forget('vat_number');
        $request->session()->forget('net_amount');
        $request->session()->forget('vat');
        $request->session()->forget('nbt');
        $request->session()->forget('cash_discount');
        $request->session()->forget('invoice_date');
        $request->session()->forget('paid_amount');
        $request->session()->forget('balance');

        // Fetch selected quotation using quotation id
        $invoice = DB::table('invoice')
        ->select('*')
        ->join('customer', 'invoice.customer_id', '=', 'customer.customer_id', 'inner')
        ->where('invoice_id', '=', $request->get('invoice_id'))
        ->first();

        session()->put([
            'invoice_id' => $invoice->invoice_id,
            'customer_name_2' => $invoice->customer_name,
            'customer_id_2' => $invoice->customer_id,
            'contact_no_2' => $invoice->contact_no,
            'insurance_company_2' => $invoice->insurance_company,
            'vehicle_no_2' => $invoice->vehicle_no,
            'model_2' => $invoice->model,
            'vat_number' => $invoice->vat_number,
            'with_out_tax_amount' => $invoice->with_out_tax_amount,
            'cash_discount' => $invoice->cash_discount,
            'vat' => $invoice->vat,
            'nbt' => $invoice->nbt,
            'net_amount' => $invoice->net_amount,
            'paid_amount' => $invoice->paid_amount,
            'balance' => $invoice->balance,
            'invoice_date' => $invoice->invoice_date,
        ]);

        // Cart session
        $cart = session()->get('cart', []);

        // Select all item for related quotation using quotation table
        $invoice_item = DB::table('invoice_item')
        ->select('*')
        ->join('category', 'invoice_item.cat_id', '=', 'category.cat_id')
        ->join('products', 'invoice_item.p_id', '=', 'products.p_id')
        ->where('invoice_id', '=', $request->get('invoice_id'))
        ->get();

        foreach($invoice_item as $invoice_item){
            $c_id = uniqid();
            if(empty($in_cart)){
                $in_cart = [
                    $c_id => [
                        'c_id' => $c_id,
                        'p_id' => $invoice_item->p_id,
                        'item' => $invoice_item->item,
                        'cat_id' => $invoice_item->cat_id,
                        'category' => $invoice_item->category,
                        'description' => $invoice_item->item_description,
                        'qty' => $invoice_item->qty,
                        'cost' => $invoice_item->cost,
                        'rate' => $invoice_item->rate,
                    ]
                ];

                session()->put('in_cart', $in_cart);

            } else{
                $in_cart[$c_id] = [
                    'c_id' => $c_id,
                    'p_id' => $invoice_item->p_id,
                    'item' => $invoice_item->item,
                    'cat_id' => $invoice_item->cat_id,
                    'category' => $invoice_item->category,
                    'description' => $invoice_item->item_description,
                    'qty' => $invoice_item->qty,
                    'cost' => $invoice_item->cost,
                    'rate' => $invoice_item->rate,
                ];

                session()->put('in_cart', $in_cart);
            }
        }

        $payment = DB::table('payment')
        ->select('*')
        ->where('invoice_id', '=', $request->get('invoice_id'))
        ->get();

        return redirect()->back()->with('payment', $payment);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $invoice_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $invoice_id)
    {
        // Refresh all sessions
        $request->session()->forget('in_cart');
        $request->session()->forget('invoice_id');
        $request->session()->forget('customer_id_2');
        $request->session()->forget('customer_name_2');
        $request->session()->forget('contact_no_2');
        $request->session()->forget('insurance_company_2');
        $request->session()->forget('vehicle_no_2');
        $request->session()->forget('model_2');
        $request->session()->forget('vat_number');
        $request->session()->forget('net_amount');
        $request->session()->forget('vat');
        $request->session()->forget('nbt');
        $request->session()->forget('cash_discount');
        $request->session()->forget('invoice_date');
        $request->session()->forget('paid_balance');
        $request->session()->forget('balance');

        $invoice = Invoice::find($invoice_id);
        $invoice->delete();
    }

    public function invoicePage()
    {
        if(session()->has('loggedin')){
            $user = DB::table('users')->select('*')->where('id', '=', session('loggedin'))->first();

            $user_data = [
                'user' => $user
            ];
        }

        // Generate quotation id using quotation table max id
        $max_invoice_id = DB::table('invoice')
        ->select(DB::raw('max(invoice_id) as maxQuotationId'))
        ->first();

        $invoice_id = $max_invoice_id->maxQuotationId + 1;

        // Get all categories
        $category = DB::table('category')
        ->select('*')
        ->get();

        return view('invoice.invoice', compact('user', 'invoice_id', 'category'));
    }

    //Invoice find by vehicle No
    public function invoiceByVehicleNo(Request $request)
    {
        // Get form input
        $vehicle_no = $request->get('vehicle_no');

        // Fetch all invoice for related vehicle no
        $invoice = DB::table('invoice')
        ->select('invoice_id')
        ->where('vehicle_no', '=', $vehicle_no)
        ->get();

        return redirect()->back()->with('invoice', $invoice);
    }

    // Invoice By customer name
    public function invoiceByCustomerName(Request $request)
    {
        $customer_id = DB::table('customer')
        ->select('customer_id')
        ->where('customer_name', '=', $request->get('customer_name'))
        ->first();

        // Fetch all quotation for related vehicle no
        $invoice = DB::table('invoice')
        ->select('invoice_id')
        ->where('customer_id', '=', $customer_id->customer_id)
        ->get();

        return redirect()->back()->with('invoice', $invoice);
    }

    //Get details using job no
    public function getByJobN(Request $request)
    {
        $getData = DB::table('job')
        ->select('customer_id')
        ->join('customer', 'job.customer_id', '=', 'customer.customer_id')
        ->where('job_id', '=', $request->get('job_id'))
        ->first();

        session()->put([
            'customer_name' => $getData->customer_name,
            'customer_id' => $getData->customer_id,
            'contact_no' => $getData->contact_no,
            'insurance_company' => $getData->insurance_company,
            'vehicle_no' => $getData->vehicle_no,
            'model' => $getData->model
        ]);

        return redirect()->back();
    }

    // Get details using quotation no
    public function getByQuotationNo(Request $request)
    {
        $getData = DB::table('quotation')
        ->select('customer_id')
        ->join('customer', 'quotation.customer_id', '=', 'customer.customer_id')
        ->where('quotation_id', '=', $request->get('quotation_id'))
        ->first();

        session()->put([
            'customer_name' => $getData->customer_name,
            'customer_id' => $getData->customer_id,
            'contact_no' => $getData->contact_no,
            'insurance_company' => $getData->insurance_company,
            'vehicle_no' => $getData->vehicle_no,
            'model' => $getData->model
        ]);

        return redirect()->back();
    }

    // Payment
    public function payment(Request $request)
    {
        $invoice_id = session()->get('invoice_id');
        $payment_date = $request->get('payment_date');
        $account = $request->get('account');
        $payment_type = $request->get('payment_type');
        $transaction_no = $request->get('transaction_no');
        $amount = $request->get('amount');
        $balance = session()->get('balance');

        $in_count = DB::table('invoice')
        ->select(DB::raw('count(*) as count'))
        ->where('invoice_id', '=', $invoice_id)
        ->first();

        if($in_count->count > 0){
            if($amount == $balance){
                // Update invoice table
                $update_invoice = DB::table('invoice')
                ->where('invoice_id', '=', $invoice_id)
                ->update(['paid_amount' => $amount, 'balance' => 0]);

                // Insert payment into payment table
                $insert_payment = DB::table('payment')
                ->insert([
                    'invoice_id' => $invoice_id,
                    'account' => $account,
                    'payment_type' => $payment_type,
                    'transaction_no' => $transaction_no,
                    'amount' => $amount,
                    'payment_date' => $payment_date
                ]);

                $invoice = DB::table('invoice')
                ->select('*')
                ->where('invoice_id', '=', $invoice_id)
                ->first();

                session()->put([
                    'paid_amount' => $invoice->paid_amount,
                    'balance' => $invoice->balance
                ]);

                return redirect()->back()->with('success', 'Payment addedd successfully');

            }else{
                return redirect()->back()->with('error', 'Payment amount is wrong');
            }
        }else{
            return redirect()->back()->with('error', 'Can\'t added to payment.No Invoice found in this invoice <strong>'.$invoice_id.'</strong>');
        }
    }

    // New invoice
    public function newInvoice(Request $request)
    {
        $request->session()->forget('in_cart');
        $request->session()->forget('invoice_id');
        $request->session()->forget('customer_id_2');
        $request->session()->forget('customer_name_2');
        $request->session()->forget('contact_no_2');
        $request->session()->forget('insurance_company_2');
        $request->session()->forget('vehicle_no_2');
        $request->session()->forget('model_2');
        $request->session()->forget('vat_number');
        $request->session()->forget('net_amount');
        $request->session()->forget('vat');
        $request->session()->forget('nbt');
        $request->session()->forget('cash_discount');
        $request->session()->forget('invoice_date');
        $request->session()->forget('paid_amount');
        $request->session()->forget('balance');

        return redirect()->back();
    }

    // Add item to cart
    public function addToCart(Request $request)
    {
        // Add basic quotation information to array
        session()->put([
            'invoice_id' => $request->get('invoice_id'),
            'customer_name_2' => $request->get('customer_name'),
            'customer_id_2' => $request->get('customer_id'),
            'contact_no_2' => $request->get('contact_no'),
            'insurance_company_2' => $request->get('insurance_company'),
            'vehicle_no_2' => $request->get('vehicle_no'),
            'model_2' => $request->get('model'),
            'vat_number_2' => $request->get('vat_number'),
            'invoice_date' => $request->get('invoice_date'),
        ]);

        //Fetch category name for related category
        $category = DB::table('category')
        ->select('category')
        ->where('cat_id', '=', $request->get('cat_id'))
        ->first();

        $category = $category->category;

        $in_cart = session()->get('in_cart', []);

        /*
        First, check cart is empty
        if cart is empty add first item for a cart session
        */
        $c_id = uniqid();
        if(empty($in_cart)){
            $in_cart = [
                $c_id => [
                    'c_id' => $c_id,
                    'p_id' => $request->get('p_id'),
                    'item' => $request->get('item'),
                    'cat_id' => $request->get('cat_id'),
                    'category' => $category,
                    'description' => $request->get('description'),
                    'qty' => (!empty($request->get('qty'))) ? $request->get('qty') : '1',
                    'cost' => (!empty($request->get('cost'))) ? $request->get('cost') : '0.00',
                    'rate' => (!empty($request->get('rate'))) ? $request->get('rate') : '0.00',
                ]
            ];

            session()->put('in_cart', $in_cart);

            return redirect()->back();
        } else{
            $in_cart[$c_id] = [
                'c_id' => $c_id,
                'p_id' => $request->get('p_id'),
                'item' => $request->get('item'),
                'cat_id' => $request->get('cat_id'),
                'category' => $category,
                'description' => $request->get('description'),
                'qty' => (!empty($request->get('qty'))) ? $request->get('qty') : '1',
                'cost' => (!empty($request->get('cost'))) ? $request->get('cost') : '0.00',
                'rate' => (!empty($request->get('rate'))) ? $request->get('rate') : '0.00',

            ];

            session()->put('in_cart', $in_cart);
            return redirect()->back();
        }
    }

    //Remove cart item
    public function removeCartItem(string $c_id)
    {
        $in_cart = session()->get('in_cart');

        // Remove selected cart item
        if(isset($in_cart[$c_id]))
        {
            unset($in_cart[$c_id]);
            session()->put('in_cart', $in_cart);
        }

        return redirect()->back();
    }

    // Search item
    public function searchItem(Request $request)
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
        ->select('products.p_id', 'products.item', 'products.cat_id', 'products.selling_price', 'products.cost')
        ->where('p_id', '=', $p_id)
        ->first();

        return response()->json($products);
    }

    public function searchCustomer(Request $request)
    {
        $customer = DB::table('customer')
        ->select('*')
        ->where('customer_name', 'like', '%'.$request->get('customer_name').'%')
        ->get();

        $table = '';
        $table .= '<table class="w-full border border-gray-400 text-sm">';
        $table .= '<tbody';
        $table .= '<tr></tr>';
        foreach($customer as $cus){
            $table .= '<tr class="cursor-pointer hover:bg-gray-100" onclick="selectItem('.$cus->customer_id.')">';
            $table .= '<td class="px-1 py-1 border border-gray-400 w-[55%]">'.$cus->customer_name.'</td>';
            $table .= '<td class="px-1 py-1 border border-gray-400">'.$cus->address.'</td>';
            $table .= '<td class="px-1 py-1 border border-gray-400">'.$cus->contact_no.'</td>';
            $table .= '</tr>';
        }
        $table .= '</tbody>';
        $table .= '</table>';

        echo $table;
    }

    public function getCustomer(string $customer_id)
    {
        $customer = DB::table('customer')
        ->select('*')
        ->where('customer_id', '=', $customer_id)
        ->first();

        return response()->json($customer);
    }

    // Calculator
    public function calculator(Request $request)
    {
        if(session('in_cart')){

            $sum_of_total = $net_amount = $total_minus = 0;

            foreach(session('in_cart') as $incart){
                $sum_of_total += $incart['rate'] * $incart['qty'];
            }

            $total_minus = $request->get('cash_discount') + $request->get('vat') + $request->get('nbt');

            $net_amount = $sum_of_total - $total_minus;

            session()->put([
                'net_amount' => $net_amount,
                'vat' => $request->get('vat'),
                'nbt' => $request->get('nbt'),
                'cash_discount' => $request->get('cash_discount')

            ]);
        }

        return redirect()->back();
    }

    // Get old invoice
    public function getOldInvoive(Request $request, string $invoice_id)
    {
        // Refresh all sessions
        $request->session()->forget('in_cart');
        $request->session()->forget('invoice_id');
        $request->session()->forget('customer_id_2');
        $request->session()->forget('customer_name_2');
        $request->session()->forget('contact_no_2');
        $request->session()->forget('insurance_company_2');
        $request->session()->forget('vehicle_no_2');
        $request->session()->forget('model_2');
        $request->session()->forget('vat_number');
        $request->session()->forget('net_amount');
        $request->session()->forget('vat');
        $request->session()->forget('nbt');
        $request->session()->forget('cash_discount');
        $request->session()->forget('invoice_date');
        $request->session()->forget('paid_balance');
        $request->session()->forget('balance');

         // Fetch selected quotation using quotation id
         $invoice = DB::table('invoice')
         ->select('*')
         ->join('customer', 'invoice.customer_id', '=', 'customer.customer_id', 'inner')
         ->where('invoice_id', '=', $invoice_id)
         ->first();

         session()->put([
            'invoice_id' => $invoice->invoice_id,
            'customer_name_2' => $invoice->customer_name,
            'customer_id_2' => $invoice->customer_id,
            'contact_no_2' => $invoice->contact_no,
            'insurance_company_2' => $invoice->insurance_company,
            'vehicle_no_2' => $invoice->vehicle_no,
            'model_2' => $invoice->model,
            'vat_number' => $invoice->vat_number,
            'with_out_tax_amount' => $invoice->with_out_tax_amount,
            'cash_discount' => $invoice->cash_discount,
            'vat' => $invoice->vat,
            'nbt' => $invoice->nbt,
            'net_amount' => $invoice->net_amount,
            'paid_amount' => $invoice->paid_amount,
            'balance' => $invoice->balance,
            'invoice_date' => $invoice->invoice_date,
         ]);

        // Cart session
        $in_cart = session()->get('in_cart', []);

        // Select all item for related quotation using quotation table
        $invoice_item = DB::table('invoice_item')
        ->select('*')
        ->join('category', 'invoice_item.cat_id', '=', 'category.cat_id')
        ->join('products', 'invoice_item.p_id', '=', 'products.p_id')
        ->where('invoice_id', '=', $request->get('invoice_id'))
        ->get();

        foreach($invoice_item as $qti){
            $c_id = uniqid();
            if(empty($in_cart)){
                $in_cart = [
                    $c_id => [
                        'c_id' => $c_id,
                        'p_id' => $qti->p_id,
                        'item' => $qti->item,
                        'cat_id' => $qti->cat_id,
                        'category' => $qti->category,
                        'description' => $qti->item_description,
                        'qty' => $qti->qty,
                        'cost' => $qti->cost,
                        'rate' => $qti->rate,
                    ]
                ];

                session()->put('in_cart', $in_cart);
            } else{
                $in_cart[$c_id] = [
                    'c_id' => $c_id,
                    'p_id' => $qti->p_id,
                    'item' => $qti->item,
                    'cat_id' => $qti->cat_id,
                    'category' => $qti->category,
                    'description' => $qti->item_description,
                    'qty' => $qti->qty,
                    'cost' => $qti->cost,
                    'rate' => $qti->rate,
                ];

                session()->put('in_cart', $in_cart);
            }
        }

        $payment = DB::table('payment')
        ->select('*')
        ->where('invoice_id', '=', $request->get('invoice_id'))
        ->get();

        return redirect()->back()->with('payment', $payment);
    }
}
