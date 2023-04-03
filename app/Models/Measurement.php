<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Measurement extends Model
{
    use HasFactory;

    protected $table = 'measurement';

    public $timestamps = false;

    protected $fillable = [
        'station',
        'edited',
        'date',
        'time',
        'temp',
        'dewp',
        'stp',
        'slp',
        'visib',
        'wdsp',
        'prcp',
        'sndp',
        'frshtt',
        'cldc',
        'winddir',
    ];
}
