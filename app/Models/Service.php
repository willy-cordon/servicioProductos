<?php

namespace App\Models;

use Eastwest\Json\Json;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['name','access_Data','service_code','client_id','client_secret','country_code','currency_code','before_description','after_description','service_code','language_code'];

     const availableOrderFields = [
        'name'=> 'Nombre',
        'last_name'=>'Apellido',
        'dni'=>'Dni',
        'email'=>'Email',
        'phone_code'=>'Celular codigo',
        'phone_number'=>'Celular numero',
        'number_internal'=>'Numero interno',
        'reference_shipping'=>'Referencia de envio',
        'additional_information'=>'Informacion adicional'
    ];

    public function accounts(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Account::class);
    }


    public function getAccessDataAttribute($value)
    {
        if(!empty($value)){
            return Json::decode($value);
        }
        return [];
    }
}
