<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

class ProductPart extends Model
{
    use HasRecursiveRelationships;
    protected $fillable = [
        'product_id',
        'product_part_id',
        'title',
        'description',
        'model',
        'fixed',
        'color',
        'price',
        'order'
    ];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function parent_part()
    {
        return $this->belongsTo(ProductPart::class, 'product_part_id');
    }

    public function subparts()
    {
        return $this->hasMany(ProductPart::class);
    }

    public function variations()
    {
        return $this->hasMany(ProductPartVariation::class);
    }

    public function title_full() {
        $title = $this->title;
        $parent = $this->parent_part;
        if ($parent) {
            $title = $parent->title_full() . " - " . $title;
        }
        return $title;
    }

    public function price_full() {
        $price = $this->price;
        $parent = $this->parent_part;
        if ($parent) {
            $price += $parent->price_full();
        }
        return $price;
    }


    public function model_def() {
        if (!empty($this->model)) return $this->model;
        //dd($this);
        //dd($this->parent_part);
        if (!empty($this->parent_part->model)) return $this->parent_part->model;
        return 'no_model';
    }

    public function color_bg() {
        if ($this->color) return $this->color;
        else return 'dddddd';
    }

    public function part_image() {
        if (!empty($this->image)) {
            return relative_path() . $this->image;
        }
        return 'https://placehold.co/60x60/31343C/EEE/?font=raleway&text=' . $this->title;
    }

    public function delete()
    {
        $model = base_path() . $this->model;
        if (!empty($this->model) && file_exists($model) && !is_dir($model)) {
            //dd($model);
            $dir = dirname($model);
            //dd($dir);
            if (is_dir($dir)) {
                //rmdir($dir);
                File::deleteDirectory($dir);
            }
        }

        foreach ($this->subparts as $part) {
            $part->delete();
        }
        return parent::delete();
    }

    public static function boot() {
        parent::boot();

        static::deleting(function($obj) { // before delete() method call this
            //$obj->variations()->delete();
            //$obj->subparts()->delete();
        });
    }

    public static function tree()
    {
        $allProductParts = ProductPart::all();

        $rootProductParts = $allProductParts->whereNull('product_part_id');

        self::formatTree($rootProductParts, $allProductParts);

        return $rootProductParts;
    }

    private static function formatTree($categories, $allProductParts) {

        foreach($categories as $category) {
            $category->children = $allProductParts->where('product_part_id', $category->id)->values();

            if($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allProductParts);
            }

        }
    }

    public function isChild(): bool
    {
        return $this->product_part_id !== null;
    }

}
