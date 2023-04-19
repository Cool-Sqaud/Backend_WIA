<?php

namespace App\Http\Controllers;

use App\Models\Measurement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function index() {
        return DB::table('measurement')
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->get();
    }

    public function show(int $id)
    {
        return DB::table('measurement')
                ->where('id', '=', $id)
                ->get();
    }

    public function getStationMeasurements(string $stationnumber)
    {
        return DB::table('measurement')
                ->where('STN', '=', $stationnumber)
                ->get();
    }

    public function recentIndex()
    {
        return DB::table('measurement')
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->limit(100)
                ->get();
    }

    public function store(Request $request) {
        $data = $this->checkData($request->input());

        return Measurement::create($data);
    }

    public function storeMultiple(Request $request) {
        $result = '';
        foreach ($request->input('WEATHERDATA') as $weatherdata) {
            $data = $this->checkData($weatherdata);
            $result += Measurement::create($data) . "\n";
        }
        return response()->json(['message'=>'added values:\n ' . $result], 200);
    }

    private function checkData(array $weatherdata): array
    {
        $data = array(
            'station' => $weatherdata['STN'],
            'date' => $weatherdata['DATE'],
            'time' => $weatherdata['TIME'],
            'temp' => $weatherdata['TEMP'] !== "None" ? 
                $weatherdata['TEMP'] : $this->extrapolateData($weatherdata['STN'], 'temp'),
            'dewp' => $weatherdata['DEWP'] !== "None" ? 
                $weatherdata['DEWP'] : $this->extrapolateData($weatherdata['STN'], 'dewp'),
            'stp' => $weatherdata['STP'] !== "None" ? 
                $weatherdata['STP'] : $this->extrapolateData($weatherdata['STN'], 'stp'),
            'slp' => $weatherdata['SLP'] !== "None" ? 
                $weatherdata['SLP'] : $this->extrapolateData($weatherdata['STN'], 'slp'),
            'visib' => $weatherdata['VISIB'] !== "None" ? 
                $weatherdata['VISIB'] : $this->extrapolateData($weatherdata['STN'], 'visib'),
            'wdsp' => $weatherdata['WDSP'] !== "None" ? 
                $weatherdata['WDSP'] : $this->extrapolateData($weatherdata['STN'], 'wdsp'),
            'prcp' => $weatherdata['PRCP'] !== "None" ? 
                $weatherdata['PRCP'] : $this->extrapolateData($weatherdata['STN'], 'prcp'),
            'sndp' => $weatherdata['SNDP'] !== "None" ? 
                $weatherdata['SNDP'] : $this->extrapolateData($weatherdata['STN'], 'sndp'),
            'frshtt' => $weatherdata['FRSHTT'] !== "None" ? 
                $weatherdata['FRSHTT'] : $this->extrapolateData($weatherdata['STN'], 'frshtt'),
            'cldc' => $weatherdata['CLDC'] !== "None" ? 
                $weatherdata['CLDC'] : $this->extrapolateData($weatherdata['STN'], 'cldc'),
            'winddir' => $weatherdata['WNDDIR'] !== "None" ? 
                $weatherdata['WNDDIR'] : $this->extrapolateData($weatherdata['STN'], 'winddir'),
        );
        return $data;
    }

    private function extrapolateData(string $stationnumber, string $key)
    {
        // Take last known entry of key and sets it to that value
        $lastValue = DB::table('measurement')
                ->where('station', "=", "" . $stationnumber)
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->limit(1)
                ->select($key)
                ->get();

        // Returns $lastValue, or if $lastValue could not be found null
        return $lastValue ? $lastValue : null;

        // ToDo: Add data extrapolation with frenchCurveExtrapolation?
        // $lastMeasurements = DB::table('measurement')
        //         ->where('station', "=", "" . $stationnumber)
        //         ->orderBy('date', 'desc')
        //         ->orderBy('time', 'desc')
        //         ->limit(30)
        //         ->select($key)
        //         ->get();
    }
}
