@extends('layouts.master')

@section('title', 'Invoice')

@section('content')
    <div>
        <div class="flex items-center justify-start space-x-3">
            <a type="button" id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="p-1 text-sm text-bg-gray-600 w-[15%] flex font-medium border-b-2 border-t-0 border-s-0 border-e-0 border-2 border-navy-blue-300 cursor-pointer hover:bg-gray-200 rounded-md">
                <span class="flex-1">File</span>
                <i class="bi bi-chevron-down"></i>
            </a>
            <!-- Dropdown menu -->
            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <a href="{{ route('invoice.new') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">New</a>
                    </li>
                    {{-- <li>
                        <a type="button" id="jobDoneBtn" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Pending/Done</a>
                    </li> --}}
                </ul>
            </div>
            <h1 class="text-2xl font-thin text-gray-900">/&nbsp;Create Invoice</h1>
        </div>
        <div class="px-2 py-2 w-full">
            @if (session('success'))
                <div id="alert-3" class="flex items-center p-4 mb-4 text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ml-3 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-green-50 text-green-500 rounded-lg focus:ring-2 focus:ring-green-400 p-1.5 hover:bg-green-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-green-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-3" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div id="alert-2" class="flex items-center p-4 mb-4 text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                    <svg class="flex-shrink-0 w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                    </svg>
                    <span class="sr-only">Info</span>
                    <div class="ml-3 text-sm font-medium">
                       {{ session('error') }}
                    </div>
                    <button type="button" class="ml-auto -mx-1.5 -my-1.5 bg-red-50 text-red-500 rounded-lg focus:ring-2 focus:ring-red-400 p-1.5 hover:bg-red-200 inline-flex items-center justify-center h-8 w-8 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-gray-700" data-dismiss-target="#alert-2" aria-label="Close">
                        <span class="sr-only">Close</span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>
        <div class="mt-3 border-0 border-t-4 border-t-navy-blue-300 py-3 px-3 shadow-md bg-white rounded-md">
            <div class="flex">
                <div class="flex-auto w-80 px-3">
                    <form action="{{ route('invoice.add-to-cart') }}" method="post">
                        @csrf
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div class="flex items-center justify-between">
                                <label for="invoice_id" class="text-sm font-medium">Invoice No</label>
                                <div>
                                    <input type="text" name="invoice_id" id="invoice_id" class="p-1 border-none bg-gray-500/50 rounded-md font-bold text-center" value="@php if(session('invoice_id')){ echo session('invoice_id');}else{echo $invoice_id ;} @endphp">
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <label for="invoice_date" class="text-sm font-medium">Date <span class="text-red-600">*</span></label>
                                <div>
                                    <input type="date" name="invoice_date" id="invoice_date" class="p-1 border border-gray-400 rounded-md" value="@php if(session('invoice_date')){ echo session('invoice_date');}else{ echo ''; } @endphp" required>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3 relative">
                            <div class="flex items-center justify-between">
                                <label for="customer_name" class="text-sm font-medium">Customer <span class="text-red-600">*</span></label>
                                <div>
                                    <input type="hidden" name="_token_2" id="_token_2" value="{{ csrf_token() }}">
                                    <input type="hidden" name="customer_id" id="customer_id" value="@php if(session('customer_id_2')){ echo session('customer_id_2');}else{ echo ''; } @endphp">
                                    <input type="text" name="customer_name" id="customer_name" class="p-1 border border-gray-400 rounded-md" value="@php if(session('customer_name_2')){ echo session('customer_name_2');}else{ echo ''; } @endphp" required>
                                    <div id="cus-drop-box" class="absolute left-1 bg-white w-full shadow-sm z-10"></div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <label for="contact_no" class="text-sm font-medium">Contact <span class="text-red-600">*</span></label>
                                <div>
                                    <input type="tel" name="contact_no" id="contact_no" class="p-1 border border-gray-400 rounded-md" value="@php if(session('contact_no_2')){ echo session('contact_no_2');}else{ echo ''; } @endphp" required>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div class="flex items-center justify-start space-x-3">
                                <label for="insurance_company" class="text-sm font-medium w-[228px]">Insurance Company</label>
                                <div class="w-full">
                                    <input type="text" name="insurance_company" id="insurance_company" class="p-1 border border-gray-400 rounded-md w-full" value="@php if(session('insurance_company_2')){ echo session('insurance_company_2');}else{ echo ''; } @endphp">
                                </div>
                            </div>
                            <div class="flex items-center justify-start space-x-3">
                                <label for="vat_number" class="text-sm font-medium w-[228px]">Vat Number</label>
                                <div class="w-full">
                                    <input type="text" name="vat_number" id="vat_number" class="p-1 border border-gray-400 rounded-md w-full" value="@php if(session('vat_number')){ echo session('vat_number');}else{ echo ''; } @endphp">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div class="flex items-center justify-between">
                                <label for="vehicle_no" class="text-sm font-medium">Vehicle No <span class="text-red-600">*</span></label>
                                <div>
                                    <input type="text" name="vehicle_no" id="vehicle_no" class="p-1 border border-gray-400 rounded-md uppercase" value="@php if(session('vehicle_no_2')){ echo session('vehicle_no_2');}else{ echo ''; } @endphp">
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <label for="model" class="text-sm font-medium">Make/Model</label>
                                <div>
                                    <input type="text" name="model" id="model" class="p-1 border border-gray-400 rounded-md" value="@php if(session('model_2')){ echo session('model_2');}else{ echo ''; } @endphp">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div class="flex justify-between">
                                <label for="quotation_id" class="text-sm font-medium">Quotation No</label>
                                <div>
                                    <input type="text" name="quotation_id" id="quotation_id" class="p-1 border border-gray-400 rounded-md w-full mb-2" value="">
                                    <button type="button" id="findQuotation" class="p-2 w-full rounded-md bg-gray-300 text-gray-800 font-medium text-sm hover:bg-gray-500 hover:text-white">Get</button>
                                </div>
                            </div>
                            <div class="flex justify-between">
                                <label for="job_id" class="text-sm font-medium">Job No</label>
                                <div>
                                    <input type="text" name="job_id" id="job_id" class="p-1 border border-gray-400 rounded-md w-full mb-1" value="">
                                    <button type="button" id="findJob" class="p-2 w-full rounded-md bg-gray-300 text-gray-800 font-medium text-sm hover:bg-gray-500 hover:text-white">Get</button>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-5 gap-0 relative">
                            <div class="px-1">
                                <label for="p_id" class="text-sm font-medium w-full">Code</label>
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <input type="text" name="p_id" id="p_id" class="p-1 rounded-md border border-gray-500 w-full" value="">
                            </div>
                            <div class="col-span-2 px-1">
                                <label for="item" class="text-sm font-medium w-full">Item</label>
                                <input type="text" name="item" id="item" class="p-1 rounded-md border border-gray-500 w-full" value="">
                                <div id="item-drop-box" class="absolute left-1 bg-white w-full shadow-sm z-10"></div>
                            </div>
                            <div class="px-1 col-span-2">
                                <label for="description" class="text-sm font-medium w-full">Description</label>
                                <input type="text" name="description" id="description" class="p-1 rounded-md border border-gray-400 w-full" value="">
                            </div>
                        </div>
                        <div class="grid grid-cols-5 gap-0">
                            <div class="px-1">
                                <label for="cat_id" class="text-sm font-medium w-full">Category</label>
                                <select name="cat_id" id="cat_id" class="p-1 rounded-md border border-gray-500 w-full">
                                    <option value=""></option>
                                    @foreach ($category as $cat)
                                        <option value="{{ $cat->cat_id }}">{{ $cat->category }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="px-1">
                                <label for="hours" class="text-sm font-medium w-full">Qty</label>
                                <input type="number" name="qty" id="qty" class="p-1 rounded-md border border-gray-500 w-full" value="">
                            </div>
                            <div class="px-1">
                                <label for="cost" class="text-sm font-medium w-full">Cost</label>
                                <input type="text" name="cost" id="cost" class="p-1 rounded-md border border-gray-500 w-full" value="">
                            </div>
                            <div class="px-1">
                                <label for="rate" class="text-sm font-medium w-full">Rate</label>
                                <input type="text" name="rate" id="rate" class="p-1 rounded-md border border-gray-500 w-full" value="">
                            </div>
                            <div class="px-1">
                                <button type="submit" name="addcart" value="Add Here" class="p-1 mt-6 rounded-md text-white font-medium bg-navy-blue-500 hover:bg-navy-blue-400 w-full">Add</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="flex-none w-80 px-3">
                    @php
                        $sum_of_cart = $net_amount = $balance = 0;
                    @endphp
                    @if (session('in_cart'))
                        @foreach (session('in_cart') as $incart)
                            @php
                                $sum_of_cart += $incart['rate'] * $incart['qty'];
                                $net_amount = session()->put(['net_amount' => $sum_of_cart]);
                                $balance = session()->put(['balance' => session()->get('net_amount')]);

                            @endphp
                        @endforeach
                    @endif
                    <div class="flex items-center justify-between">
                        <h6 class="font-medium text-sm">Without Tax</h6>
                        <h6 class="font-medium text-sm">{{ number_format($sum_of_cart, 2) }}</h6>

                    </div>
                    <div class="flex items-center justify-between">
                        <h6 class="font-medium text-sm">Net Total</h6>
                        <h6 class="font-medium text-sm">@php if(session('net_amount')){ echo number_format(session('net_amount'), 2);}else{ echo '0.00'; } @endphp</h6>
                    </div>
                    <div class="flex items-center justify-between">
                        <h6 class="font-medium text-sm">Paid Amount</h6>
                        <h6 class="font-medium text-sm">@php if(session('paid_amount')){ echo number_format(session('paid_amount'), 2);}else{ echo '0.00'; } @endphp</h6>
                    </div>
                    <div class="flex items-center justify-between">
                        <h6 class="font-medium text-sm">Balance</h6>
                        <h6 class="font-medium text-sm">@php if(session('balance')){ echo number_format(session('balance'), 2);}else{ echo '0.00'; } @endphp</h6>
                    </div>
                    <div class="w-full mt-3">
                        <h6 class="font-medium text-lg mb-3">Find Invoice Using</h6>
                        <div class="w-full">
                            <div class="mb-3 w-full">
                                <form action="{{ route('invoice.edit') }}" method="post">
                                    @csrf
                                    <input type="text" name="invoice_id" id="invoice_id_2" class="bg-green-500 rounded-md p-2 w-full font-medium placeholder:text-gray-800" value="" placeholder="Invoice No">
                                </form>
                            </div>
                            <div class="mb-3 w-full">
                                <form action="{{ route('invoice.invoice-by-vehicle') }}" method="post">
                                    @csrf
                                    <input type="text" name="vehicle_no" id="vehicle_no_2" class="bg-green-500 uppercase rounded-md p-2 w-full font-medium placeholder:text-gray-800 placeholder:lowercase" value="" placeholder="Vehicle No">
                                </form>
                            </div>
                            <div class="mb-3 w-full">
                                <form action="{{ route('invoice.invoice-by-customer') }}" method="post">
                                    @csrf
                                    <input type="text" name="customer_name" id="customer_name_2" class="bg-green-500 rounded-md p-2 w-full font-medium placeholder:text-gray-800" value="" placeholder="Customer Name">
                                </form>
                            </div>
                        </div>
                        <div class="w-full h-[100px] overflow-scroll">
                            <table class="w-full border border-gray-400">
                                <thead>
                                    <th class="p-1 text-xs border border-gray-400 text-center">ID</th>
                                    <th class="p-1 text-xs border border-gray-400 text-center">Invoice No</th>
                                </thead>
                                <tbody>
                                    @if (session()->get('invoice'))
                                        @php
                                            $x = 0;
                                        @endphp
                                        @foreach (session()->get('invoice') as $inv)
                                            @php
                                                $x++;
                                            @endphp
                                            <tr class="hover:bg-gray-300 cursor-pointer" onclick="getThisId(JSON.parse('{{ $inv->invoice_id }}'))">
                                                <td>
                                                    {{ $x }}
                                                    <form action="" method="post">
                                                        <input type="hidden" name="_token" id="_token_2" value="{{ csrf_token() }}">
                                                        <input type="hidden" id="q_id_{{ $inv->invoice_id }}" value="{{ $inv->invoice_id }}">
                                                    </form>
                                                </td>
                                                <td class="border border-gray-400 text-xs">{{ 'ABS/INV/'.$inv->invoice_id }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
                    <div class="w-full h-[250px] overflow-scroll mt-3 bg-white px-3 py-3">
                        <table id="etitableTable" class="w-full border border-gray-400 text-xs table">
                            <thead>
                                <th></th>
                                <th class="p-1 border border-gray-400 w-[5%]">Item No</th>
                                <th class="p-1 border border-gray-400 w-[10%]">Code</th>
                                <th class="p-1 border border-gray-400">Item</th>
                                <th class="p-1 border border-gray-400">Description</th>
                                <th class="p-1 border border-gray-400">Qty</th>
                                <th class="p-1 border border-gray-400">Rate</th>
                                <th class="p-1 border border-gray-400">Total</th>
                            </thead>
                            <tbody class="font-medium">
                                @if (session('in_cart'))
                                    @php
                                        $x = 0;
                                        $total = 0;
                                    @endphp
                                    @foreach (session('in_cart') as $incart)
                                        @php
                                            $x++;
                                            $total = $incart['rate'] * $incart['qty'];
                                        @endphp
                                        <tr>
                                            <td class="p-1 border border-gray-400 text-center">
                                                <a href="{{ route('invoice.remove-cart-item', $incart['c_id']) }}" id="deleteCartItem" class="text-gray-500 hover:text-navy-blue-300"><i class="bi bi-trash"></i></a>
                                            </td>
                                            <td class="p-1 border border-gray-400 itemNo text-center"></td>
                                            <td class="p-1 border border-gray-400 pId text-center">{{ $incart['p_id'] }}</td>
                                            <td class="p-1 border border-gray-400 item">{{ $incart['item'] }}</td>
                                            <td class="p-1 border border-gray-400 Des">{{ $incart['description'] }}</td>
                                            <td class="p-1 border border-gray-400 qty text-center"></td>
                                            <td class="p-1 border border-gray-400 rate text-right">{{ number_format($incart['rate'], 2) }}</td>
                                            <td class="p-1 border border-gray-400 text-right">{{ number_format($total, 2) }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <div class="grid grid-cols-5 gap-0 bg-white">
                        <div class="px-3 py-3 col-span-2">
                            <form action="{{ route('invoice.calculater') }}" method="post">
                                @csrf
                                <div class="flex items-center justify-between mb-3">
                                    <label for="cash_discount" class="font-medium text-sm">Cash Discount</label>
                                    <div>
                                        <input type="text" name="cash_discount" id="cash_discount" class="rounded-md p-1 border border-gray-500" value="">
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-3">
                                    <label for="nbt" class="font-medium text-sm">NBT 2%</label>
                                    <div>
                                        <input type="text" name="nbt" id="nbt" class="rounded-md p-1 border border-gray-500" value="">
                                    </div>
                                </div>
                                <div class="flex items-center justify-between mb-3">
                                    <label for="vat" class="font-medium text-sm">VAT 15%</label>
                                    <div>
                                        <input type="text" name="vat" id="vat" class="rounded-md p-1 border border-gray-500" value="">
                                    </div>
                                </div>
                                <button type="submit" name="cal">Calculate</button>
                            </form>
                        </div>
                        <div class="col-span-3 px-3 py-3">
                            <div class="grid grid-cols-4 gap-2 mt-10">
                                <div class="flex items-center justify-center">
                                    <a type="button" id="openPayModel" class="p-2 text-white font-medium rounded-md text-center w-full cursor-pointer bg-purple-700 hover:bg-purple-600"><i class="bi bi-print"></i>&nbsp;Pay Here</a>
                                </div>
                                <div>
                                    <form action="{{ route('invoice.store') }}" method="post">
                                        @csrf
                                        <input type="hidden" name="invoice_id" id="invoice_id_4" value="@php if(session('invoice_id')){ echo session('invoice_id');}else{echo $invoice_id ;} @endphp">
                                        <input type="hidden" name="customer_name" id="customer_name_1" value="@php if(session('customer_name_2')){ echo session('customer_name_2');}else{ echo ''; } @endphp">
                                        <input type="hidden" name="contact_no" id="contact_no_1" value="@php if(session('contact_no_2')){ echo session('contact_no_2');}else{ echo ''; } @endphp">
                                        <input type="hidden" name="vehicle_no" id="vehicle_no_1" value="@php if(session('vehicle_no_2')){ echo session('vehicle_no_2');}else{ echo ''; } @endphp">
                                        <input type="hidden" name="insurance_company" id="insurance_company_1" value="@php if(session('insurance_company_2')){ echo session('insurance_company_2');}else{ echo ''; } @endphp">
                                        <input type="hidden" name="vat_number" id="vat_number_1" value="@php if(session('vat_number')){ echo session('vat_number');}else{ echo ''; } @endphp">
                                        <input type="hidden" name="model" id="model_1" value="@php if(session('model_2')){ echo session('model_2');}else{ echo ''; } @endphp">
                                        <input type="hidden" name="invoice_date" id="invoice_date_1" value="@php if(session('invoice_date')){ echo session('invoice_date');}else{ echo ''; } @endphp">
                                        @if(session('in_cart'))
                                            @php
                                                $sum_of_total = 0;
                                            @endphp
                                            @foreach (session('in_cart') as $incart)
                                                @php
                                                    $sum_of_total += $incart['rate'] * $incart['qty'];
                                                @endphp
                                                <input type="hidden" name="p_id" id="p_id_1" value="{{ $incart['p_id'] }}">
                                                <input type="hidden" name="item" id="item_1" value="{{ $incart['item'] }}">
                                                <input type="hidden" name="cat_id" id="cat_id_1" value="{{ $incart['cat_id'] }}">
                                                <input type="hidden" name="description" id="description_1" value="{{ $incart['description'] }}">
                                                <input type="hidden" name="qty" id="qty_1" value="{{ $incart['qty'] }}">
                                                <input type="hidden" name="cost" id="cost_2" value="{{ $incart['cost'] }}">
                                                <input type="hidden" name="rate" id="rate_2" value="{{ $incart['rate'] }}">
                                            @endforeach
                                            <input type="hidden" name="with_out_tax_amount" id="with_out_tax_amount_1" value="{{ $sum_of_total }}">
                                            <input type="hidden" name="net_amount" id="net_amount_1" value="@php if(session('net_amount')){ echo session('net_amount');}else{ echo ''; } @endphp">
                                            <input type="hidden" name="cash_discount" id="cash_discount_1" value="@php if(session('cash_discount')){ echo session('cash_discount');}else{ echo ''; } @endphp">
                                            <input type="hidden" name="vat" id="vat_1" value="@php if(session('vat')){ echo session('vat');}else{ echo ''; } @endphp">
                                            <input type="hidden" name="nbt" id="nbt_1" value="@php if(session('nbt')){ echo session('nbt');}else{ echo ''; } @endphp">
                                            <input type="hidden" name="paid_amount" id="paid_amount_1" value="@php if(session('paid_amount')){ echo session('paid_amount');}else{ echo ''; } @endphp">
                                            <input type="hidden" name="balance" id="balance_1" value="@php if(session('balance')){ echo session('balance');}else{ echo ''; } @endphp">
                                        @endif
                                        <button type="submit" name="save" value="Save" class="p-2 rounded-md bg-navy-blue-400 hover:bg-navy-blue-300 text-white font-medium w-full"><i class="bi bi-floppy-fill"></i>&nbsp;Save</button>
                                    </form>
                                </div>
                                <div class="flex items-center justify-center">
                                    <a href="" class="p-2 rounded-md text-white font-medium bg-red-600 hover:bg-red-500 w-full text-center"><i class="bi bi-printer"></i>&nbsp;Print</a>
                                </div>
                                <div class="flex items-center justify-center">
                                    <a type="button" id="@php if(session('invoice_id')){ echo session('invoice_id');}else{echo $invoice_id ;} @endphp" class="p-2 border border-gray-400 hover:bg-gray-500 text-gray-400 text-center hover:text-white text-sm font-medium rounded-md w-full delete-quotation"><i class="bi bi-trash"></i>&nbsp;Delete</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Payment model -->
    <div id="paymentModel" class="w-full top-0 left-0 bg-gray-800/50 h-screen fixed hidden">
        <div class="shadow-md bg-white w-[650px] m-auto mt-32 ml-[480px] h-auto rounded-md">
            <div class="bg-gray-100 text-gray-800 font-medium rounded-t-md py-3 px-3 flex items-center justify-between">
                <h6>Pay Here</h6>
                <button type="button" id="closeModel" class="text-lg"><i class="bi bi-x-lg"></i></button>
            </div>
            <div class="px-4 py-4">
                <form action="{{ route('invoice.pay') }}" method="post">
                    @csrf
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <input type="hidden" name="invoice_id" id="invoice_id_2" value="">
                        <div>
                            <label for="payment_date" class="font-medium text-sm w-full">Date <span class="text-red-600">*</span></label>
                            <input type="date" name="payment_date" id="payment_date" class="border border-gray-500 p-1 rounded-md w-full" value="" required>
                        </div>
                        <div>
                            <label for="account" class="font-medium text-sm w-full">Account</label>
                            <select name="account" id="account" class="w-full border border-gray-500 p-1 rounded-md" required>
                                <option value="Main Cash">Main Cash</option>
                                <option value="Pan Asia 204">Pan Asia 204</option>
                                <option value="Petty Cash">Petty Cash</option>
                            </select>
                        </div>
                        <div>
                            <button type="button" id="deletePayment" name="deletePayment" value="Delete" class="p-2 rounded-md bg-red-700 hover:bg-red-600 text-white font-medium text-sm w-full mt-5">Delete</button>
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <div>
                            <label for="payment_type" class="font-medium text-sm w-full">Type</label>
                            <select name="payment_type" id="payment_type" class="w-full border border-gray-500 p-1 rounded-md" required>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="Credit Card">Credit Card</option>
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="transaction_no" class="font-medium text-sm w-full">Cheque no/Card no/Transaction no/Bank</label>
                            <input type="text" name="transaction_no" id="transaction_no" class="border border-gray-500 p-1 rounded-md w-full" value="">
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 mb-3">
                        <div class="col-span-2">
                            <div class="flex items-center justify-between mt-5">
                                <label for="amount" class="font-medium text-sm w-full">Amount <span class="text-red-600">*</span></label>
                                <input type="hidden" name="invoiceAmount" id="invoice_amount" value="{{ session()->get('balance') }}">
                                <input type="text" name="amount" id="amount" class="border border-gray-500 p-1 rounded-md w-full" value="" required>
                            </div>
                        </div>
                        <div>
                            <button type="submit" id="addPayment" name="addPayment" value="Pay Here" class="p-2 rounded-md bg-green-600 hover:bg-green-400 text-white font-medium text-sm w-full mt-5">Pay Here</button>
                        </div>
                    </div>
                </form>
                <div class="mt-3 w-full overflow-scroll h-[150px]">
                    <table class="w-full border border-gray-500 text-sm font-medium">
                        <thead>
                            <th class="p-1 border border-gray-500">ID</th>
                            <th class="p-1 border border-gray-500">Payment Type</th>
                            <th class="p-1 border border-gray-500">Account</th>
                            <th class="p-1 border border-gray-500">Transaction No</th>
                            <th class="p-1 border border-gray-500">Amount</th>
                            <th class="p-1 border border-gray-500"">Payment Date</th>
                        </thead>
                        <tbody>
                            @if (session()->get('payment'))
                                @foreach (session()->get('payment') as $pay)
                                    <tr>
                                        <td class="p-1 border border-gray-500 text-center">{{ $pay->payment_id }}</td>
                                        <td class="p-1 border border-gray-500">{{ $pay->payment_type }}</td>
                                        <td class="p-1 border border-gray-500">{{ $pay->account }}</td>
                                        <td class="p-1 border border-gray-500">{{ $pay->transaction_no }}</td>
                                        <td class="p-1 border border-gray-500 text-right">{{ number_format($pay->amount, 2)}}</td>
                                        <td class="p-1 border border-gray-500">{{ $pay->payment_date }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- End Payment model -->

    {{--Confirm dialog--}}
    <div class="fixed w-full top-0 h-full left-0 close-dialog bg-gray-500/50" id="confirmDialog">
        <div class="shadow-md bg-white w-96 m-auto mt-36 h-28 rounded-md p-3">
            <p class="text-sm text-slate-500 mt-3">Are you sure to delete this record? This action can't be undo</p>
            <div class="flex justify-end">
                <button type="button" id="confirm" class="rounded-full bg-navy-blue-500 hover:bg-navy-blue-400 w-14 text-white text-sm me-3">Yes</button>
                <button type="button" id="cancel" class="rounded-full border border-gray-500 text-gray-500 hover:bg-gray-500 hover:text-white w-14">No</button>
            </div>
        </div>
    </div>
    {{--End confirm dialog--}}

    {{-- <script src="{{ asset('js/in-search-customer.js') }}" type="text/javascript"></script> --}}
    <script src="{{ asset('js/item-search.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/get-data-using-job-id.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/get-invoice.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#openPayModel').click(function() {
                $('#paymentModel').show();
            });

            $('#closeModel').click(function() {
                $('#paymentModel').hide();
            });
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Click delete button
            $('.delete-quotation').click(function() {
                // Get entry id after click delete button
                var id = $(this).attr('id');

                // Open confirm dialog
                $('#confirmDialog').show();

                // Path
                var url = 'delete/'+id;

                // Ajax action
                $('#confirm').click(function() {
                    $.ajax({
                        type: 'GET',
                        url: url,
                        data: 'invoice_id='+id,
                        success: function(data){
                            alert("Records delete successfully. Record ID:"+id);
                            location.reload();
                        },
                        error: function(data){
                            alert("Recods not delete. Try again");
                            location.reload();
                        }
                    });
                });

                // Close model
                $('#cancel').click(function() {
                    $('#confirmDialog').hide();
                });

            });
        });
    </script>
@endsection
