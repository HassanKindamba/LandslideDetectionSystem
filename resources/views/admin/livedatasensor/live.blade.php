@extends('layouts.admin')

@section('content')

<div class="container">

    <h2 class="text-center mb-4">🌱 Live Sensor Data</h2>

    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        .table-box {
            display: flex;
            justify-content: center;
        }

        table {
            background: white;
            padding: 10px;
            border-radius: 10px;
            border-collapse: collapse;
            min-width: 700px;
            box-shadow: 0px 0px 10px #ccc;
        }

        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 16px;
        }

        th {
            background: #333;
            color: white;
        }

        .high {
            background: red;
            color: white;
            font-weight: bold;
        }

        .medium {
            background: orange;
            color: white;
            font-weight: bold;
        }

        .low {
            background: green;
            color: white;
            font-weight: bold;
        }
    </style>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Soil Moisture (%)</th>
                    <th>Vibration (m/s²)</th>
                    <th>Tilt (°)</th>
                    <th>Risk Level</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td id="time">--</td>
                    <td id="soil">-- %</td>
                    <td id="vibration">-- m/s²</td>
                    <td id="tilt">-- °</td>
                    <td id="risk">--</td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>

function getTime() {
    return new Date().toLocaleTimeString();
}

async function loadData() {
    const res = await fetch('/live-data');
    const data = await res.json();

    document.getElementById('time').innerText = getTime();

    // Values with units (display side)
    document.getElementById('soil').innerText = data.soil_moisture + " %";
    document.getElementById('vibration').innerText = data.vibration + " m/s²";
    document.getElementById('tilt').innerText = data.tilt + " °";

    document.getElementById('risk').innerText = data.risk;

    let riskCell = document.getElementById('risk');
    riskCell.className = "";

    if (data.risk === "HIGH") riskCell.classList.add("high");
    else if (data.risk === "MEDIUM") riskCell.classList.add("medium");
    else riskCell.classList.add("low");
}

// auto refresh every 4 seconds
setInterval(loadData, 4000);
loadData();

</script>

@endsection