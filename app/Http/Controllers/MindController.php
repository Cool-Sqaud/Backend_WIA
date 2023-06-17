<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


use App\Models\Measurement;
use App\Models\Station;

class MindController extends Controller
{
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
        $table = DB::table('wia.measurement as m')
            ->selectRaw('ROUND(AVG(m.dewp), 3) as avg_dewp, m.station, g.country_code, m.date , ROUND(AVG(m.temp), 3) as temp , ROUND(AVG(m.wdsp), 3)as wdsp, ROUND(AVG(m.prcp), 3) as prcp, ROUND(AVG(m.cldc), 3) as cldc')
            ->join('wia.geolocation as g', 'm.station', '=','g.station_name')
            ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
            ->groupBy('m.station', 'm.date',  'g.country_code')
            ->orderByRaw('m.date desc, avg_dewp desc')
            ->get();
        return $table;
    }
}
