<?php

namespace App\Models;

use Eastwest\Json\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['product_code','catalog_code'];
    protected $casts = ['product_data'];

    public function account()
    {
      return  $this->belongsTo(Account::class);
    }

    public function getProductDataAttribute($value)
    {
        if(!empty($value)){
            return Json::decode($value);
        }
        return [];
    }
}
