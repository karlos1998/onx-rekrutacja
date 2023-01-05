<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'city',
        'cityDistricted',
        'county' ,
        'houseNumber',
        'municipality',
        'name',
        'state',
        'street',
        'street1',
        'streetPrefix',
        'streetTeryt',
        'uuid',
        'zip'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
