<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class  Category extends Model
{
    use Translatable;

    protected $with = ['translations'];
    protected $translatedAttributes = ['name'];
    protected $fillable = ['parent_id', 'slug', 'is_active'];
    protected $casts = ['is_active' => 'boolean',];
    protected $hidden = ['translations'];

    public function scopeParent($q)
    {
        return $q->whereNull('parent_id');
    }

    public function scopeChild($q)
    {
        return $q->whereNotNull('parent_id');
    }

    public function scopeActive($q)
    {
        return $q->where('is_active',1);
    }

    public function getActive()
    {
        return $this->is_active == 0 ? __('admin/maincategories.deactive') : __('admin/maincategories.active');
    }

    public function mainparent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    public function _childs()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    public function getPhotoAttribute($val)
    {
        return ($val != null) ? asset('assets/images/maincategories/' . $val) : "";
    }
}
