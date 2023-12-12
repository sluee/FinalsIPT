<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $guarded =[];

    // In the Car model
    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }

    public function getCarDataById($carId) {
        // Retrieve car data from the database
        return self::where('id', $carId)->first();
    }
}
