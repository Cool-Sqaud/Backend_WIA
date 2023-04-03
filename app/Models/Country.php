<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $table = 'country';

    protected $primaryKey = 'country_code';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    // protected $fillable = [
    //     'country_code',
    //     'country',
    // ];
}
