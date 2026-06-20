@extends('layouts.admin')

@section('page-title', 'Dashboard Overview')
@section('page-subtitle', 'Real-time landslide sensor monitoring for mining areas')

@section('styles')
<style>
    .stat-card {
        border: none;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.12);
    }

    .stat-card .card-body {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 22px;
    }

    .stat-icon {
        width: 55px;
        height: 55px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #fff;
        flex-shrink: 0;
    }

    .icon-blue   { background: linear-gradient(135deg, #1565c0, #0d47a1); }
    .icon-red    { background: linear-gradient(135deg, #e53935, #b71c1c); }
    .icon-green  { background: linear-gradient(135deg, #43a047, #2e7d32); }
    .icon-orange { background: linear-gradient(135deg, #fb8c00, #ef6c00); }

    .stat-card h5 {
        margin: 0;
        font-weight: 700;
        font-size: 1.4rem;
        color: #1d2939;
    }

    .stat-card p.label {
        margin: 0;
        color: #6c757d;
        font-size: 0.85rem;
        font-weight: 500;
    }

    .stat-card .desc {
        margin: 0;
        color: #98a2b3;
        font-size: 0.78rem;
    }

    .section-block {
        background: #fff;
        border-radius: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        padding: 22px;
        margin-top: 25px;
    }

    .section-block h5 {
        color: var(--primary-blue);
        font-weight: 700;
        margin-bottom: 15px;
    }

    .status-pill {
        font-size: 0.75rem;
        font-weight: 600;
        padding: 4px 12px;
        border-radius: 50px;
    }

    .status-active {
        background: rgba(67,160,71,0.12);
        color: #2e7d32;
    }

    .status-warning {
        background: rgba(251,140,0,0.12);
        color: #ef6c00;
    }
</style>
@endsection

@section('content')

<!-- ===== STAT CARDS ===== -->
<div class="row g-4">

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon icon-blue">
                    <i class="bi bi-cpu"></i>
                </div>
                <div>
                    <h5>{{ $totalSensors ?? '08' }}</h5>
                    <p class="label">Active Sensors</p>
                    <p class="desc">ESP32 nodes online</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon icon-red">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div>
                    <h5>{{ $totalAlerts ?? '03' }}</h5>
                    <p class="label">Active Alerts</p>
                    <p class="desc">Landslide risk warnings</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon icon-green">
                    <i class="bi bi-file-earmark-bar-graph"></i>
                </div>
                <div>
                    <h5>{{ $totalReports ?? '12' }}</h5>
                    <p class="label">Reports Generated</p>
                    <p class="desc">Monthly summaries</p>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="card stat-card">
            <div class="card-body">
                <div class="stat-icon icon-orange">
                    <i class="bi bi-people"></i>
                </div>
                <div>
                    <h5>{{ $totalUsers ?? '25' }}</h5>
                    <p class="label">Registered Users</p>
                    <p class="desc">Mining site personnel</p>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- ===== DETAIL SECTIONS ===== -->
<div class="row mt-2">

    <div class="col-md-7">
        <div class="section-block">
            <h5><i class="bi bi-activity me-2"></i>Sensor Data</h5>
            <p class="text-muted small mb-3">Live readings from Vibration, Soil Moisture, and Tilt sensors.</p>

            <table class="table table-borderless align-middle mb-0">
                <thead>
                    <tr class="text-muted small text-uppercase">
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
                        <td>2.4 Hz</td>
                        <td><span class="status-pill status-active">Normal</span></td>
                    </tr>
                    <tr>
                        <td>Soil Moisture</td>
                        <td>Zone B</td>
                        <td>78%</td>
                        <td><span class="status-pill status-warning">High</span></td>
                    </tr>
                    <tr>
                        <td>Tilt Sensor</td>
                        <td>Zone C</td>
                        <td>1.2°</td>
                        <td><span class="status-pill status-active">Normal</span></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="col-md-5">
        <div class="section-block">
            <h5><i class="bi bi-exclamation-triangle me-2"></i>Recent Alerts</h5>
            <p class="text-muted small mb-3">Latest landslide warnings detected.</p>

            <ul class="list-unstyled mb-0">
                <li class="d-flex justify-content-between border-bottom py-2">
                    <span>High soil moisture - Zone B</span>
                    <span class="status-pill status-warning">2h ago</span>
                </li>
                <li class="d-flex justify-content-between border-bottom py-2">
                    <span>Tilt threshold exceeded - Zone D</span>
                    <span class="status-pill status-warning">5h ago</span>
                </li>
                <li class="d-flex justify-content-between py-2">
                    <span>Vibration spike - Zone A</span>
                    <span class="status-pill status-active">Resolved</span>
                </li>
            </ul>
        </div>
    </div>

</div>

@endsection