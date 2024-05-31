<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $attributes = [
        'price' => 0,

        "camera_x" => 0,
        "camera_y" => 1,
        "camera_z" => 1,
        "camera_min_zoom" => 0,
        "camera_max_zoom" => 10,
        "camera_limit_x" => 180,
        "camera_limit_y" => 180,
        "has_light" => 1,
        "has_shadow" => 1,
    ];

    protected $fillable = [
        'title',
        'description',
        'price',
        'file',
        'order',
        'image',


        "camera_x",
        "camera_y",
        "camera_z",
        "camera_min_zoom",
        "camera_max_zoom",
        "camera_limit_x",
        "camera_limit_y",
        "has_light",
        "has_shadow",
    ];


    public function parts()
    {
        return $this->hasMany(ProductPart::class);
    }

    public function fixed_parts()
    {
        return $this->parts()->where('fixed','=', 1)->where('product_part_id', '=', null);
    }

    public function variable_parts()
    {
        return $this->parts()->where('fixed','=', 0)->where('product_part_id', '=', null);
    }

    public function url_image() {
        return "";
    }

    public function product_image() {
        if (!empty($this->image)) {
            return relative_path() . $this->image;
        }
        return 'https://placehold.co/60x60/31343C/EEE/?font=raleway&text=' . $this->title;
    }

    public function short_description() {
        return $this->description;
    }


    public function delete()
    {
        foreach ($this->parts as $part) {
            $part->delete();
        }
        return parent::delete();
    }


    public static function boot() {
        parent::boot();

        static::deleting(function($obj) { // before delete() method call this
            //$obj->parts()->delete();
        });
    }

    public function get_red_title() {
        $title = $this->title;
        $firstLetter = substr($title, 0, 1);
        $restOfString = substr($title, 1);
        return "<span class='red-first-letter'>$firstLetter</span>$restOfString";

    }

}
