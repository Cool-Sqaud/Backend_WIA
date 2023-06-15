<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\Models\Measurement;
use App\Models\Station;

class BodegasController extends Controller
{
    // Model Measurement{
    //     id int AI PK 
    //     station varchar(10) 
    //     edited int 
    //     date date 
    //     time time 
    //     temp float 
    //     dewp float 
    //     stp float 
    //     slp float 
    //     visib float 
    //     wdsp float 
    //     prcp float 
    //     sndp float 
    //     frshtt varchar(6) 
    //     cldc float 
    //     winddir int
    // }
    
    // Model Station{
    //     name varchar(10) PK 
    //     longitude float 
    //     latitude float 
    //     elevation float
    // }

    // Model Geolocation{
    //     id int AI PK 
    //     station_name varchar(10) 
    //     country_code varchar(2) 
    //     island varchar(100) 
    //     county varchar(100) 
    //     place varchar(100) 
    //     hamlet varchar(100) 
    //     town varchar(100) 
    //     municipality varchar(100) 
    //     state_district varchar(100) 
    //     administrative varchar(100) 
    //     state varchar(100) 
    //     village varchar(100) 
    //     region varchar(100) 
    //     province varchar(100) 
    //     city varchar(100) 
    //     locality varchar(100) 
    //     postcode varchar(100) 
    //     country varchar(100)
    // }

    // Model Country {
    //     country_code varchar(2) PK 
    //     country varchar(45)
    // }

    /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    // Create humidity endpoint (BodegasController)
    // On the humidity page, the top 10 most humid stations (of the previous day) will display the station information. For example: Station number, Country, Location and Elevation


    // Create humidity history endpoint (BodegasController)
    // On the humidity page, the top 10 most humid stations will display the station information per day.


    /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    // Create temperature endpoint (BodegasController)
    // All the data from weather stations in South-America where temperature is below 15 degrees Celsius 
    public function temperatureData()
    {
        config()->set('database.connections.mysql.strict', false);
        return Measurement::
        join('wia.geolocation as g', 'Measurement.station', '=', 'g.station_name')
        ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
        ->join('wia.country as c', 'g.country_code', '=', 'c.country_code')
        ->join('wia.station as s', 'Measurement.station', '=', 's.name')
        ->where('temp', '<', 15)
        ->whereBetween(DB::raw("CONCAT(date, ' ', time)"), [now()->subHour(), now()])
        ->select('station', DB::raw('MAX(date) as date'), DB::raw('MAX(time) as time'), 
                 'temp', 'dewp', 'stp', 'slp', 'visib', 'wdsp', 'prcp', 'sndp', 'frshtt', 'cldc', 'winddir', 
                 'c.country', 's.longitude', 's.latitude', 's.elevation')
        ->groupBy('station')
        ->orderBy('station', 'asc')
        ->get();
    }

    // Create temperature history endpoint (BodegasController)
    // All the data from weather stations in South-America where temperature is below 15 degrees Celsius, (one station can only appear once a day).
    public function temperatureDataHistory()
    {
        config()->set('database.connections.mysql.strict', false);
        return Measurement::
        join('wia.geolocation as g', 'Measurement.station', '=', 'g.station_name')
        ->whereIn('g.country_code', ['AR', 'BO', 'BR', 'CL', 'CO', 'EC', 'GY', 'PY', 'PE', 'SR', 'UY', 'VE', 'GS', 'FK', 'GF'])
        ->join('wia.country as c', 'g.country_code', '=', 'c.country_code')
        ->join('wia.station as s', 'Measurement.station', '=', 's.name')
        ->where('temp', '<', 15)
        ->select('station', 'date', DB::raw('MAX(time) as time'), 
                 'temp', 'dewp', 'stp', 'slp', 'visib', 'wdsp', 'prcp', 'sndp', 'frshtt', 'cldc', 'winddir', 
                 'c.country', 's.longitude', 's.latitude', 's.elevation')
        ->groupBy('station', 'date')
        ->orderBy('date', 'desc')
        ->orderBy('station', 'asc')
        ->get();
    }


    /*-------------------------------------------------------------------------------------------------------------------------------------------------------------------*/
    // Create a function that takes weatherdata and orders by day, of a specific timeframe (BodegasController)
    public function orderedData()
    {
        return Measurement::
                where('station', 351660)
                ->select('date')
                ->groupBy('date')
                ->get();
    }
}
