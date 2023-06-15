<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


use App\Models\Measurement;
use App\Models\Station;

class MindController extends Controller
{
    // Ja lekker
    // public function humidityData(){
    //     config()->set('database.connections.mysql.strict', false);
    //     return Measurement::
    //     join('wia.geolocation as g', 'Measurement.station', '=', 'g.station_name')
    //     ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
    //     ->groupBy()
    //     ->orderBy('date', 'desc' ,'DEWP', 'desc')
    //     ->limit('10')
    //     ->get();
    // }

    public function humidityData(){
        $table = DB::table('wia.measurement as m')
            ->selectRaw('ROUND(AVG(m.dewp), 3) as avg_dewp, m.station, g.country_code, m.date , ROUND(AVG(m.temp), 3) as temp , ROUND(AVG(m.wdsp), 3)as wdsp, ROUND(AVG(m.prcp), 3) as prcp, ROUND(AVG(m.cldc), 3) as cldc')
            ->join('wia.geolocation as g', 'm.station', '=','g.station_name')
            ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
            ->groupBy('m.station', 'm.date',  'g.country_code')
            ->orderByRaw('m.date desc, avg_dewp desc')
            ->limit(10)
            ->get();
        return $table;
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
