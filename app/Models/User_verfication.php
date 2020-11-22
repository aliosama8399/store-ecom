<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;

use Illuminate\Database\Eloquent\Model;

class  User_verfication extends Model
{
    public $table = 'users_verficationCode';
    protected $fillable = ['user_id', 'code', 'created_at', 'updated_at'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


}
