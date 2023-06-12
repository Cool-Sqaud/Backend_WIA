<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


use App\Models\Measurement;
use App\Models\Station;

class MindController extends Controller
{
    // Ja lekker
    public function humidityData(){
        config()->set('database.connections.mysql.strict', false);
        return Measurement::
        join('wia.geolocation as g', 'Measurement.station', '=', 'g.station_name')
        ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
        ->join('wia.country as c', 'g.country_code', '=', 'c.country_code')
        ->join('wia.station as s', 'Measurement.station', '=', 's.name')
        ->orderBy('DEWP', 'desc')
        ->limit('10')
        ->get();
    }

    public function humidityDataHistory(){
        config()->set('database.connections.mysql.strict', false);
        return Measurement::
        join('wia.geolocation as g', 'Measurement.station', '=', 'g.station_name')
        ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
        ->join('wia.country as c', 'g.country_code', '=', 'c.country_code')
        ->join('wia.station as s', 'Measurement.station', '=', 's.name')
        ->orderBy('DATE', 'desc')
        ->get();
    }
}
