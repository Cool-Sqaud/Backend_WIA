<?php

namespace App\Http\Controllers;

use DateTime;
use App\Models\Measurement;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use MathPHP\NumericalAnalysis\Interpolation\NevillesMethod;

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
                ->where('station', '=', $stationnumber)
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
        $data = $this->validateData($request->input());

        // return Measurement::create($data);
    }

    public function storeMultiple(Request $request) {
        $result = '';
        foreach ($request->input('WEATHERDATA') as $weatherdata) {
            $data = $this->validateData($weatherdata);
            // $result += Measurement::create($data) . "\n";
        }
        return response()->json(['message'=>'added values:\n ' . $result], 200);
    }

    private function validateData(array $weatherdata): array
    {
        $timestamp = DateTime::createFromFormat('Y-m-d H:i:s', $weatherdata['DATE'] . ' ' . $weatherdata['TIME'])->getTimestamp();

        $data = array(
            'station' => $weatherdata['STN'],
            'date' => $weatherdata['DATE'],
            'time' => $weatherdata['TIME'],
            'temp' => $this->validateKey($weatherdata['STN'], 'temp', $weatherdata['TEMP'], $timestamp),
            'dewp' => $this->validateKey($weatherdata['STN'], 'dewp', $weatherdata['DEWP'], $timestamp),
            'stp' => $this->validateKey($weatherdata['STN'], 'stp', $weatherdata['STP'], $timestamp),
            'slp' => $this->validateKey($weatherdata['STN'], 'slp', $weatherdata['SLP'], $timestamp),
            'visib' => $this->validateKey($weatherdata['STN'], 'visib', $weatherdata['VISIB'], $timestamp),
            'wdsp' => $this->validateKey($weatherdata['STN'], 'wdsp', $weatherdata['WDSP'], $timestamp),
            'prcp' => $this->validateKey($weatherdata['STN'], 'prcp', $weatherdata['PRCP'], $timestamp),
            'sndp' => $this->validateKey($weatherdata['STN'], 'sndp', $weatherdata['SNDP'], $timestamp),
            'frshtt' => $this->validateKey($weatherdata['STN'], 'frshtt', $weatherdata['FRSHTT'], $timestamp),
            'cldc' => $this->validateKey($weatherdata['STN'], 'cldc', $weatherdata['CLDC'], $timestamp),
            'winddir' => $this->validateKey($weatherdata['STN'], 'winddir', $weatherdata['WNDDIR'], $timestamp),
        );
        return $data;
    }

    // Need to calculate best thresholds
    private array $keyThreshold = array(
        'temp' => 1.00,
        'dewp' => 1.00,
        'stp' => 1.00,
        'slp' => 1.00,
        'visib' => 1.00,
        'wdsp' => 1.00,
        'prcp' => 1.00,
        'sndp' => 1.00,
        'frshtt' => 1.00, // Doesnt get checked
        'cldc' => 1.00,
        'winddir' => 1.00,
    );

    private int $requiredEntries = 10;

    private function validateKey(string $stationnumber, string $key, string $value, int $timestamp): float | int | string | null
    {
        if ($key == 'frshtt') {
            if ($value == "None") return $this->getLastValue($stationnumber, $key);
            return $value;
        }
        
        $extrapolatedData = $this->getExtrapolation($stationnumber, $key, $timestamp);
        if ($extrapolatedData === null) return ($value == "None") ? null : $value; // Gets called if required entries is less then 
        $extrapolatedValue = ($key == 'winddir' ? (int)$extrapolatedData : (float)$extrapolatedData);
        
        if ($value == "None") return $extrapolatedValue;

        $threshold = abs($extrapolatedValue) * $this->keyThreshold[$key];
        return abs($value - $extrapolatedValue) <= $threshold ? $value : $extrapolatedValue;
    }

    private function getLastValue(string $stationnumber, string $key): string /*| float | int*/
    {
        //Only used for frshtt
        $lastValue = DB::table('measurement')
                ->where('station', "=", $stationnumber)
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->limit(1)
                ->select($key)
                ->get();
        echo $lastValue->$key . ' <br> <br> ';
        return $lastValue ? $lastValue->$key : null;
    }

    private function getExtrapolation(string $stationnumber, string $key, int $timestamp): float | int | null
    {    
        $lastMeasurements = DB::table('measurement')
                ->where('station', "=", $stationnumber)
                ->whereNotNull($key)
                ->orderBy('date', 'desc')
                ->orderBy('time', 'desc')
                ->limit(30)
                ->select('date', 'time', $key)
                ->get()
                ->toArray();

        if (count($lastMeasurements) < $this->requiredEntries) return null;
        
        $data = [];
        foreach ($lastMeasurements as $measurement) {
            $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $measurement->date . ' ' . $measurement->time);
            $data[] = [$datetime->getTimestamp(), $measurement->$key];
        }
        ksort($data);

        $timestamp = is_string($timestamp) ? strtotime($timestamp) : $timestamp;

        return NevillesMethod::interpolate($timestamp, $data);
    }
}
