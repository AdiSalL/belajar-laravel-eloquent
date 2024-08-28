<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    public function __construct(   
        public string $street,
        public string $city,
        public string $country,
        public string $postal_code
        )
        {
            $this->street = $street;
            $this->city = $city;
            $this->country = $country;
            $this->postal_code = $postal_code;
            
        }
}
