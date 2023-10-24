@extends('layouts.master')

@section('title', 'Quotation')

@section('content')
    <div class="">
        <div class="flex items-center justify-start space-x-3">
            <a type="button" id="dropdownDefaultButton" data-dropdown-toggle="dropdown" class="p-1 text-sm text-bg-gray-600 w-[15%] flex font-medium border-b-2 border-t-0 border-s-0 border-e-0 border-2 border-navy-blue-300 cursor-pointer hover:bg-gray-200 rounded-md">
                <span class="flex-1">File</span>
                <i class="bi bi-chevron-down"></i>
            </a>
            <!-- Dropdown menu -->
            <div id="dropdown" class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li>
                        <a href="{{ route('quotation.empty-cart') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">New</a>
                    </li>
                    {{-- <li>
                        <a type="button" id="jobDoneBtn" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Pending/Done</a>
                    </li> --}}
                </ul>
            </div>
            <h1 class="text-2xl font-thin text-gray-900">/&nbsp;Create Quotation</h1>
        </div>
        <div class="mt-3 border-0 border-t-4 border-t-navy-blue-300 py-3 px-3 shadow-md bg-white rounded-md">
            <div class="flex">
                <div class="flex-auto w-80 px-3">
                    <form action="{{ route('quotation.add-cart') }}" method="post">
                        @csrf
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div class="flex items-center justify-between">
                                <label for="quotation_id" class="text-sm font-medium">Quotation No</label>
                                <div>
                                    <input type="text" name="quotation_id" id="quotation_id" class="p-1 border-none bg-gray-500/50 rounded-md font-bold text-center" value="@php if(session('quotation_id')){ echo session('quotation_id');}else{echo $quotation_id ;} @endphp">
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="quotation_date" class="text-sm font-medium">Date <span class="text-red-600">*</span></label>
                                    <div>
                                        <input type="date" name="quotation_date" id="quotation_date" class="p-1 border border-gray-400 rounded-md" value="@php if(session('quotation_date')){ echo session('quotation_date');}else{ echo ''; } @endphp" required>
                                        <br>
                                        <span class="text-sm font-normal text-red-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div class="flex items-center justify-between">
                                <label for="customer_name" class="text-sm font-medium">Customer <span class="text-red-600">*</span></label>
                                <div>
                                    <input type="hidden" name="customer_id" id="customer_id" value="@php if(session('customer_id')){ echo session('customer_id');}else{ echo ''; } @endphp">
                                    <input type="text" name="customer_name" id="customer_name" class="p-1 border border-gray-400 rounded-md" value="@php if(session('customer_name')){ echo session('customer_name');}else{ echo ''; } @endphp" required>
                                    <br>
                                    <span class="text-sm font-normal text-red-600"></span>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="contact_no" class="text-sm font-medium">Contact <span class="text-red-600">*</span></label>
                                    <div>
                                        <input type="tel" name="contact_no" id="contact_no" class="p-1 border border-gray-400 rounded-md" value="@php if(session('contact_no')){ echo session('contact_no');}else{ echo ''; } @endphp" required>
                                        <br>
                                        <span class="text-sm font-normal text-red-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div class="flex items-center justify-start space-x-3">
                                <label for="insurance_company" class="text-sm font-medium w-[228px]">Insurance Company</label>
                                <div class="w-full">
                                    <input type="text" name="insurance_company" id="insurance_company" class="p-1 border border-gray-400 rounded-md w-full" value="@php if(session('insurance_company')){ echo session('insurance_company');}else{ echo ''; } @endphp">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="vehicle_no" class="text-sm font-medium">Vehicle No <span class="text-red-600">*</span></label>
                                    <div>
                                        <input type="text" name="vehicle_no" id="vehicle_no" class="p-1 border border-gray-400 rounded-md" value="@php if(session('vehicle_no')){ echo session('vehicle_no');}else{ echo ''; } @endphp" required>
                                        <br>
                                        <span class="text-sm font-normal text-red-600"></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="meter_reading" class="text-sm font-medium">Meter Reading</label>
                                    <div>
                                        <input type="text" name="meter_reading" id="meter_reading" class="p-1 border border-gray-400 rounded-md" value="@php if(session('meter_reading')){ echo session('meter_reading');}else{ echo ''; } @endphp">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="year" class="text-sm font-medium">Year</label>
                                    <div>
                                        <input type="text" name="year" id="Year" class="p-1 border border-gray-400 rounded-md" value="@php if(session('year')){ echo session('year');}else{ echo ''; } @endphp">
                                        <br>
                                        <span class="text-sm font-normal text-red-600"></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="model" class="text-sm font-medium">Make/Model</label>
                                    <div>
                                        <input type="text" name="model" id="model" class="p-1 border border-gray-400 rounded-md" value="@php if(session('model')){ echo session('model');}else{ echo ''; } @endphp">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="chasis_no" class="text-sm font-medium">Chasis No</label>
                                    <div>
                                        <input type="text" name="chasis_no" id="chasis_no" class="p-1 border border-gray-400 rounded-md" value="@php if(session('chasis_no')){ echo session('chasis_no');}else{ echo ''; } @endphp">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="engine_no" class="text-sm font-medium">Engine No</label>
                                    <div>
                                        <input type="text" name="engine_no" id="engine_no" class="p-1 border border-gray-400 rounded-md" value="@php if(session('engine_no')){ echo session('engine_no');}else{ echo ''; } @endphp">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="color" class="text-sm font-medium">Color</label>
                                    <div>
                                        <input type="text" name="color" id="color" class="p-1 border border-gray-400 rounded-md" value="@php if(session('color')){ echo session('color');}else{ echo ''; } @endphp">
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="remarks" class="text-sm font-medium">Remarks</label>
                                    <div>
                                        <input type="text" name="remarks" id="remarks" class="p-1 border border-gray-400 rounded-md" value="@php if(session('remarks')){ echo session('remarks');}else{ echo ''; } @endphp">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-5 gap-0 relative">
                            <input type="hidden" name="p_id" id="p_id" value="">
                            <div class="col-span-2 px-1">
                                <label for="item" class="text-sm font-medium w-full">Item</label>
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="p_id" id="p_id_2" value="">
                                <input type="text" name="item" id="item" class="p-1 rounded-md border border-gray-500 w-full" value="">
                                <div id="item-drop-box" class="absolute left-1 bg-white w-full shadow-sm z-10"></div>
                            </div>
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
                                <label for="amount" class="text-sm font-medium w-full">Amount</label>
                                <input type="text" name="amount" id="amount" class="p-1 rounded-md border border-gray-500 w-full" value="">
                            </div>
                            <div class="px-1">
                                <label for="amount2" class="text-sm font-medium w-full">Amount2</label>
                                <input type="text" name="amount2" id="amount2" class="p-1 rounded-md border border-gray-500 w-full" value="">
                            </div>
                        </div>
                        <div class="grid grid-cols-4 gap-0">
                            <div class="col-span-2 px-1">
                                <label for="supp_type" class="text-sm font-medium w-full">Supplimentry Select </label>
                                <select name="supp_type" id="supp_type" class="p-1 rounded-md border border-gray-500 w-full">
                                    <option value=""></option>
                                    <option value="Estimated">Estimated</option>
                                    <option value="Supplimentry Quotation">Supplimentry Quotation</option>
                                </select>
                            </div>
                            <div class="px-1">
                                <label for="hours" class="text-sm font-medium w-full">Hours</label>
                                <input type="text" name="hours" id="hours" class="p-1 rounded-md border border-gray-500 w-full" value="">
                            </div>
                            <div class="px-1">
                                <button type="submit" name="addcart" value="Add Here" class="p-2 mt-6 rounded-md text-white font-medium bg-navy-blue-400 hover:bg-navy-blue-300 w-full text-sm">Add Here</button>
                            </div>
                        </div>
                    </form>
                    <div class="w-full h-[400px] overflow-scroll mt-3">
                        <table id="etitableTable" class="w-full border border-gray-400 text-xs table">
                            <thead>
                                <th class="p-1 border border-gray-400">Hours</th>
                                <th class="p-1 border border-gray-400">Description</th>
                                <th class="p-1 border border-gray-400">Amount</th>
                                <th class="p-1 border border-gray-400">Category</th>
                                <th class="p-1 border border-gray-400">Item No</th>
                                <th class="p-1 border border-gray-400">Supp</th>
                            </thead>
                            <tbody class="font-medium">
                                @if (session('cart'))
                                    @php
                                        $x = 0;
                                    @endphp
                                    @foreach (session('cart') as $cart)
                                        @php
                                            $x++;
                                        @endphp
                                        <tr>
                                            <td class="p-1 border border-gray-400 text-center">
                                                <a href="{{ route('quotation.remove', $cart['c_id']) }}" id="deleteCartItem" class="text-gray-500 hover:text-navy-blue-300"><i class="bi bi-trash"></i></a>
                                            </td>
                                            <td class="p-1 border border-gray-400 itemNo text-center">{{ $cart['hours'] }}</td>
                                            <td class="p-1 border border-gray-400 item">{{ $cart['item'] }}</td>
                                            <td class="p-1 border border-gray-400 amount text-right">{{ number_format($cart['amount'], 2) }}</td>
                                            <td class="p-1 border border-gray-400 catId">{{ $cart['category'] }}</td>
                                            <td class="p-1 border border-gray-400 text-center"></td>
                                            <td class="p-1 border border-gray-400 suppType text-center">{{ $cart['supp_type'] }}</td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex-none w-80 bg-white">
                    <div class="px-3 py-2">
                        <form action="{{ route('quotation.edit-quotation') }}" method="post">
                            @csrf
                            <h5 class="font-bold text-sm">Quotation No</h5>
                            <input type="text" name="quotation_id" id="quotation_id" class="rounded-md p-1 bg-green-500 w-full font-bold text-lg" value="">
                        </form>
                    </div>
                    <div class="px-3 py-3 mt-3">
                        <form action="{{ route('quotation.relatedQuotation') }}" method="post">
                            @csrf
                            <h5 class="font-bold text-sm">Vehicle No</h5>
                            <input type="text" name="vehicle_no" id="vehicle_no" class="rounded-md p-1 bg-green-500 w-full font-bold text-lg uppercase" value="">
                        </form>
                        <div class="w-full overflow-scroll h-[150px]">
                            <table class="mt-3 border border-gray-300 w-full font-medium">
                                <thead>
                                    <th class="border border-gray-400 text-center text-sm">ID</th>
                                    <th class="border border-gray-400 text-center text-sm">Quotation No</th>
                                </thead>
                                <tbody>
                                    @if (session()->get('quotation'))
                                    @php
                                        $x = 0;
                                    @endphp
                                        @foreach (session()->get('quotation') as $qtId)
                                            @php
                                                $x++;
                                            @endphp
                                            <tr class="cursor-pointer hover:bg-gray-400" onclick="getThisId(JSON.parse('{{ $qtId->quotation_id }}'))">
                                                <td class="border border-gray-500 p-1 text-center text-sm">
                                                    {{ $x }}
                                                    <form action="" method="post">
                                                        <input type="hidden" name="_token" id="_token_2" value="{{ csrf_token() }}">
                                                        <input type="hidden" id="q_id_{{ $qtId->quotation_id }}" value="{{ $qtId->quotation_id }}">
                                                    </form>
                                                </td>
                                                <td class="border p-1 border-gray-500 text-sm">{{ 'QOU/ABS/'.$qtId->quotation_id }}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        @if (session('cart'))
                            @php
                                $total = 0;
                            @endphp
                            @foreach (session('cart') as $cart)
                                @php
                                    $total += $cart['amount'];
                                @endphp
                            @endforeach
                            <h2 class="text-center font-bold text-lg mt-2">Amount</h2>
                            <h2 class="mt-4 text-center font-bold text-lg">{{ number_format($total, 2) }}</h2>
                        @else
                            <h2 class="text-center font-bold text-lg mt-2">Amount</h2>
                            <h2 class="mt-4 text-center font-bold text-lg">0.00</h2>
                        @endif
                        <div class="mt-2 w-full">
                            <h6 class="font-medium mb-2 text-sm">Select here to print quotation</h6>
                            <form action="" method="get">
                                @csrf
                                <select name="print_type" id="print_type" class="p-1 rounded-md border border-gray-500 mb-2 w-full">
                                    <option value="Letter_head">Letter Head</option>
                                    <option value="Normal">Normal</option>
                                    <option value="Supplimentry">Supplimentry</option>
                                    <option value="Quotation">Quotation</option>
                                </select>
                                <input type="hidden" name="quotation_id" id="quotation_id_3" value="@php if(session('quotation_id')){ echo session('quotation_id');}else{echo $quotation_id ;} @endphp">
                                <button type="submit" name="print" value="print" class="p-2 rounded-md w-full text-gray-500 hover:text-white hover:bg-gray-500 border border-gray-500 border-1 font-medium"><i class="bi bi-printer-fill"></i>&nbsp;Print</button>
                            </form>
                            <form action="{{ route('quotation.store') }}" method="post" class="mt-2">
                                @csrf
                                <input type="hidden" name="quotation_id" id="quotation_id_4" value="@php if(session('quotation_id')){ echo session('quotation_id');}else{echo $quotation_id ;} @endphp">
                                <input type="hidden" name="customer_name" id="customer_name_1" value="@php if(session('customer_name')){ echo session('customer_name');}else{ echo ''; } @endphp">
                                <input type="hidden" name="contact_no" id="contact_no_1" value="@php if(session('contact_no')){ echo session('contact_no');}else{ echo ''; } @endphp">
                                <input type="hidden" name="year" id="year_1" value="@php if(session('year')){ echo session('year');}else{ echo ''; } @endphp">
                                <input type="hidden" name="vehicle_no" id="vehicle_no_1" value="@php if(session('vehicle_no')){ echo session('vehicle_no');}else{ echo ''; } @endphp">
                                <input type="hidden" name="insurance_company" id="insurance_company_1" value="@php if(session('insurance_company')){ echo session('insurance_company');}else{ echo ''; } @endphp">
                                <input type="hidden" name="chasis_no" id="chasis_no_1" value="@php if(session('chasis_no')){ echo session('chasis_no');}else{ echo ''; } @endphp">
                                <input type="hidden" name="color" id="color_1" value="@php if(session('color')){ echo session('color');}else{ echo ''; } @endphp">
                                <input type="hidden" name="meter_reading" id="meter_reading_1" value="@php if(session('meter_reading')){ echo session('meter_reading');}else{ echo ''; } @endphp">
                                <input type="hidden" name="model" id="model_1" value="@php if(session('model')){ echo session('model');}else{ echo ''; } @endphp">
                                <input type="hidden" name="engine_no" id="engine_no_1" value="@php if(session('engine_no')){ echo session('engine_no');}else{ echo ''; } @endphp">
                                <input type="hidden" name="remarks" id="remarks_1" value="@php if(session('remarks')){ echo session('remarks');}else{ echo ''; } @endphp">
                                <input type="hidden" name="quotation_date" id="quotation_date_1" value="@php if(session('quotation_date')){ echo session('quotation_date');}else{ echo ''; } @endphp">
                                @if(session('cart'))
                                    @foreach (session('cart') as $cart)
                                        <input type="hidden" name="p_id" id="p_id_1" value="{{ $cart['p_id'] }}">
                                        <input type="hidden" name="item" id="item_1" value="{{ $cart['item'] }}">
                                        <input type="hidden" name="cat_id" id="cat_id_1" value="{{ $cart['cat_id'] }}">
                                        <input type="hidden" name="amount" id="amount_1" value="{{ $cart['amount'] }}">
                                        <input type="hidden" name="amount2" id="amount_2" value="{{ $cart['amount2'] }}">
                                        <input type="hidden" name="hours" id="hours_2" value="{{ $cart['amount2'] }}">
                                        <input type="hidden" name="supp_type" id="supp_type_2" value="{{ $cart['amount2'] }}">
                                    @endforeach
                                @endif
                                <button type="submit" name="save" value="Save" class="p-2 rounded-md w-full text-white bg-green-600 hover:bg-green-400 font-medium"><i class="bi bi-floppy-fill"></i>&nbsp;Save</button>
                            </form>
                            {{-- <form action="" method="post" class="mt-2">
                                @csrf
                                <button type="submit" name="update" value="Update" class="p-2 rounded-md w-full text-white bg-green-600 hover:bg-green-400 font-medium"><i class="bi bi-pencil-square"></i>&nbsp;Edit</button>
                            </form> --}}
                            <div class="mt-6 w-full">
                                <a type="button" id="@php if(session('quotation_id')){ echo session('quotation_id');}else{echo $quotation_id ;} @endphp" class="mt-5 w-full rounded-md p-2 text-white bg-red-600 flex justify-center font-medium delete-quotation cursor-pointer"><i class="bi bi-trash-fill"></i>&nbsp;Delete </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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

    <script src="{{ asset('js/SimpleTableCellEditor.es6.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/quotationTableEditor.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/search-item.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/delete-cart-item.js') }}" type="text/javascript"></script>
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
                        data: 'quotation_id='+id,
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
