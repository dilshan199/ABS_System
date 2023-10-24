<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quotation extends Model
{
    use HasFactory;
    protected $table = 'quotation';
    protected $primaryKey = 'quotation_id';
    protected $fillable = [
        'quotation_id',
        'customer_id',
        'cuatomer_name',
        'contact_no',
        'insurance_company',
        'vehicle_no',
        'year',
        'chasis_no',
        'color',
        'meter_reading',
        'model',
        'engine_no',
        'remarks',
        'quotation_date'
    ];

    public function QuotationItem() : HasMany
    {
        return $this->hasMany(QuotationItem::class);
    }
}
