<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use Translatable;

    protected $with = ['translations'];
    protected $fillable = ['is_active', 'photo'];
    protected $casts = ['is_active' => 'boolean',];
   protected $hidden = ['translations'];
    public $translatedAttributes = ['name'];


    public function getActive()
    {
        return $this->is_active == 0 ? __('admin/maincategories.deactive') : __('admin/maincategories.active');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active',1);
    }

    public function getPhotoAttribute($val)
    {
        return ($val != null) ? asset('assets/images/brands/' . $val) : "";
    }

}
