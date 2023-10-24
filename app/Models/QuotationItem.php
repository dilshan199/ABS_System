<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class QuotationItem extends Model
{
    use HasFactory;
    protected $table = 'quotation_item';
    protected $primaryKey = 'quotation_rol_id';
    protected $fillable = [
        'quotation_id',
        'cat_id',
        'p_id',
        'supp_type',
        'hours',
        'amount',
        'amount2'
    ];

    public function Quotation() : HasOne
    {
        return $this->hasOne(Quotation::class);
    }
}
