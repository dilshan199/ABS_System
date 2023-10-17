@extends('layouts.master')

@section('title', 'Item Register')

@section('content')
<h1 class="text-2xl font-thin text-gray-900">Item Register</h1>
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
<div class="mt-2 w-full h-auto flex">
    <div class="flex-auto w-80">
        <form action="{{ route('product.store') }}" method="post" class="grid grid-cols-2 gap-0">
            @csrf
            <div class="">
                <div class="flex items-center justify-between mb-3">
                    <label for="p_id" class="font-medium text-sm text-gray-900">Code</label>
                    <div>
                        <input type="text" name="p_id" id="p_id" class="p-4 rounded-md border border-gray-400 bg-gray-400 text-center font-bold" readonly value="{{ $p_id }}">
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="cat_id" class="font-medium text-sm text-gray-900">Category <span class="text-red-500">*</span></label>
                    <div>
                        <select name="cat_id" id="cat_id" class="p-1 rounded-md border border-gray-400 w-full">
                            <option value=""></option>
                            @foreach ($category as $cat)
                                <option value="{{ $cat->cat_id }}">{{ $cat->category }}</option>
                            @endforeach
                        </select>
                        <span class="text-sm font-normal text-red-600">{{ $errors->first('cat_id') }}</span>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="item" class="font-medium text-sm text-gray-900">Item <span class="text-red-500">*</span></label>
                    <div>
                        <input type="text" name="item" id="item" class="p-1 rounded-md border border-gray-400" value="">
                        <br>
                        <span class="text-sm font-normal text-red-600">{{ $errors->first('item')}}</span>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="department" class="font-medium text-sm text-gray-900">Department</label>
                    <div>
                        <input type="text" name="department" id="department" class="p-1 rounded-md border border-gray-400 " value="">
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="unit" class="font-medium text-sm text-gray-900">Unit</label>
                    <div>
                        <input type="text" name="unit" id="unit" class="p-1 rounded-md border border-gray-400" value="">
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="line_no" class="font-medium text-sm text-gray-900">Line No</label>
                    <div>
                        <input type="text" name="line_no" id="line_no" class="p-1 rounded-md border border-gray-400" value="">
                    </div>
                </div>
            </div>
            <div class="ps-2">
                <div class="flex items-center justify-between mb-3">
                    <label for="description" class="font-medium text-sm text-gray-900">Description</label>
                    <div>
                        <textarea name="description" id="description" cols="30" rows="2" class="p-1 rounded-md border border-gray-400"></textarea>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="cost" class="font-medium text-sm text-gray-900">Cost</label>
                    <div>
                        <input type="text" name="cost" id="cost" class="p-1 rounded-md border border-gray-400" value="">
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="selling_price" class="font-medium text-sm text-gray-900">Selling Price <span class="text-red-600">*</span></label>
                    <div>
                        <input type="text" name="selling_price" id="selling_price" class="p-1 rounded-md border border-gray-400" value="">
                        <br>
                        <span class="text-sm font-normal text-red-600">{{ $errors->first('selling_price') }}</span>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="rol" class="font-medium text-sm text-gray-900">ROL</label>
                    <div>
                        <input type="text" name="rol" id="rol" class="p-1 rounded-md border border-gray-400 " value="">
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="capacity" class="font-medium text-sm text-gray-900">Capacity</label>
                    <div>
                        <input type="text" name="capacity" id="capacity" class="p-1 rounded-md border border-gray-400 " value="">
                    </div>
                </div>
                <div class="flex items-center justify-between mb-3">
                    <label for="open_stock" class="font-medium text-sm text-gray-900">Open Stock</label>
                    <div>
                        <input type="text" name="open_stock" id="open_stock" class="p-1 rounded-md border border-gray-400 " value="">
                    </div>
                </div>
                <div class="flex justify-end px-2">
                    <button type="submit" name="submit" value="Submit" class="rounded-md bg-green-600 hover:bg-green-500 text-white font-medium w-full p-1 text-sm">Submit</button>
                </div>
            </div>
        </form>
    </div>
    <div class="w-80 flex-none px-4 py-2">
        <div class="bg-navy-blue-600/50 rounded-lg w-full px-4 py-4">
            <h5 class="mb-3 uppercase font-medium text-white text-center text-xl">Search Item Here</h5>
            <form action="{{ route('product.search') }}" method="post">
                @csrf
                <div class="w-full mb-4">
                    <input type="text" name="p_id" id="p_id" class="p-2 border border-gray-400 rounded-md w-full" placeholder="Type Code" value="">
                </div>
                <div class="w-full mb-4">
                    <input type="text" name="item" id="item" class="p-2 border border-gray-400 rounded-md w-full" placeholder="Type Item" value="">
                </div>
                <div class="w-full mb-4">
                    <input type="text" name="description" id="description" class="p-2 border border-gray-400 rounded-md w-full" placeholder="Type Description" value="">
                </div>
                <div class="w-full mb-4">
                    <button type="submit" name="submit" value="Search Item" class="bg-navy-blue-400 hover:bg-navy-blue-300 text-white font-medium rounded-md p-2 w-full"><i class="bi bi-search"></i>&nbsp;Search Item</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="w-full overflow-scroll h-[500px] bg-gray-100 mt-5 mb-4">
    <table class="w-full border border-gray-300">
        <thead class="text-center text-sm font-medium">
            <th class="border border-gray-300">Code</th>
            <th class="border border-gray-300">Item</th>
            <th class="border border-gray-300">Description</th>
            <th class="border border-gray-300">Cost</th>
            <th class="border border-gray-300">Selling Price</th>
            <th class="border border-gray-300">Action</th>
        </thead>
        <tbody class="text-sm">
            @foreach ($product as $pro)
                <tr>
                    <td class="border border-gray-300 text-center px-2 py-2">{{ $pro->p_id }}</td>
                    <td class="border border-gray-300">{{ $pro->item }}</td>
                    <td class="border border-gray-300 text-center">{{ $pro->description }}</td>
                    <td class="border border-gray-300 text-center">{{ $pro->cost }}</td>
                    <td class="border border-gray-300 text-center">{{ $pro->selling_price }}</td>
                    <td class="border border-gray-300 text-center">
                        <a href="javascript:void(0)" class="edit-button cursor-pointer px-1 py-1 text-blue-800" title="Edit" id="editButton" data-url="{{ route('product.edit', $pro->p_id) }}"><i class="bi bi-pencil-square"></i>&nbsp;Edit</a>
                        <a type="button" class="remove cursor-pointer px-1 py-1 text-blue-800" id="{{ $pro->p_id }}" title="Delete"><i class="bi bi-trash"></i>&nbsp;Delete</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{-- {{ $product->links()}} --}}

