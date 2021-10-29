<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSync extends Model
{
    use HasFactory;
    protected $fillable = ['status','action'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
