<?php

namespace App;
use App\Product;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    public function products()
    {
       return $this->hasMany(Product::class);
    }
    public function subcategories()
    {
       return $this->hasMany(SubCategory::class);
    }
}
