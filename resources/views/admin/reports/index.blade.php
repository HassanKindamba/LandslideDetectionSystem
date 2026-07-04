@extends('layouts.admin')

@section('content')

<div class="container mt-4">

    {{-- PAGE TITLE --}}
    <div class="d-flex justify-content-between align-items-center mb-3 no-print">

        <h3 class="mb-0">Sensor Reports</h3>

        <button onclick="window.print()" class="btn btn-outline-dark">
            🖨️ Print Report
        </button>

    </div>

    {{-- FILTER CARD --}}
    <div class="card mb-3 shadow-sm no-print">

        <div class="card-body">

            <form method="GET" action="{{ route('reports.index') }}" class="row g-3">

                <div class="col-md-3">
                    <label class="form-label">From Date</label>
                    <input type="date"
                           name="from_date"
                           value="{{ request('from_date') }}"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">To Date</label>
                    <input type="date"
                           name="to_date"
                           value="{{ request('to_date') }}"
                           class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Risk Level</label>

                    <select name="risk_level" class="form-control">

                        <option value="">All</option>

                        <option value="LOW" {{ request('risk_level')=='LOW' ? 'selected' : '' }}>
                            LOW
                        </option>

                        <option value="MEDIUM" {{ request('risk_level')=='MEDIUM' ? 'selected' : '' }}>
                            MEDIUM
                        </option>

                        <option value="HIGH" {{ request('risk_level')=='HIGH' ? 'selected' : '' }}>
                            HIGH
                        </option>

                    </select>

                </div>

                <div class="col-md-3 d-flex align-items-end gap-2">

                    <button class="btn btn-primary w-100">
                        Filter
                    </button>

                    <a href="{{ route('reports.index') }}" class="btn btn-secondary w-100">
                        Reset
                    </a>

                </div>

            </form>

        </div>

    </div>

    {{-- PRINT HEADER (inaonekana tu wakati wa print) --}}
    <div class="print-only mb-3">
        <h3>Landslide Detection - Sensor Report</h3>
        <p>Generated: {{ now()->format('d M Y H:i') }}</p>
        <hr>
    </div>

    {{-- TABLE CARD --}}
    <div class="card shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover table-bordered align-middle">

                    <thead class="table-dark">

                        <tr>

                            <th>#</th>
                            <th>Soil Moisture</th>
                            <th>Vibration</th>
                            <th>Tilt</th>
                            <th>Risk Level</th>
                            <th>Date & Time</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($reports as $report)

                        <tr>

                            <td>{{ $loop->iteration }}</td>

                            <td>{{ $report->soil_moisture }}%</td>

                            <td>
                                @if($report->vibration == 1)
                                    <span class="text-danger fw-bold">⚠ Detected</span>
                                @else
                                    Normal
                                @endif
                            </td>

                            <td>
                                @if($report->tilt == 1)
                                    <span class="text-danger fw-bold">⚠ Detected</span>
                                @else
                                    Normal
                                @endif
                            </td>

                            <td>

                                @if($report->risk_level=="HIGH")

                                    <span class="badge bg-danger px-3 py-2">
                                        HIGH
                                    </span>

                                @elseif($report->risk_level=="MEDIUM")

                                    <span class="badge bg-warning text-dark px-3 py-2">
                                        MEDIUM
                                    </span>

                                @else

                                    <span class="badge bg-success px-3 py-2">
                                        LOW
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $report->created_at->format('d M Y H:i') }}
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <b>No Reports Found</b>
                            </td>
                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3 no-print">
                {{ $reports->links() }}
            </div>

        </div>

    </div>

</div>

<style>
    .print-only {
        display: none;
    }

    @media print {
        .no-print {
            display: none !important;
        }

        .print-only {
            display: block !important;
        }

        .card {
            box-shadow: none !important;
            border: none !important;
        }

        body {
            background: white !important;
        }
    }
</style>

@endsection