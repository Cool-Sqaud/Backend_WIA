<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NearestLocation extends Model
{
    use HasFactory;

    protected $table = 'nearestlocation';

    public $timestamps = false;

    // protected $fillable = [
    //     'id',
    //     'station_name',
    //     'name',
    //     'administrative_region1',
    //     'administrative_region2',
    //     'country_code',
    //     'longitude',
    //     'latitude',
    // ];
}
