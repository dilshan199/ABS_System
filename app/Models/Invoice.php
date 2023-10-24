<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $primaryKey = 'invoice_no';
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'customer_name',
        'contact_no',
        'insurance_company',
        'vehicle_no',
        'model',
        'vat_number',
        'with_out_tax_amount',
        'cash_discount',
        'nbt',
        'vat',
        'net_amount',
        'paid_amount',
        'balance',
        'invoice_date'
    ];

    public function InvoiceItem() : HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }
}
