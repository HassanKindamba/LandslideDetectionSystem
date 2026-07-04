@extends('layouts.admin')

@section('content')

<div class="container text-center mt-5">

    <h2>🚨 Landslide Alerts</h2>

    <div id="alertBox" style="
        margin-top:20px;
        padding:30px;
        border-radius:15px;
        font-size:20px;
        font-weight:bold;
        background:#eee;
    ">
        Loading alerts...
    </div>

    <div id="alertDetail" style="
        margin-top:15px;
        font-size:14px;
        font-weight:normal;
        color:#555;
    "></div>

</div>

<script>

function getReasons(data) {
    let reasons = [];

    if (data.tilt == 1) reasons.push("Tilt sensor triggered");
    if (data.vibration == 1) reasons.push("Vibration detected");
    if (data.soil_moisture > 70) reasons.push("Soil moisture critically high (" + data.soil_moisture + "%)");
    else if (data.soil_moisture > 50) reasons.push("Soil moisture elevated (" + data.soil_moisture + "%)");

    return reasons.length ? reasons.join(" | ") : "All sensors normal";
}

async function loadAlert() {

    const res = await fetch('/live-data');
    const data = await res.json();

    let box = document.getElementById('alertBox');
    let detail = document.getElementById('alertDetail');

    detail.innerText = "Last reading: " + data.time + " — " + getReasons(data);

    if (data.risk === "HIGH") {

        box.style.background = "red";
        box.style.color = "white";
        box.innerHTML = "⚠ HIGH RISK DETECTED! POSSIBLE LANDSLIDE!";

    } else if (data.risk === "MEDIUM") {

        box.style.background = "orange";
        box.style.color = "white";
        box.innerHTML = "⚠ MEDIUM RISK - MONITOR AREA";

    } else {

        box.style.background = "green";
        box.style.color = "white";
        box.innerHTML = "✅ ALL SAFE - LOW RISK";
    }
}

// auto refresh
setInterval(loadAlert, 3000);
loadAlert();

</script>

@endsection