{{--Confirm dialog--}}
<div class="fixed w-full top-10 h-full left-0 close-dialog bg-gray-500/50 ml-28" id="confirmDialog">
    <div class="shadow-md bg-white w-96 m-auto mt-36 h-28 rounded-md p-3">
        <p class="text-sm text-slate-500 mt-3">Are you sure to delete this record? This action can't be undo</p>
        <div class="flex justify-end">
            <button type="button" id="confirm" class="rounded-full bg-green-500 hover:bg-green-400 w-14 text-white text-sm me-3">Yes</button>
            <button type="button" id="cancel" class="rounded-full border border-gray-500 text-gray-500 hover:bg-gray-500 hover:text-white w-14">No</button>
        </div>
    </div>
</div>
{{--End confirm dialog--}}

{{--Edit model --}}

    <!-- Main modal -->
    <div id="editModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full edit-model bg-gray-700/30">
        <div class="relative w-full max-w-2xl max-h-full m-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Products
                    </h3>
                    <button type="button" id="closeBtn" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="" method="post">
                    <div class="px-6 py-6 space-y-6">
                        <div class="grid grid-cols-2 gap-0">
                            <div class="px-2 py-2">
                                <input type="hidden" name="p_id" id="p_id_2" value="">
                                <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                <div class="w-full mb-3">
                                    <label for="cat_id" class="text-sm font-medium w-full">Category</label>
                                    <select name="cat_id" id="cat_id_2" class="p-1 rounded-md border border-gray-400 w-full">
                                        <option value=""></option>
                                        @foreach ($category as $cat)
                                            <option value="{{ $cat->cat_id }}">{{ $cat->category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-full mb-3">
                                    <label for="item" class="text-sm font-medium w-full">item</label>
                                    <input type="text" name="item" id="item_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="department" class="text-sm font-medium w-full">Department</label>
                                    <input type="text" name="department" id="department_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="unit" class="text-sm font-medium w-full">Unit</label>
                                    <input type="text" name="unit" id="unit_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="line_no" class="text-sm font-medium w-full">Line No</label>
                                    <input type="text" name="line_no" id="line_no_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="description" class="text-sm font-medium w-full">Description</label>
                                    <textarea name="description" id="description_2" cols="30" rows="2" class="rounded-md w-full border border-gray-400"></textarea>
                                </div>
                            </div>
                            <div class="px-2 py-2">
                                <div class="w-full mb-3">
                                    <label for="cost" class="text-sm font-medium w-full">Cost</label>
                                    <input type="text" name="cost" id="cost_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="selling_price" class="text-sm font-medium w-full">Selling Price</label>
                                    <input type="text" name="selling_price" id="selling_price_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="rol" class="text-sm font-medium w-full">ROL</label>
                                    <input type="text" name="rol" id="rol_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="capacity" class="text-sm font-medium w-full">Capacity</label>
                                    <input type="text" name="capacity" id="capacity_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                                <div class="w-full mb-3">
                                    <label for="open_stock" class="text-sm font-medium w-full">Open Stock</label>
                                    <input type="text" name="open_stock" id="open_stock_2" class="p-1 rounded-md w-full border border-gray-400" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-6 space-x-2 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="button" id="updateCategory" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Update</button>
                        <button  type="button" id="closeBtn_2" class="text-gray-500 bg-white hover:bg-gray-100 focus:ring-4 focus:outline-none focus:ring-blue-300 rounded-lg border border-gray-200 text-sm font-medium px-5 py-2.5 hover:text-gray-900 focus:z-10 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-500 dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{--End of edit model --}}

    <script src="{{ asset('js/product-delete.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/edit-product.js') }}" type="text/javascript"></script>
@endsection
