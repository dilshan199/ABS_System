@extends('layouts.master')

@section('title', 'Job Register')

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
                        <a href="{{ route('job.new') }}" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">New</a>
                    </li>
                    <li>
                        <a type="button" id="jobDoneBtn" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">Pending/Done</a>
                    </li>
                </ul>
            </div>
            <h1 class="text-2xl font-thin text-gray-900">/&nbsp;Create Job</h1>
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
        </div>
        <div class="mt-3 border-0 border-t-4 border-t-navy-blue-300 py-3 px-3 shadow-md bg-white rounded-md">
            <div class="flex">
                <div class="flex-auto w-80 px-3">
                    <form action="{{ route('job.store') }}" method="post">
                        @csrf
                        <div class="grid grid-cols-2 gap-1 mb-3">
                            <div class="flex items-center justify-between">
                                <label for="job_id" class="text-sm font-medium">Job No</label>
                                <div>
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <input type="text" name="job_id" id="job_id" class="p-1 border-none bg-gray-500/50 rounded-md text-center font-bold" value="@php if(session('job_id')){ echo session('job_id');}else{echo $job_id ;} @endphp">
                                </div>
                            </div>
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="quotation_date" class="text-sm font-medium">Date <span class="text-red-600">*</span></label>
                                    <div>
                                        <input type="date" name="job_date" id="job_date" class="p-1 border border-gray-400 rounded-md" value="@php if(session('job_date')){ echo session('job_date');}else{echo ''; } @endphp" required>
                                        <br>
                                        <span class="text-sm font-normal text-red-600"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div class="flex items-center justify-between">
                                <label for="customer_name" class="text-sm font-medium w-[228px]">Customer <span class="text-red-600">*</span></label>
                                <div class="w-full relative">
                                    <input type="hidden" name="customer_id" id="customer_id" value="@php if(session('customer_id')){ echo session('customer_id');}else{echo '' ;} @endphp">
                                    <input type="text" name="customer_name" id="customer_name" class="p-1 border border-gray-400 rounded-md w-full" value="@php if(session('customer_name')){ echo session('customer_name');}else{echo '' ;} @endphp" required>
                                    <div id="cus-drop-box" class="absolute left-1 bg-white w-full shadow-sm z-10"></div>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div class="flex items-center justify-between">
                                <label for="address" class="text-sm font-medium w-[228px]">Address</label>
                                <div class="w-full">
                                    <input type="text" name="address" id="address" class="p-1 border border-gray-400 rounded-md w-full" value="@php if(session('address')){ echo session('address');}else{echo '' ;} @endphp">
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div>
                                <div class="flex items-center justify-between">
                                    <label for="contact_no" class="text-sm font-medium w-[228px]">Contact <span class="text-red-600">*</span></label>
                                    <div class="w-full">
                                        <input type="tel" name="contact_no" id="contact_no" class="p-1 border border-gray-400 rounded-md w-full" value="@php if(session('contact_no')){ echo session('contact_no');}else{echo '' ;} @endphp" required>
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
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div class="flex items-center justify-start space-x-3">
                                <label for="fault_1" class="text-sm font-medium w-[200px]">Fault 1</label>
                                <div class="w-full">
                                    <textarea name="fault_1" id="fault_1" cols="30" rows="2" class="w-full border border-gray-400 rounded-md">@php if(session('fault_1')){ echo session('fault_1');}else{ echo ''; } @endphp</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div class="flex items-center justify-start space-x-3">
                                <label for="fault_2" class="text-sm font-medium w-[200px]">Fault 2</label>
                                <div class="w-full">
                                    <textarea name="fault_2" id="fault_2" cols="30" rows="2" class="w-full border border-gray-400 rounded-md">@php if(session('fault_2')){ echo session('fault_2');}else{ echo ''; } @endphp</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div class="flex items-center justify-start space-x-3">
                                <label for="fault_3" class="text-sm font-medium w-[200px]">Fault 3</label>
                                <div class="w-full">
                                    <textarea name="fault_3" id="fault_3" cols="30" rows="2" class="w-full border border-gray-400 rounded-md">@php if(session('fault_3')){ echo session('fault_3');}else{ echo ''; } @endphp</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div class="flex items-center justify-start space-x-3">
                                <label for="fault_4" class="text-sm font-medium w-[200px]">Fault 4</label>
                                <div class="w-full">
                                    <textarea name="fault_4" id="fault_4" cols="30" rows="2" class="w-full border border-gray-400 rounded-md">@php if(session('fault_4')){ echo session('fault_4');}else{ echo ''; } @endphp</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 gap-1 mb-3">
                            <div class="flex items-center justify-start space-x-3">
                                <label for="job_status" class="text-sm font-medium w-[200px]">Job Status</label>
                                <div class="w-full">
                                    <select name="job_status" id="job_status" class="rounded-md border border-gray-400 p-1">
                                        <option value=""></option>
                                        <option value="3" @php if(session('job_status') == 3){ echo 'selected' ;}else{ echo ''; } @endphp>Cancel</option>
                                        <option value="2" @php if(session('job_status') == 2){ echo 'selected' ;}else{ echo ''; } @endphp>Done</option>
                                        <option value="1" @php if(session('job_status') == 1){ echo 'selected' ;}else{ echo ''; } @endphp>Pending</option>
                                        <option value="4" @php if(session('job_status') == 4){ echo 'selected' ;}else{ echo ''; } @endphp>Ready</option>
                                        <option value="5" @php if(session('job_status') == 5){ echo 'selected' ;}else{ echo ''; } @endphp>Waiting For Customer Confirmation</option>
                                        <option value="6" @php if(session('job_status') == 6){ echo 'selected' ;}else{ echo ''; } @endphp>Waiting For Spare Parts</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div>
                            <button type="submit" name="save" value="Save" class="p-1 rounded-md w-[25%] text-white bg-navy-blue-400 hover:bg-navy-blue-300 font-medium"><i class="bi bi-floppy-fill"></i>&nbsp;Save</button>
                        </div>
                    </form>
                </div>
                <div class="flex-none w-80">
                    <div class="px-3 py-2">
                        <form action="{{ route('job.show') }}" method="post">
                            @csrf
                            <h5 class="font-medium text-sm">Find Job Details By Job No Here</h5>
                            <input type="text" name="job_id" id="job_id" class="rounded-md p-2 bg-green-500 w-full font-bold text-lg" value="">
                        </form>
                    </div>
                    <div class="px-3 py-2">
                        <form action="{{ route('job.job-by-customer') }}" method="post">
                            @csrf
                            <h5 class="font-medium text-sm">Find Job Details By Customer Name</h5>
                            <input type="text" name="customer_name" id="customer_name_1" class="rounded-md p-2 bg-green-500 w-full font-bold text-lg" value="">
                        </form>
                    </div>
                    <div class="px-3 py-3 mt-2">
                        <form action="{{ route('job.job-by-vehicle') }}" method="post">
                            @csrf
                            <h5 class="font-medium text-sm">Job Number Find By Vehicle No</h5>
                            <input type="text" name="vehicle_no" id="vehicle_no" class="rounded-md p-2 bg-green-500 w-full font-bold text-lg uppercase" value="">
                        </form>
                        <div class="mt-5 w-full">
                            <form action="" method="get">
                                @csrf
                                <input type="hidden" name="job_id" id="job_id_3" value="">
                                <button type="submit" name="print" value="print" class="p-1 rounded-md w-full text-gray-500 hover:text-white hover:bg-gray-500 border border-gray-500 border-1 font-medium"><i class="bi bi-printer-fill"></i>&nbsp;Print</button>
                            </form>
                            {{-- <form action="" method="post" class="mt-2">
                                @csrf
                                <button type="submit" name="update" value="Update" class="p-1 rounded-md w-full text-white bg-green-600 hover:bg-green-400 font-medium"><i class="bi bi-pencil-square"></i>&nbsp;Edit</button>
                            </form> --}}
                            <div class="mt-6 w-full">
                                <a type="button" id="@php if(session('job_id')){ echo session('job_id');}else{echo $job_id ;} @endphp" class="mt-5 w-full rounded-md p-1 text-white bg-red-600 flex justify-center font-medium cursor-pointer delete-quotation"><i class="bi bi-trash-fill"></i>&nbsp;Delete</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                <div class="w-full h-[400px] overflow-scroll mt-3">
                    <table id="etitableTable" class="w-full border border-gray-500 text-sm table">
                        <thead>
                            <th class="p-1 border border-gray-400">ID</th>
                            <th class="p-1 border border-gray-400">Customer Name</th>
                            <th class="p-1 border border-gray-400">Telepone</th>
                            <th class="p-1 border border-gray-400">Vehicle No</th>
                            <th class="p-1 border border-gray-400">Status</th>
                            <th class="p-1 border border-gray-400">Job Date</th>
                        </thead>
                        <tbody class="font-medium">
                            @if (session()->get('job'))
                                @foreach (session()->get('job') as $job)
                                    <tr class="cursor-pointer hover:bg-gray-200" onclick="getThisId(JSON.parse('{{ $job->job_id }}'))">
                                        <td class="p-1 border border-gray-400 itemNo">
                                            {{ 'ABS/JB/'.$job->job_id }}
                                            <form action="" method="post">
                                                <input type="hidden" name="_token" id="_token_2" value="{{ csrf_token() }}">
                                                <input type="hidden" id="job_id_{{ $job->job_id }}" value="{{ $job->job_id }}">
                                            </form>
                                        </td>
                                        <td class="p-1 border border-gray-400 item">{{ $job->customer_name }}</td>
                                        <td class="p-1 border border-gray-400 catId">{{ $job->contact_no }}</td>
                                        <td class="p-1 border border-gray-400 amount text-center">{{ $job->vehicle_no }}</td>
                                        <td class="p-1 border border-gray-400 text-center">
                                            @if ($job->job_status == 1)
                                                <span class="p-1 rounded-md text-red-700 bg-red-300 text-center text-xs">Pending</span>
                                            @else
                                                <span class="p-1 rounded-md text-green-700 bg-green-300 text-center text-xs">Done</span>
                                            @endif
                                        </td>
                                        <td class="p-1 border border-gray-400 suppType text-center">{{ $job->job_date }}</td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
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

    {{-- Job complete model --}}
    <div id="jobDoneModel" class="fixed top-0 left-36 bg-gray-800/50 w-full h-screen job-model z-10">
        <div class="bg-white w-[500px] h-auto m-auto mt-28 rounded-md shadow-md">
            <div class="w-full rounded-t-md bg-gray-300 text-gray-800 font-normal px-3 py-3">
                Mark Complete Job
            </div>
            <div class="w-full px-3 py-3">
                <form action="{{ route('job.done') }}" method="post">
                    @csrf
                    <input type="hidden" name="_token" id="_token_3" value="{{ csrf_token() }}">
                    <input type="hidden" name="job_id" id="job_id_4" value="@php if(session('job_id')){ echo session('job_id');}else{echo $job_id ;} @endphp">
                    <div class="mb-3 flex items-center justify-start space-x-3">
                        <label for="job_id" class="text-sm font-medium">Job ID:</label>
                        <h6 class="font-bold text-sm">ABS/JB/@php if(session('job_id')){ echo session('job_id');}else{echo $job_id ;} @endphp</h6>
                    </div>
                    <div class="mb-3 flex items-center justify-start space-x-3">
                        <label for="customer_name" class="text-sm font-medium w-[150px]">Customer Name:</label>
                        <div class="w-full">
                            <input type="text" name="customer_name" id="customer_name_2" class="w-full rounded-md border border-gray-400" value="" required>
                        </div>
                    </div>
                    <div class="mb-3 flex items-center justify-start space-x-3">
                        <label for="customer_no" class="text-sm font-medium w-[150px]">Contact No:</label>
                        <div class="w-full">
                            <input type="text" name="contact_no" id="contact_no_1" class="w-full rounded-md border border-gray-400" value="">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-2 mb-3">
                        <div class="flex items-center justify-start space-x-3">
                            <label for="vehicle_no" class="text-sm font-medium w-[150px]">Vehicle No:</label>
                            <div class="w-full">
                                <input type="text" name="vehicle_no" id="vehicle_no_2" class="w-full rounded-md border border-gray-400" value="">
                            </div>
                        </div>
                        <div>
                            <button type="text" name="markJobComplete" value="Job Done" id="markJobComplete" class="p-3 w-full rounded-md bg-navy-blue-400 hover:bg-navy-blue-300 text-white text-sm font-medium">Job Done</button>
                        </div>
                    </div>
                    <div class="flex items-center justify-start">
                        <button type="button" id="closeDoneModel" class="border border-gray-500 text-sm font-medium hover:bg-gray-500 text-gray-500 hover:text-white rounded-md p-2 w-[25%]">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- End job complete model --}}

    <script src="{{ asset('js/job-done.js') }}" type="text/javascript"></script>
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
                        data: 'job_id='+id,
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

    <script src="{{ asset('js/search-customer.js') }}" type="text/javascript"></script>
    <script src="{{ asset('js/get-job-details.js') }}" type="text/javascript"></script>
@endsection
