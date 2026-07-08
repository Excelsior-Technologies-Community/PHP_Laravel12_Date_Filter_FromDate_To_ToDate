@extends('layouts.app')

@section('title', 'Tasks List')

@section('content')

    {{-- Dashboard Statistics --}}

    <div class="row mb-4">

        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Total Tasks</h6>
                    <h3 class="fw-bold text-primary">
                        {{ $stats['total'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Pending</h6>
                    <h3 class="fw-bold text-warning">
                        {{ $stats['pending'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">In Progress</h6>
                    <h3 class="fw-bold text-info">
                        {{ $stats['progress'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Completed</h6>
                    <h3 class="fw-bold text-success">
                        {{ $stats['completed'] }}
                    </h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center">
                    <h6 class="text-muted">Today's Tasks</h6>
                    <h3 class="fw-bold text-danger">
                        {{ $stats['today'] }}
                    </h3>
                </div>
            </div>
        </div>

    </div>

    {{-- Filter Section --}}

    <div class="date-filter">

        <h5 class="mb-3">
            <i class="bi bi-funnel"></i>
            Search & Filter Tasks
        </h5>

        <form method="GET" action="{{ route('tasks.index') }}">

            <div class="row">

                {{-- Search --}}

                <div class="col-md-3 mb-3">
                    <label class="form-label">
                        Search
                    </label>

                    <input type="text" name="search" class="form-control" placeholder="Search title or description..."
                        value="{{ request('search') }}">
                </div>

                {{-- From Date --}}

                <div class="col-md-2 mb-3">
                    <label class="form-label">
                        From Date
                    </label>

                    <input type="date" name="from_date" id="from_date" class="form-control"
                        value="{{ request('from_date') }}">
                </div>

                {{-- To Date --}}

                <div class="col-md-2 mb-3">
                    <label class="form-label">
                        To Date
                    </label>

                    <input type="date" name="to_date" id="to_date" class="form-control" value="{{ request('to_date') }}">
                </div>

                {{-- Status --}}

                <div class="col-md-2 mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status" class="form-select">

                        <option value="all">
                            All Status
                        </option>

                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>
                            In Progress
                        </option>

                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>
                            Completed
                        </option>

                    </select>

                </div>

                {{-- Sort --}}

                <div class="col-md-3 mb-3">

                    <label class="form-label">
                        Sort By
                    </label>

                    <select name="sort" class="form-select">

                        <option value="latest">
                            Latest Tasks
                        </option>

                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>
                            Oldest Tasks
                        </option>

                        <option value="title_asc" {{ request('sort') == 'title_asc' ? 'selected' : '' }}>
                            Title A-Z
                        </option>

                        <option value="title_desc" {{ request('sort') == 'title_desc' ? 'selected' : '' }}>
                            Title Z-A
                        </option>

                    </select>

                </div>

            </div>

            <div class="mt-2">

                <button type="submit" class="btn btn-primary">

                    <i class="bi bi-search"></i>
                    Apply Filter

                </button>

                <a href="{{ route('tasks.index') }}" class="btn btn-secondary">

                    <i class="bi bi-arrow-clockwise"></i>
                    Reset

                </a>

            </div>

        </form>

    </div>

    {{-- Task List --}}

    <div class="card">

        <div class="card-header d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="bi bi-list-task"></i>
                Task List
            </h5>

            <span class="badge bg-primary fs-6">
                {{ $tasks->total() }} Tasks Found
            </span>

        </div>

        <div class="card-body">

            @if($tasks->count())

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>

                                <th>#</th>

                                <th>Title</th>

                                <th>Description</th>

                                <th>Task Date</th>

                                <th>Status</th>

                                <th width="180">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach($tasks as $task)

                                <tr>

                                    <td>
                                        {{ $loop->iteration + ($tasks->currentPage() - 1) * $tasks->perPage() }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $task->title }}
                                        </strong>
                                    </td>

                                    <td>
                                        {{ \Illuminate\Support\Str::limit($task->description, 50) }}
                                    </td>

                                    <td>
                                        <span class="badge bg-light text-dark">
                                            <i class="bi bi-calendar-event"></i>
                                            {{ $task->task_date->format('d M Y') }}
                                        </span>
                                    </td>

                                    <td>
                                        @if($task->status == 'pending')
                                            <span class="status-badge status-pending">
                                                Pending
                                            </span>
                                        @elseif($task->status == 'in_progress')
                                            <span class="status-badge status-in_progress">
                                                In Progress
                                            </span>
                                        @else
                                            <span class="status-badge status-completed">
                                                Completed
                                            </span>
                                        @endif
                                    </td>

                                    <td>

                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">

                                            <i class="bi bi-pencil"></i>

                                        </a>

                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                            class="d-inline delete-form">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-sm btn-outline-danger">

                                                <i class="bi bi-trash"></i>

                                            </button>

                                        </form>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

                @if ($tasks->lastPage() > 1)

                    <div class="d-flex justify-content-center mt-4">

                        <nav>

                            <ul class="pagination">

                                @for ($i = 1; $i <= $tasks->lastPage(); $i++)

                                    <li class="page-item {{ $tasks->currentPage() == $i ? 'active' : '' }}">

                                        <a class="page-link" href="{{ $tasks->appends(request()->query())->url($i) }}">

                                            {{ $i }}

                                        </a>

                                    </li>

                                @endfor

                            </ul>

                        </nav>

                    </div>

                @endif

            @else

                <div class="text-center py-5">

                    <i class="bi bi-inbox display-1 text-secondary"></i>

                    <h4 class="mt-3">
                        No Tasks Found
                    </h4>

                    <p class="text-muted">

                        No records match your search or filter.

                    </p>

                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">

                        <i class="bi bi-plus-circle"></i>

                        Create Task

                    </a>

                </div>

            @endif

        </div>

    </div>

@endsection

@push('scripts')

    <script>

        document.querySelectorAll('.delete-form').forEach(function (form) {

            form.addEventListener('submit', function (e) {

                e.preventDefault();

                Swal.fire({

                    title: 'Delete Task?',

                    text: 'You won't be able to recover this task.',

                    icon: 'warning',

                    showCancelButton: true,

                    confirmButtonColor: '#dc3545',

                    cancelButtonColor: '#6c757d',

                    confirmButtonText: 'Yes, Delete'

                }).then((result) => {

                    if (result.isConfirmed) {

                        form.submit();

                    }

                });

            });

        });

        const fromDate = document.getElementById('from_date');

        const toDate = document.getElementById('to_date');

        if (fromDate && toDate) {

            fromDate.addEventListener('change', function () {

                toDate.min = this.value;

            });

            toDate.addEventListener('change', function () {

                fromDate.max = this.value;

            });

        }

    </script>

@endpush