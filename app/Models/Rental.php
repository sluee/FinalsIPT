<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rental extends Model
{
    use HasFactory;

    protected $guarded=[];
    protected $casts = [
        'car_id' => 'integer',
    ];

    public function customer(){
        return $this->belongsTo(Customer::class, 'cust_id');
    }
    public function car()
    {
        return $this->belongsTo(Car::class, 'car_id');
    }
}
