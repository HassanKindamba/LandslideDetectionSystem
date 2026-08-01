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
            "risk" => (rand(0, 2) == 0 ? "LOW" : (rand(0, 1) ? "MEDIUM" : "HIGH")),
            "time" => now()->format('H:i:s')
        ]);
    }

    public function liveApi()
    {
        // Kuchukuwa record ya mwisho kabisa kuingia kwenye database
        $latest = SensorData::orderBy('id', 'desc')->first();

        if (!$latest) {
            return response()->json([
                "soil_moisture" => 0,
                "vibration"     => 0,
                "tilt"          => 0,
                "risk"          => "LOW",
                "risk_level"    => "LOW",
                "time"          => now()->format('H:i:s')
            ]);
        }

        // Real-time values conversion
        $soil = (float) $latest->soil_moisture;
        $vib  = (float) $latest->vibration;
        $tilt = (float) $latest->tilt;

        // Dynamic Calculation ili kuhakikisha risk inasoma hapo hapo bila delay
        if ($soil >= 70 || $tilt >= 30.0 || $vib >= 1.5) {
            $computedRisk = "HIGH";
        } elseif ($soil >= 40 || $tilt >= 15.0 || $vib >= 0.5) {
            $computedRisk = "MEDIUM";
        } else {
            $computedRisk = "LOW";
        }

        // Format ya muda
        $formattedTime = $latest->created_at 
            ? $latest->created_at->format('H:i:s') 
            : now()->format('H:i:s');

        return response()->json([
            "soil_moisture" => $soil,
            "vibration"     => $vib,
            "tilt"          => $tilt,
            "risk"          => $latest->risk_level ?? $computedRisk,
            "risk_level"    => $latest->risk_level ?? $computedRisk,
            "time"          => $formattedTime
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'soil_moisture' => 'required|numeric',
            'vibration'     => 'required|numeric',
            'tilt'          => 'required|numeric',
            'risk_level'    => 'nullable|string',
        ]);

        
        if ($request->filled('risk_level')) {
            $risk = strtoupper($request->risk_level);
        } else {
            // 2. Logic ya Risk: Sensor YOYOTE ikivuka kiwango cha HIGH, Risk inakuwa HIGH!
            if ($request->soil_moisture >= 70 || $request->tilt >= 30.0 || $request->vibration >= 1.5) {
                $risk = "HIGH";
            } elseif ($request->soil_moisture >= 40 || $request->tilt >= 15.0 || $request->vibration >= 0.5) {
                $risk = "MEDIUM";
            } else {
                $risk = "LOW";
            }
        }

        // 3. kuifazi kwenye Database
        $sensor = SensorData::create([
            'soil_moisture' => $request->soil_moisture,
            'vibration'     => $request->vibration,
            'tilt'          => $request->tilt,
            'risk_level'    => $risk
        ]);

        return response()->json([
            'message' => 'Data received successfully',
            'risk'    => $risk,
            'data'    => $sensor
        ], 201);
    }
}