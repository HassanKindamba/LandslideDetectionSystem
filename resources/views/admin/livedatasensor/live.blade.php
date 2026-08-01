@extends('layouts.admin')

@section('content')

<div class="container">

    <h2 class="text-center mb-4">🌱 Live Sensor Data</h2>

    <style>
        body {
            font-family: Arial, sans-serif;
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
            background: #dc3545;
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }

        .medium {
            background: #ffc107;
            color: #212529;
            font-weight: bold;
            border-radius: 5px;
        }

        .low {
            background: #198754;
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }
    </style>

    <div class="table-box">
        <table>
            <thead>
                <tr>
                    <th>Time</th>
                    <th>Soil Moisture (%)</th>
                    <th>Vibration</th>
                    <th>Tilt Angle</th>
                    <th>Risk Level</th>
                </tr>
            </thead>

            <tbody>
                <tr>
                    <td id="time">--:--:--</td>
                    <td id="soil">-- %</td>
                    <td id="vibration">--</td>
                    <td id="tilt">--</td>
                    <td><span id="risk" style="padding: 6px 12px; display: inline-block;">--</span></td>
                </tr>
            </tbody>
        </table>
    </div>

</div>

<script>

async function loadData() {
    try {
        // Kuomba data kutoka live-api na kuzuia cache kwa kutumia timestamp (?t=)
        const res = await fetch('/api/live-api?t=' + new Date().getTime(), {
            cache: 'no-store'
        });
        const data = await res.json();

        if (data) {
            // Muda
            document.getElementById('time').innerText = data.time ?? '--:--:--';

            // Values Conversions
            let soilValue = parseFloat(data.soil_moisture ?? 0);
            let vibValue  = parseFloat(data.vibration ?? 0);
            let tiltValue = parseFloat(data.tilt ?? 0);

            // Kuweka values kwenye database table
            document.getElementById('soil').innerText = soilValue.toFixed(1) + " %";
            document.getElementById('vibration').innerText = vibValue > 0.05 ? vibValue.toFixed(3) : "0.000";
            document.getElementById('tilt').innerText = tiltValue.toFixed(1) + " °";

            // Risk Level Styling
            let riskCell = document.getElementById('risk');
            let currentRisk = (data.risk || data.risk_level || 'LOW').toUpperCase();
            
            riskCell.innerText = currentRisk;
            riskCell.className = ""; // Futa class za zamani

            if (currentRisk === "HIGH") {
                riskCell.classList.add("high");
            } else if (currentRisk === "MEDIUM") {
                riskCell.classList.add("medium");
            } else {
                riskCell.classList.add("low");
            }
        }
    } catch (error) {
        console.error("Error fetching live data:", error);
    }
}

// Refresh kila baada ya sekunde 0.5 (500 ms)
setInterval(loadData, 500);

// On-load initial call
loadData();

</script>

@endsection