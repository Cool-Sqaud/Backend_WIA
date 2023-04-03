<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function debug_to_console($data) {
        $output = $data;
        if (is_array($output))
            $output = implode(',', $output);
        echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
    }

    public function index() {
        $data =  Measurement::all();

        $json_pretty = json_encode($data, JSON_PRETTY_PRINT);
        echo "<pre>" . $json_pretty . "<pre/>";
        return;
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
            'cldc' => strval($request->input('CLDC')),
            'wnddir' => $request->input('WNDDIR')
        );
        return Measurement::create($data);
    }

    public function storeMultiple(Request $request) {
        $result = array();
        $weatherdataArray = $request->input('WEATHERDATA');
        foreach ($weatherdataArray as $weatherdata) {
            $output = $weatherdata;
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
                'cldc' => strval($weatherdata['CLDC']),
                'wnddir' => $weatherdata['WNDDIR']
            );
            $output = $data;
            if (is_array($output))
                $output = implode(',', $output);
            echo "<script>console.log('Debug Objects: ", $output, "');</script>";
            array_push($result, Measurement::create($data));
        }
        return $result;
    }
}
