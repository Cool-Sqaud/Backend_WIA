<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


use App\Models\Measurement;
use App\Models\Station;

class MindController extends Controller
{
    public function humidityData(){
        $table = DB::table('measurement as m')
            ->selectRaw('ROUND(AVG(m.dewp), 3) as avg_dewp, m.station, c.country, m.date , ROUND(AVG(m.temp), 3) as temp , ROUND(AVG(m.wdsp), 3)as wdsp, ROUND(AVG(m.prcp), 3) as prcp, ROUND(AVG(m.cldc), 3) as cldc')
            ->join('geolocation as g', 'm.station', '=','g.station_name')
            ->join('country as c', 'g.country_code', '=', 'c.country_code')
            ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
            ->where("m.date", Carbon::yesterday()->format('Y-m-d'))
            ->groupBy('m.station', 'm.date',  'g.country_code')
            ->orderByRaw('m.date desc, avg_dewp desc')
            ->limit(10)
            ->get();
        return $table;
    }

    public function humidityDataHistory(){
        $table = DB::table('measurement as m')
            ->selectRaw('ROUND(AVG(m.dewp), 3) as avg_dewp, m.station, c.country, m.date , ROUND(AVG(m.temp), 3) as temp , ROUND(AVG(m.wdsp), 3)as wdsp, ROUND(AVG(m.prcp), 3) as prcp, ROUND(AVG(m.cldc), 3) as cldc')
            ->join('geolocation as g', 'm.station', '=','g.station_name')
            ->join('country as c', 'g.country_code', '=', 'c.country_code')
            ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
            ->groupBy('m.station', 'm.date',  'g.country_code')
            ->orderByRaw('m.date desc, avg_dewp desc')
            ->get();
        return $table;
    }
}
