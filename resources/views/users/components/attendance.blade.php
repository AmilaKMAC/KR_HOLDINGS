@extends('layout.app')

@section('title', 'Attendance')

@section('content')

<div class="container-fluid py-5">

    <!-- Page Title -->
    <div class="row mb-5">
        <div class="col-12 text-center">
            <h2 class="fw-bold">Attendance</h2>
        </div>
    </div>

    <!-- Attendance Card Section -->
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-8 col-sm-10">

            <div class="card border-dark shadow-sm rounded-4">
                <div class="card-body text-center py-5">

                    <h4 class="mb-4">Attend to the Site</h4>

                    <!-- Yes Button -->
                    <button class="btn btn-primary px-5 py-2 mb-4">
                        Yes
                    </button>

                    <!-- Date -->
                    <div class="fs-5 fw-medium">
                        2025-10-12
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

@endsection