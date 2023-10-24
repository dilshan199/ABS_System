<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
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

        // Get customer id
        $customer_id = DB::table('customer')
        ->select('customer_id')
        ->where('customer_name', '=', $request->get('customer_name'))
        ->first();

        // Update or insert
        $job = DB::table('job')
        ->updateOrInsert(
            ['job_id' => $request->get('job_id')],
            [
                'customer_id' => $customer_id->customer_id,
                'insurance_company' => $request->get('insurance_company'),
                'vehicle_no' => $request->get('vehicle_no'),
                'year' => $request->get('year'),
                'chasis_no' => $request->get('chasis_no'),
                'color' => $request->get('color'),
                'meter_reading' => $request->get('meter_reading'),
                'model' => $request->get('model'),
                'engine_no' => $request->get('engine_no'),
                'fault_1' => $request->get('fault_1'),
                'fault_2' => $request->get('fault_2'),
                'fault_3' => $request->get('fault_3'),
                'fault_4' => $request->get('fault_4'),
                'job_status' =>(!empty($request->get('job_status'))) ? $request->get('job_status') : 1,
                'job_date' => $request->get('job_date'),
            ]
        );

        // Store input data inside a feild after form submit
        session()->put([
            'job_id' => $request->get('job_id'),
            'customer_id' => $customer_id->customer_id,
            'insurance_company' => $request->get('insurance_company'),
            'vehicle_no' => $request->get('vehicle_no'),
            'year' => $request->get('year'),
            'chasis_no' => $request->get('chasis_no'),
            'color' => $request->get('color'),
            'meter_reading' => $request->get('meter_reading'),
            'model' => $request->get('model'),
            'engine_no' => $request->get('engine_no'),
            'fault_1' => $request->get('fault_1'),
            'fault_2' => $request->get('fault_2'),
            'fault_3' => $request->get('fault_3'),
            'fault_4' => $request->get('fault_4'),
            'job_status' =>$request->get('job_status'),
            'job_date' => $request->get('job_date'),
        ]);

        return redirect()->back()->with('success', 'Job created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $job = DB::table('job')
        ->select('*')
        ->join('customer', 'job.customer_id', '=', 'customer.customer_id', 'inner')
        ->where('job_id', '=', $request->job_id)
        ->first();

        session()->put([
            'job_id' => $job->job_id,
            'customer_id' => $job->customer_id,
            'customer_name' => $job->customer_name,
            'address' => $job->address,
            'contact_no' => $job->contact_no,
            'insurance_company' => $job->insurance_company,
            'vehicle_no' => $job->vehicle_no,
            'year' => $job->year,
            'chasis_no' => $job->chasis_no,
            'color' => $job->color,
            'meter_reading' => $job->meter_reading,
            'model' => $job->model,
            'engine_no' => $job->engine_no,
            'fault_1' => $job->fault_1,
            'fault_2' => $job->fault_2,
            'fault_3' => $job->fault_3,
            'fault_4' => $job->fault_4,
            'job_status' =>$job->job_status,
            'job_date' => $job->job_date,
        ]);

        return redirect()->back();

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $job_id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $job_id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $job_id)
    {
        $job = Job::find($job_id);
        $job->delete();

    }

    public function jobPage()
    {
        if(session()->has('loggedin')){
            $user = DB::table('users')->select('*')->where('id', '=', session('loggedin'))->first();

            $user_data = [
                'user' => $user
            ];
        }

        // Generate job id using job table max id
        $max_job_id = DB::table('job')
        ->select(DB::raw('max(job_id) as maxJobId'))
        ->first();

        $job_id = $max_job_id->maxJobId + 1;

        return view('job.job', compact('user', 'job_id'));
    }

    // Fetch vehicle related all jobs
    public function vehicleJobs(Request $request)
    {
        $job = DB::table('job')
        ->select('*')
        ->join('customer', 'job.customer_id', '=', 'customer.customer_id', 'inner')
        ->where('vehicle_no', '=', $request->get('vehicle_no'))
        ->get();

        return redirect()->back()->with('job', $job);
    }

    // Mark complete job
    public function markCompleteJob(Request $request)
    {
        $job = DB::table('job')
        ->where('job_id', '=', $request->get('job_id'))
        ->update(['job_status' => 2]);

        $new_job_status = DB::table('job')
        ->select('job_status')
        ->where('job_id', '=', $request->get('job_id'))
        ->first();

        session()->put(['job_status' => $new_job_status->job_status]);

        return redirect()->back()->with('success', 'Job complete successfully.');
    }

    // Job search by customer name
    public function jobSearchByName(Request $request)
    {
        // Get customer id for related customer
        $customer_id = DB::table('customer')
        ->select('customer_id')
        ->where('customer_name', '=', $request->get('customer_name'))
        ->first();

        // Select job related to customer
        $job = DB::table('job')
        ->select('*')
        ->join('customer', 'job.customer_id', '=', 'customer.customer_id', 'inner')
        ->where('job.customer_id', '=', $customer_id->customer_id)
        ->get();

        return redirect()->back()->with('job', $job);
    }

    // Type and search
    public function autoCustomerSearch(Request $request)
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

    //Get new job page
    public function newJobPage(Request $request)
    {
        $request->session()->forget('job_id');
        $request->session()->forget('customer_id');
        $request->session()->forget('customer_name');
        $request->session()->forget('contact_no');
        $request->session()->forget('insurance_company');
        $request->session()->forget('vehicle_no');
        $request->session()->forget('year');
        $request->session()->forget('chasis_no');
        $request->session()->forget('color');
        $request->session()->forget('model');
        $request->session()->forget('fault_1');
        $request->session()->forget('fault_2');
        $request->session()->forget('fault_3');
        $request->session()->forget('fault_4');
        $request->session()->forget('job_status');
        $request->session()->forget('job_date');

        return redirect()->back();
    }

    public function getOldJob(Request $request, string $job_id)
    {
        $request->session()->forget('job_id');
        $request->session()->forget('customer_id');
        $request->session()->forget('customer_name');
        $request->session()->forget('contact_no');
        $request->session()->forget('insurance_company');
        $request->session()->forget('vehicle_no');
        $request->session()->forget('year');
        $request->session()->forget('chasis_no');
        $request->session()->forget('color');
        $request->session()->forget('model');
        $request->session()->forget('fault_1');
        $request->session()->forget('fault_2');
        $request->session()->forget('fault_3');
        $request->session()->forget('fault_4');
        $request->session()->forget('job_status');
        $request->session()->forget('job_date');

        // Fetch selected quotation using quotation id
        $job = DB::table('job')
        ->select('*')
        ->join('customer', 'job.customer_id', '=', 'customer.customer_id', 'inner')
        ->where('job_id', '=', $job_id)
        ->first();

        session()->put([
            'job_id' => $job->job_id,
            'customer_id' => $job->customer_id,
            'customer_name' => $job->customer_name,
            'address' => $job->address,
            'contact_no' => $job->contact_no,
            'insurance_company' => $job->insurance_company,
            'vehicle_no' => $job->vehicle_no,
            'year' => $job->year,
            'chasis_no' => $job->chasis_no,
            'color' => $job->color,
            'meter_reading' => $job->meter_reading,
            'model' => $job->model,
            'engine_no' => $job->engine_no,
            'fault_1' => $job->fault_1,
            'fault_2' => $job->fault_2,
            'fault_3' => $job->fault_3,
            'fault_4' => $job->fault_4,
            'job_status' =>$job->job_status,
            'job_date' => $job->job_date,
        ]);
    }
}
