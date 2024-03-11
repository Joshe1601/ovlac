<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class ProductPartVariation extends Model
{
    use HasRecursiveRelationships;
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
