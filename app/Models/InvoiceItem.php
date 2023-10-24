<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class InvoiceItem extends Model
{
    use HasFactory;
    protected $table = 'invoice_item';
    protected $primaryKey = 'invoice_rol_u=id';

    public function Invoice() : HasOne
    {
        return $this->hasOne(Invoice::class);
    }
}
