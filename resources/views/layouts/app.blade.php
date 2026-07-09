<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Management - @yield('title')</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            background: #f4f6f9;
            padding-top: 20px;
        }

        .navbar {
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .08);
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
        }

        .stat-card {
            transition: .3s;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .table tbody tr:hover {
            background: #f8f9fa;
        }

        .table-primary th {
            color: white;
        }

        .date-filter {
            background: #fff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 30px;
            font-size: 13px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-in_progress {
            background: #cce5ff;
            color: #004085;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .btn {
            border-radius: 8px;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .page-title {
            font-weight: 700;
        }

        .date-preset {
            border-radius: 20px;
            padding: 6px 15px;
            font-weight: 500;
            transition: .3s;
        }


        .date-preset:hover {

            transform: translateY(-2px);

        }

        .date-preset.active {

            background: #0d6efd;
            color: white;
            border-color: #0d6efd;

        }
    </style>

    @stack('styles')

</head>

<body>

    <div class="container">

        <!-- Navbar -->

        <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">

            <div class="container-fluid">

                <a class="navbar-brand" href="{{ route('tasks.index') }}">
                    <i class="bi bi-check2-square text-primary"></i>
                    Task Manager
                </a>

                <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#navbarNav">

                    <span class="navbar-toggler-icon"></span>

                </button>

                <div class="collapse navbar-collapse" id="navbarNav">

                    <ul class="navbar-nav ms-auto">

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('tasks.index') }}">
                                <i class="bi bi-house"></i>
                                Dashboard
                            </a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link" href="{{ route('tasks.create') }}">
                                <i class="bi bi-plus-circle"></i>
                                Add Task
                            </a>

                        </li>

                    </ul>

                </div>

            </div>

        </nav>

        @yield('content')

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- Success Message --}}
    @if(session('success'))

    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session("success") }}',
            timer: 2000,
            showConfirmButton: false
        });
    </script>

    @endif


    {{-- Error Message --}}
    @if(session('error'))

    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session("error") }}'
        });
    </script>

    @endif


    {{-- Validation Errors --}}
    @if($errors->any())

    <script>
        Swal.fire({
            icon: 'warning',
            title: 'Validation Error',
            html: `{!! implode('<br>', $errors->all()) !!}`
        });
    </script>

    @endif

    @stack('scripts')

</body>

</html>