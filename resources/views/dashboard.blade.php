@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')
@section('page-subtitle', 'Real-time landslide sensor monitoring for mining areas')

@section('styles')
<style>

/* ===== PAGE BACKGROUND ===== */
body {
    background: #f3f6fb;
}

/* ===== CENTER WRAPPER ===== */
.dashboard-wrapper {
    display: flex;
    justify-content: center;
    padding: 30px 15px;
}

/* ===== CARD ===== */
.section-block {
    background: #ffffff;
    border-radius: 18px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.06);
    padding: 30px;
    width: 100%;
    max-width: 1000px;
    transition: all 0.3s ease;
}

.section-block:hover {
    box-shadow: 0 12px 35px rgba(0,0,0,0.10);
    transform: translateY(-2px);
}

/* ===== TITLE ===== */
.section-block h5 {
    font-weight: 700;
    color: #1d3557;
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 18px;
}

.section-block p {
    margin-bottom: 20px;
}

/* ===== TABLE ===== */
.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 12px;
}

.table thead th {
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #6c757d;
    border: none;
    padding: 12px;
}

.table tbody tr {
    background: #f9fafb;
    border-radius: 12px;
    transition: 0.25s ease;
}

.table tbody tr:hover {
    background: #eef4ff;
    transform: scale(1.01);
}

.table td {
    border: none !important;
    padding: 14px 12px;
    font-size: 14px;
    color: #344054;
}

/* ===== STATUS ===== */
.status-pill {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 6px 14px;
    border-radius: 50px;
    display: inline-block;
}

.status-active {
    background: rgba(67,160,71,0.12);
    color: #2e7d32;
}

.status-warning {
    background: rgba(251,140,0,0.12);
    color: #ef6c00;
}

.status-danger {
    background: rgba(211,47,47,0.12);
    color: #c62828;
}

</style>
@endsection


@section('content')

<div class="dashboard-wrapper">

    <div class="section-block">

        <h5>
            <i class="bi bi-activity"></i>
            Sensor Data
        </h5>

        <p class="text-muted small">
            Live readings from Vibration, Soil Moisture, and Tilt sensors.
        </p>

        <table class="table align-middle mb-0">

            <thead>
                <tr>
                    <th>Sensor</th>
                    <th>Location</th>
                    <th>Reading</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

                <tr>
                    <td>Vibration Sensor</td>
                    <td>Zone A</td>
                    <td id="vibration">--</td>
                    <td><span id="vibStatus" class="status-pill">--</span></td>
                </tr>

                <tr>
                    <td>Soil Moisture</td>
                    <td>Zone B</td>
                    <td id="soil">--</td>
                    <td><span id="soilStatus" class="status-pill">--</span></td>
                </tr>

                <tr>
                    <td>Tilt Sensor</td>
                    <td>Zone C</td>
                    <td id="tilt">--</td>
                    <td><span id="tiltStatus" class="status-pill">--</span></td>
                </tr>

            </tbody>

        </table>

    </div>

</div>

<script>

function getStatus(risk) {
    if (risk === "HIGH") return "status-danger";
    if (risk === "MEDIUM") return "status-warning";
    return "status-active";
}

function getLabel(risk) {
    if (risk === "HIGH") return "Danger";
    if (risk === "MEDIUM") return "Warning";
    return "Normal";
}

async function loadDashboardData() {
    try {
        // kuvuta data kutoka kwenye API.
        const res = await fetch('/api/live-api');
        const data = await res.json();

        if (data) {
            // Parse numerical values safely
            let vibValue = parseFloat(data.vibration || 0);
            let soilValue = parseFloat(data.soil_moisture || 0);
            let tiltValue = parseFloat(data.tilt || 0);

            // Display raw numerical readings
            document.getElementById('vibration').innerText = vibValue > 0.1 ? vibValue.toFixed(3) : "Normal";
            document.getElementById('soil').innerText = soilValue.toFixed(1) + " %";
            document.getElementById('tilt').innerText = tiltValue.toFixed(1) + " °";

            // Status mappings according to exact thresholds
            let vibRisk = vibValue >= 1.5 ? "HIGH" : (vibValue >= 0.5 ? "MEDIUM" : "LOW");
            let soilRisk = soilValue >= 70 ? "HIGH" : (soilValue >= 40 ? "MEDIUM" : "LOW");
            let tiltRisk = tiltValue >= 30.0 ? "HIGH" : (tiltValue >= 15.0 ? "MEDIUM" : "LOW");

            //  Vibration UI Badge
            let vibEl = document.getElementById('vibStatus');
            vibEl.className = "status-pill " + getStatus(vibRisk);
            vibEl.innerText = getLabel(vibRisk);

            //  Soil Moisture UI Badge
            let soilEl = document.getElementById('soilStatus');
            soilEl.className = "status-pill " + getStatus(soilRisk);
            soilEl.innerText = getLabel(soilRisk);

            //  Tilt Sensor UI Badge
            let tiltEl = document.getElementById('tiltStatus');
            tiltEl.className = "status-pill " + getStatus(tiltRisk);
            tiltEl.innerText = getLabel(tiltRisk);
        }
    } catch (error) {
        console.error("Error fetching live sensor data:", error);
    }
}

// Auto refresh internal polling every 0.5 seconds (matching ESP32 output frequency)
setInterval(loadDashboardData, 500);
loadDashboardData();

</script>

@endsection