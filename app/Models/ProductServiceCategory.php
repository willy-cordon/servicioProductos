<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductServiceCategory extends Model
{
    use HasFactory;
    protected $fillable = ['external_category_id','product_category_id','service_id'];
}
