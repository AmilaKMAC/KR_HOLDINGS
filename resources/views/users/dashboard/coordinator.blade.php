@extends('layout.app')

@section('content')
    <div class="container-fluid mt-4">

        <!-- ================= KPI SECTION ================= -->
        <!-- ================= KPI CARDS ================= -->
        @php
            $stats = [
                [
                    'title' => 'Total Ongoing Projects',
                    'value' => 12,
                    'color' => 'success',
                ],
                [
                    'title' => 'Total Completed Projects',
                    'value' => 35,
                    'color' => 'primary',
                ],
            ];
        @endphp

        <div class="row g-4 mb-4  mb-5">
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




        <!--======================== Progress Overview ====================-->
        {{-- 
              <div class="col-12 ">
                    <div class="card shadow-sm mb-3">
                        <div class="card-body text-center bg-dark text-white">
                            <h6 class="fw-bold mb-0">Progress Overview</h6>
                        </div>
                    </div>
                </div>
            --}}


        <!-- ================= AVAILABLE TECHNICIANS ================= -->

        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center bg-dark text-white">
                    <h6 class="fw-bold mb-0">Available Technicians</h6>
                </div>
            </div>



            <div class="card shadow-sm mb-4">

                <div class="table-responsive">
                    <table class="table table-bordered text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Technician ID</th>
                                <th>Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>T04</td>
                                <td>Supun</td>
                            </tr>
                            <tr>
                                <td>T06</td>
                                <td>Anuhas</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>




        <!-- ================= PROJECT OVERVIEW ================= -->

        <div class="col-12">
            <div class="card shadow-sm mb-3">
                <div class="card-body text-center bg-info text-white">
                    <h6 class="fw-bold mb-0">Project Overview</h6>
                </div>
            </div>
            <div class="card shadow-sm">

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Project ID</th>
                                    <th>Customer Name</th>
                                    <th>Location</th>
                                    <th>Contact Number</th>
                                    <th>Capacity</th>
                                    <th>Partner Company</th>
                                    <th>Assigned Technician ID</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>P01</td>
                                    <td>SK Lal</td>
                                    <td>Colombo</td>
                                    <td>076xxxxxx</td>
                                    <td>5kW</td>
                                    <td>Hayleys</td>
                                    <td>T01, T02</td>
                                </tr>
                                <tr>
                                    <td>P02</td>
                                    <td>RS Silva</td>
                                    <td>Kandy</td>
                                    <td>070xxxxxx</td>
                                    <td>10kW</td>
                                    <td>Hayleys</td>
                                    <td>T01, T03, T05</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
