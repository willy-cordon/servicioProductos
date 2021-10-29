<?php

namespace App\Models;

use Carbon\Carbon;
use Eastwest\Json\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class  AccountServiceOrder extends Model
{
    use HasFactory;
    protected $fillable = ['external_order_id','external_seller_id','external_data','status','external_status','external_additional_data','external_created_at'];

    public function getExternalDataAttribute($value)
    {
        if(!empty($value)){
            return Json::decode($value);
        }
        return [];
    }

    public function getUpdatedAtAttribute($value){
        if(!empty($value)){
            return Carbon::parse($value)->format(config('app.date_format'));
        }
        return null;
    }

}
