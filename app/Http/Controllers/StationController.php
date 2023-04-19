<?php

namespace App\Http\Controllers;

use App\Models\Station;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function getStation(string $stationnumber)
    {
        return DB::table('station')
                ->where('name', '=', $stationnumber)
                ->get();
    }

    public function getAllStationsAndLocations()
    {
        return DB::table('station')
                ->join('geolocation', 'station.name', '=', 'geolocation.station_name')
                ->join('country', 'geolocation.country_code', '=', 'country.country_code')
                ->select('station.name', 'station.longitude', 'station.latitude', 'country.country')
                ->orderBy('station.name')
                ->get();
    }
    
}
