<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use Translatable, SoftDeletes;

    protected $with = ['translations'];

    protected $fillable = [
        'brand_id',
        'slug',
        'sku',
        'price',
        'special_price',
        'special_price_type',
        'special_price_start',
        'special_price_end',
        'selling_price',
        'manage_stock',
        'qty',
        'in_stock',
        'is_active'
    ];


    protected $casts = [
        'manage_stock' => 'boolean',
        'in_stock' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'special_price_start',
        'special_price_end',
        'start_date',
        'end_date',
        'deleted_at',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    /* protected $appends = [
         'base_image', 'formatted_price', 'rating_percent', 'is_in_stock', 'is_out_of_stock',
         'is_new', 'has_percentage_special_price', 'special_price_percent',
     ];*/

    /**
     * The attributes that are translatable.
     *
     * @var array
     */
    protected $translatedAttributes = ['name', 'description', 'short_description'];


    public function getActive()
    {
        return $this->is_active == 0 ? __('admin/maincategories.deactive') : __('admin/maincategories.active');
    }

    public function scopeActive($query){
        return $query -> where('is_active',1);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class)->withDefault();
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories');
    }


    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'product_tags');
    }

    public function options()
    {
        return $this->hasMany(Option::class, 'product_id');

    }

    public function images()
    {
        return $this->hasMany(Image::class, 'product_id');

    }

}
