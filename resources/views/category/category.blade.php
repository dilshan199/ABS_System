@extends('layouts.master')

@section('title', 'Categories')

@section('content')

    <div class="">
        <h1 class="text-2xl font-thin text-gray-900">Create Categories</h1>
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
    <form action="{{ route('category.store') }}" method="post" class="mt-4">
        @csrf
        <div class="w-full mb-3">
            <div class="flex items-center">
                <label for="category" class="text-sm font-medium w-64 flex-none">Category <span class="text-red-600">*</span></label>
                <div class="flex-auto">
                    <input type="text" name="category" id="category" class="p-1 rounded-md w-full" value="" autocomplete="off">
                    <span class="text-sm text-red-600 font-normal">{{ $errors->first('category')}}</span>
                </div>
            </div>
        </div>
        <div class="w-full mb-3">
            <div class="flex items-center">
                <label for="category_status" class="text-sm font-medium w-64 flex-none">Category Status <span class="text-red-600">*</span></label>
                <div class="flex-auto">
                    <select name="category_status" id="category_status" class="p-1 rounded-md w-full">
                        <option value=""></option>
                        <option value="1">Active</option>
                        <option value="2">Deactive</option>
                    </select>
                    <span class="text-sm text-red-600 font-normal">{{ $errors->first('category_status')}}</span>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end">
            <button type="submit" name="submit" value="Submit" class="p-2 rounded-md text-white bg-green-600 hover:bg-green-500 font-medium">Submit</button>
        </div>
    </form>
    <div class="w-full overflow-scroll h-64 bg-gray-100 mt-5 mb-4">
        <table class="w-full border border-gray-300">
            <thead class="text-center text-sm font-medium">
                <th class="border border-gray-300">ID</th>
                <th class="border border-gray-300">Category</th>
                <th class="border border-gray-300">Status</th>
                <th class="border border-gray-300">Action</th>
            </thead>
            <tbody class="text-sm">
                @foreach ($category as $cat)
                    <tr>
                        <td class="border border-gray-300 text-center px-2 py-2">{{ $cat->cat_id }}</td>
                        <td class="border border-gray-300">{{ $cat->category }}</td>
                        <td class="border border-gray-300 text-center">
                            @if ($cat->category_status == 1)
                                <span class="rounded-lg bg-green-300 text-green-500 font-medium px-1 py-1 text-sm">Active</span>
                            @else
                                <span class="rounded-lg bg-red-300 text-red-500 font-medium px-1 py-1 text-sm">Deactive</span>
                            @endif
                        </td>
                        <td class="border border-gray-300 text-center">
                            <a href="javascript:void(0)" class="edit-button cursor-pointer px-1 py-1 text-blue-800" title="Edit" id="editButton" data-url="{{ route('category.edit', $cat->cat_id) }}"><i class="bi bi-pencil-square"></i>&nbsp;Edit</a>
                            <a type="button" class="remove cursor-pointer px-1 py-1 text-blue-800" id="{{ $cat->cat_id }}" title="Delete"><i class="bi bi-trash"></i>&nbsp;Delete</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{ $category->links() }}
    {{--Confirm dialog--}}
    <div class="absolute w-full top-0 h-full left-0 close-dialog bg-slate-500/50" id="confirmDialog">
        <div class="shadow-md bg-white w-96 m-auto mt-36 h-28 rounded-md p-3">
            <p class="text-sm text-slate-500 mt-3">Are you sure to delete this record? This action can't be undo</p>
            <div class="flex justify-end">
                <button type="button" id="confirm" class="rounded-full bg-green-500 hover:bg-green-400 w-14 text-white text-sm me-3">Yes</button>
                <button type="button" id="cancel" class="rounded-full border border-slate-500 text-slate-500 hover:bg-slate-500 hover:text-white w-14">No</button>
            </div>
        </div>
    </div>
    {{--End confirm dialog--}}

    {{--Edit model --}}

    <!-- Main modal -->
    <div id="editModal" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full edit-model bg-gray-700/30">
        <div class="relative w-full max-w-md max-h-full m-auto">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Edit Category
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
                        <input type="hidden" name="cat_id" id="cat_id_2" value="">
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <div class="w-full mb-3">
                            <label for="category" class="text-sm font-medium w-full">Category</label>
                            <input type="text" name="category" id="category_2" class="p-1 rounded-md w-full" value="">
                        </div>
                        <div class="w-full mb-3">
                            <label for="category_status" class="text-sm font-medium w-full">Category</label>
                            <select name="category_status" id="category_status_2" class="p-1 rounded-md w-full">
                                <option value=""></option>
                                <option value="1">Activate</option>
                                <option value="2">Deactivate</option>
                            </select>
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

    <script type="text/javascript">
        $(document).ready(function() {
            // Click delete button
            $('.remove').click(function() {
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
                        data: 'cat_id='+id,
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
    <script src="{{ asset('js/edit-category.js') }}" type="text/javascript"></script>
@endsection
