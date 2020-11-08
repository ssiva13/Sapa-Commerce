<?php

namespace App;
use App\Category;
use App\SubCategory;
use App\Brand;
use Nicolaslopezj\Searchable\SearchableTrait;//https://github.com/nicolaslopezj/searchable
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SearchableTrait;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function subcategory()
    {
        return $this->belongsTo(SubCategory::class);
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function item()
    {
        return $this->hasOne('App\Item');
    }
    
    protected $searchable = [
        /**
         *
         * @var array
         */
        'columns' => [
            'products.title' => 5,
            'brands.title' => 1,
        ],
        'joins' => [
            'brands' => ['products.brand_id','brands.id'],
        ],
    ];

}
