<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Products extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $primaryKey = 'p_id';
    protected $fillable = [
        'cat_id',
        'item',
        'description',
        'unit',
        'line_no',
        'department',
        'cost',
        'selling_price',
        'rol',
        'capacity',
        'open_stock'
    ];

    public function ProductsCategory() : HasOne
    {
        return $this->hasOne(Category::class);
    }
}
