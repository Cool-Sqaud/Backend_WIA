<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasurementEdit extends Model
{
    //Table needs to be changed so it takes in stationnumber, key, newvalue and oldvalue (+ timestamps from laravel)

    use HasFactory;

    protected $table = 'measurement_edit';

    public $timestamps = false;

    // protected $fillable = [
    //     'id',
    //     'temp',
    //     'dewp',
    //     'stp',
    //     'slp',
    //     'visib',
    //     'wdsp',
    //     'prcp',
    //     'sndp',
    //     'frshtt',
    //     'cldc',
    //     'winddir',
    // ];
}
