@extends('layouts.admin')

@section('content')

<div class="container text-center mt-5">

    <h2>🚨 Landslide Alerts</h2>

    <div id="alertBox" style="
        margin-top:20px;
        padding:30px;
        border-radius:15px;
        font-size:22px;
        font-weight:bold;
        background:#eee;
        transition: all 0.5s ease;
        box-shadow: 0px 4px 15px rgba(0,0,0,0.1);
    ">
        Loading alerts...
    </div>

    <div id="alertDetail" style="
        margin-top:20px;
        font-size:16px;
        font-weight:600;
        color:#444;
    "></div>

</div>

<style>
    @keyframes pulse-red {
        0% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0.7); }
        70% { box-shadow: 0 0 0 20px rgba(220, 53, 69, 0); }
        100% { box-shadow: 0 0 0 0 rgba(220, 53, 69, 0); }
    }
    .pulse-danger {
        animation: pulse-red 1.5s infinite;
    }
</style>

<script>

function getReasons(data) {
    let reasons = [];
    
    let soil = parseFloat(data.soil_moisture ?? 0);
    let vib  = parseFloat(data.vibration ?? 0);
    let tilt = parseFloat(data.tilt ?? 0);

    // Vibration trigger
    if (vib >= 1.5) {
        reasons.push("High ground vibration detected (" + vib.toFixed(2) + ")");
    } else if (vib >= 0.5) {
        reasons.push("Minor vibration detected (" + vib.toFixed(2) + ")");
    }

    // Tilt trigger
    if (tilt >= 30) {
        reasons.push("Critical slope tilt angle (" + tilt.toFixed(1) + "°)");
    } else if (tilt >= 15) {
        reasons.push("Elevated slope movement (" + tilt.toFixed(1) + "°)");
    }

    // Soil Moisture trigger
    if (soil >= 70) {
        reasons.push("Soil saturation critically high (" + soil.toFixed(1) + "%)");
    } else if (soil >= 50) {
        reasons.push("Soil moisture elevated (" + soil.toFixed(1) + "%)");
    }

    return reasons.length ? reasons.join(" | ") : "All sensors within normal limits";
}

async function loadAlert() {
    try {
        // Fetch Live API na kuzuia cache
        const res = await fetch('/api/live-api?t=' + new Date().getTime(), {
            cache: 'no-store'
        });
        const data = await res.json();

        let box = document.getElementById('alertBox');
        let detail = document.getElementById('alertDetail');

        if (data) {
            let risk = (data.risk || data.risk_level || 'LOW').toUpperCase();
            let timeStr = data.time ?? '--:--:--';

            detail.innerText = "Last Update: " + timeStr + " — " + getReasons(data);

            if (risk === "HIGH") {
                box.style.background = "#dc3545";
                box.style.color = "white";
                box.innerHTML = "⚠ HIGH RISK DETECTED! POSSIBLE LANDSLIDE!";
                box.classList.add("pulse-danger");

            } else if (risk === "MEDIUM") {
                box.style.background = "#ffc107";
                box.style.color = "#212529";
                box.innerHTML = "⚠ MEDIUM RISK - MONITOR AREA CLOSELY";
                box.classList.remove("pulse-danger");

            } else {
                box.style.background = "#198754";
                box.style.color = "white";
                box.innerHTML = "✅ ALL SAFE - LOW RISK";
                box.classList.remove("pulse-danger");
            }
        }
    } catch (error) {
        console.error("Error fetching alert data:", error);
    }
}

// Auto refresh kila sekunde 2
setInterval(loadAlert, 500);

// Initial load
loadAlert();

</script>

@endsection