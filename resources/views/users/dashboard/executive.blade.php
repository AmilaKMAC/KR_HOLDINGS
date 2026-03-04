@extends('layout.app')

@section('content')
    <div class="container-fluid py-4">

        <!-- ================= KPI CARDS (TABLE STYLE STRUCTURE) ================= -->
        @php
            $stats = [
                [
                    'title' => 'Overall Completion Rate (%)',
                    'value' => 82,
                    'color' => 'success',
                ],
                [
                    'title' => 'Overall Attendance Reliability',
                    'value' => 91,
                    'color' => 'primary',
                ],
                [
                    'title' => 'Total Technicians',
                    'value' => 24,
                    'color' => 'info',
                ],
                [
                    'title' => 'Total Projects Handled This Month',
                    'value' => 18,
                    'color' => 'warning',
                ],
            ];
        @endphp

        <div class="row g-4 mb-4">
            @foreach ($stats as $stat)
                <div class="col-12 col-md-6 col-xl-3">
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


        <!-- ================= CHART SECTION ================= -->
        <div class="row g-4 mt-5">

            <!-- Completion Rate (Area Chart) -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center bg-secondary text-white">
                        <h4 class="fw-bold mb-0">Completion Rate</h4>
                    </div>
                </div>

                <div class="card-body">
                    <canvas id="completionChart"></canvas>
                </div>
            </div>

            <!-- Attendance Reliability (Line Chart) -->
            <div class="col-12 col-lg-6">
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center bg-primary text-white">
                        <h4 class="fw-bold mb-0">Attendance Reliability</h4>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="attendanceChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Partner Completion (Bar Chart) -->
        <div class="row mt-5 justify-content-center">

            <div class="col-12 col-xxl-8 col-lg-6 col-md-12">
                <div class="card shadow-sm mb-3">
                    <div class="card-body text-center bg-success text-white">
                        <h4 class="fw-bold mb-0">Partner Completion</h4>
                    </div>
                </div>

                <div class="card shadow-sm">
                    <div class="card-body">
                        <canvas id="partnerChart"></canvas>
                    </div>
                </div>
            </div>

        </div>
    </div>





    <!-- Chart.js -->
    <script src="{{ asset('assets/bootstrap/js/chart.umd.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            new Chart(document.getElementById('completionChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Completion %',
                        data: [20, 35, 50, 65, 75, 90],
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            new Chart(document.getElementById('attendanceChart'), {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                    datasets: [{
                        label: 'Attendance %',
                        data: [30, 70, 45, 85, 70, 95],
                        tension: 0.4
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

            new Chart(document.getElementById('partnerChart'), {
                type: 'bar',
                data: {
                    labels: ['Partner 1', 'Partner 2', 'Partner 3', 'Partner 4', 'Partner 5'],
                    datasets: [{
                        label: 'Completed Projects',
                        data: [5, 8, 12, 4, 9]
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

        });
    </script>
@endsection
