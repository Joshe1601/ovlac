<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductPartVariation extends Model
{
    protected $fillable = [
        'product_part_id',
        'title',
        'description',
        'price',
        'model',
        'color',
        'order'
    ];

    public function part()
    {
        return $this->belongsToOne(ProductPart::class);
    }

}
