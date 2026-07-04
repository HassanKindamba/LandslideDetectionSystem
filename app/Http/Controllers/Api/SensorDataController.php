<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SensorData;

class SensorDataController extends Controller
{
    public function live()
    {
        return view('admin.livedatasensor.live');
    }

    public function liveFake()
    {
        return response()->json([
            "soil_moisture" => rand(40, 90),
            "vibration" => rand(1, 10),
            "tilt" => rand(5, 25),
            "risk" => (rand(0,2) == 0 ? "LOW" : (rand(0,1) ? "MEDIUM" : "HIGH")),
            "time" => now()->format('H:i:s')
        ]);
    }

public function liveApi()
{
    $latest = SensorData::latest()->first();

    if (!$latest) {
        return response()->json([
            "soil_moisture" => 0,
            "vibration" => 0,
            "tilt" => 0,
            "risk" => "LOW",
            "time" => now()->format('H:i:s')
        ]);
    }

    return response()->json([
        "soil_moisture" => $latest->soil_moisture,
        "vibration" => $latest->vibration,
        "tilt" => $latest->tilt,
        "risk" => $latest->risk_level,
        "time" => $latest->created_at->format('H:i:s')
    ]);
}

    public function store(Request $request)
    {
        $request->validate([
            'soil_moisture'=>'required|numeric',
            'vibration'=>'required|numeric',
            'tilt'=>'required|numeric',
        ]);

        // Risk Analysis
        if(
            $request->soil_moisture > 70 &&
            $request->tilt > 15 &&
            $request->vibration > 5
        ){
            $risk = "HIGH";
        }
        elseif(
            $request->soil_moisture > 50 ||
            $request->tilt > 8
        ){
            $risk = "MEDIUM";
        }
        else{
            $risk = "LOW";
        }

        $sensor = SensorData::create([
            'soil_moisture'=>$request->soil_moisture,
            'vibration'=>$request->vibration,
            'tilt'=>$request->tilt,
            'risk_level'=>$risk
        ]);

        return response()->json([
            'message'=>'Data received successfully',
            'risk'=>$risk,
            'data'=>$sensor
        ]);
    }
}