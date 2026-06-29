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

</div>

<script>

async function loadAlert() {

    const res = await fetch('/live-data');
    const data = await res.json();

    let box = document.getElementById('alertBox');

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