<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;
    protected $table = 'job';
    protected $primaryKey = 'job_id';
    protected $fillable = [
        'job_id',
        'customer_id',
        'customer_name',
        'address',
        'contact_no',
        'insurance_company',
        'vehicle_no',
        'year',
        'chasis_no',
        'color',
        'meter_reading',
        'model',
        'engine_no',
        'fault_1',
        'fault_2',
        'fault_3',
        'fault_4',
        'job_status',
        'job_date',
    ];
}
