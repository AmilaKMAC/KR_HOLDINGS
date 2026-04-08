<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Sign In</title>

    <link href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/bootstrap/font/bootstrap-icons.min.css') }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">

    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            overflow: hidden;
            height: 100%;
            background: radial-gradient(circle, rgb(21, 45, 68) 70%);
        }

        .bg-image-col {
            background-image: url('{{ asset('assets/images/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            border-radius: 0 30px 30px 0;
        }

        .login-col {
            min-height: 100vh;
            background-color: #212529;
            background-image: radial-gradient(
                circle,
                rgba(31, 113, 185, 0.8) 10%,
                rgb(21, 45, 68) 80%
            );
            color: white;
        }

        .card {
            max-width: 400px;
            border-radius: 15px;
        }
    </style>

</head>

<body>

    <div class="container-fluid p-0">
        <div class="row g-0">

            <!-- Background Image Column -->
            <div class="col-lg-6 bg-image-col d-none d-lg-block"></div>

            <!-- Login Form Column -->
            <div class="col-lg-6 col-12 login-col d-flex align-items-center justify-content-center">
                <div class="card p-5 m-3">

                    <h2 class="fw-bold text-center">Welcome to the Subcontract Management System</h2>
                    <p class="text-muted">Sign In</p>

                    {{-- Error Message --}}
                    @if ($errors->any())
                        <div class="alert alert-danger py-2 small">
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.post') }}">
                        @csrf

                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-person"></i>
                            </span>
                            <input type="text"
                                name="username"
                                class="form-control border-start-0"
                                placeholder="Username"
                                value="{{ old('username') }}"
                                required autofocus>
                        </div>

                        <div class="mb-3 input-group">
                            <span class="input-group-text bg-transparent border-end-0">
                                <i class="bi bi-lock"></i>
                            </span>
                            <input type="password"
                                name="password"
                                class="form-control border-start-0"
                                placeholder="Password"
                                required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Login</button>

                    </form>

                    <a href="#" class="text-center mt-3 text-decoration-none small">Forgot Password</a>

                </div>
            </div>

        </div>
    </div>

</body>

</html>