@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- ================= TOP ACTION BUTTONS ================= -->
        <div class="d-flex justify-content-end align-items-center gap-3 mb-4">

            <button class="btn btn-outline-dark">
                Upload Images
            </button>

            <button class="btn btn-outline-dark">
                Attendance Reminder
            </button>

            <div class="rounded-circle border d-flex justify-content-center align-items-center"
                style="width:60px; height:60px;">
                Profile
            </div>

        </div>


        <!-- ================= ONGOING PROJECTS ================= -->
        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center bg-dark text-white">
                    <h5 class="fw-bold mb-0">Ongoing Projects</h5>
                </div>
            </div>

            <div class="card shadow-sm mb-5">

                <div class="card-body table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>Project ID</th>
                                <th>Customer Name</th>
                                <th>Location</th>
                                <th>Contact Number</th>
                                <th>Capacity</th>
                                <th>Partner Company</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>P01</td>
                                <td>SK Lal</td>
                                <td>URL</td>
                                <td>076xxxxx</td>
                                <td>5kW</td>
                                <td>Hayleys</td>
                            </tr>
                            <tr>
                                <td>P02</td>
                                <td>RS Silva</td>
                                <td>URL</td>
                                <td>070xxxxx</td>
                                <td>10kW</td>
                                <td>Hayleys</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        @php
            $stats = [
                [
                    'title' => 'Working Days',
                    'value' => 12,
                    'color' => 'primary',
                ],
                [
                    'title' => 'Absent Days',
                    'value' => 2,
                    'color' => 'danger',
                ],
                [
                    'title' => 'Attendance Reliability %',
                    'value' => 91,
                    'color' => 'success',
                ],
            ];
        @endphp


        <!-- ================= ATTENDANCE KPI BOXES ================= -->
        <div class="row g-4 mb-5 text-center">

            @foreach ($stats as $stat)
                <div class="col-12 col-md-6 col-xl-4">
                    <div class="card shadow-sm h-100">

                        <!-- Header (Separated like table header) -->
                        <div class="card-header bg-{{ $stat['color'] }} text-white fw-semibold text-center">
                            {{ $stat['title'] }}
                        </div>

                        <!-- Body -->
                        <div class="card-body text-center">
                            <h2 class="fw-bold mb-0 text-{{ $stat['color'] }}">
                                {{ $stat['value'] }}
                            </h2>
                        </div>

                    </div>
                </div>
            @endforeach

        </div>


        <!-- ================= PERFORMANCE SUMMARY ================= -->
        <div class="card shadow-sm mb-5">
            <div class="card-body text-center">
                <div class="row">

                    <div class="col-md-4">
                        <h6 class="fw-semibold">Ongoing Projects</h6>
                        <h5 class="fw-bold">3</h5>
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-semibold">Completed Projects</h6>
                        <h5 class="fw-bold">25</h5>
                    </div>

                    <div class="col-md-4">
                        <h6 class="fw-semibold">Project Completion Rate</h6>
                        <h5 class="fw-bold text-success">89%</h5>
                    </div>

                </div>
            </div>
        </div>

    </div>
@endsection
