<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index() {
        return Measurement::all();
    }

    public function show(int $id)
    {
        return DB::table('measurement')->where('id', '=', $id)->get();
    }

    public function getStation(string $stationnumber)
    {
        return DB::table('station')->where('name', '=', $stationnumber)->get();
    }

    public function getStationMeasurements(string $stationnumber)
    {
        return DB::table('measurement')->where('STN', '=', $stationnumber)->get();
    }

    public function recentIndex()
    {
        return DB::table('measurement')->limit(100)->get();
    }

    public function store(Request $request) {
        // $output = $request->all();
        // if (is_array($output))
        //     $output = implode(',', $output);
        // echo "<script>console.log('Debug Objects: ", $output, "');</script>";
        $data = array(
            'station' => $request->input('STN'),
            'date' => $request->input('DATE'),
            'time' => $request->input('TIME'),
            'temp' => $request->input('TEMP'),
            'dewp' => $request->input('DEWP'),
            'stp' => $request->input('STP'),
            'slp' => $request->input('SLP'),
            'visib' => $request->input('VISIB'),
            'wdsp' => $request->input('WDSP'),
            'prcp' => $request->input('PRCP'),
            'sndp' => $request->input('SNDP'),
            'frshtt' => $request->input('FRSHTT'),
            'cldc' => $request->input('CLDC'),
            'wnddir' => $request->input('WNDDIR')
        );
        return Measurement::create($data);
    }

    public function storeMultiple(Request $request) {
        $result = array();
        $weatherdataArray = $request->input('WEATHERDATA');
        foreach ($weatherdataArray as $weatherdata) {
            // $output = $weatherdata;
            $data = array(
                'station' => $weatherdata['STN'],
                'date' => $weatherdata['DATE'],
                'time' => $weatherdata['TIME'],
                'temp' => $weatherdata['TEMP'],
                'dewp' => $weatherdata['DEWP'],
                'stp' => $weatherdata['STP'],
                'slp' => $weatherdata['SLP'],
                'visib' => $weatherdata['VISIB'],
                'wdsp' => $weatherdata['WDSP'],
                'prcp' => $weatherdata['PRCP'],
                'sndp' => $weatherdata['SNDP'],
                'frshtt' => $weatherdata['FRSHTT'],
                'cldc' => $weatherdata['CLDC'],
                'wnddir' => $weatherdata['WNDDIR']
            );
            // $output = $data;
            // if (is_array($output))
            //     $output = implode(',', $output);
            // echo "<script>console.log('Debug Objects: ", $output, "');</script>";
            echo Measurement::create($data), "\n";
        }
        // return $result;
        return;
    }
}
