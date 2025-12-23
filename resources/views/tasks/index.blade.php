@extends('layouts.app')

@section('title', 'Tasks List')

@section('content')
<div class="date-filter">
    <h5><i class="bi bi-funnel"></i> Filter Tasks</h5>
    <form method="GET" action="{{ route('tasks.index') }}" class="row g-3">
        <div class="col-md-3">
            <label for="from_date" class="form-label">From Date</label>
            <input type="date" class="form-control" id="from_date" name="from_date" 
                   value="{{ request('from_date') }}">
        </div>
        <div class="col-md-3">
            <label for="to_date" class="form-label">To Date</label>
            <input type="date" class="form-control" id="to_date" name="to_date" 
                   value="{{ request('to_date') }}">
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-select" id="status" name="status">
                <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            </select>
        </div>
        <div class="col-md-3 d-flex align-items-end">
            <button type="submit" class="btn btn-primary me-2">
                <i class="bi bi-filter"></i> Apply Filter
            </button>
            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Clear
            </a>
        </div>
    </form>

    @if(request()->has('from_date') || request()->has('to_date'))
    <div class="mt-3">
        <small class="text-muted">
            @if(request()->has('from_date') && request()->has('to_date'))
                Showing tasks from {{ request('from_date') }} to {{ request('to_date') }}
            @elseif(request()->has('from_date'))
                Showing tasks from {{ request('from_date') }} onwards
            @elseif(request()->has('to_date'))
                Showing tasks until {{ request('to_date') }}
            @endif
        </small>
    </div>
    @endif
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="bi bi-list-task"></i> Tasks List</h5>
        <span class="badge bg-primary">{{ $tasks->total() }} tasks found</span>
    </div>
    
    <div class="card-body">
        @if($tasks->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-inbox" style="font-size: 3rem; color: #6c757d;"></i>
                <h5 class="mt-3">No tasks found</h5>
                <p class="text-muted">No tasks match your current filters.</p>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary mt-2">
                    <i class="bi bi-plus-circle"></i> Create Your First Task
                </a>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Task Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tasks as $task)
                        <tr>
                            <td>{{ $loop->iteration + ($tasks->currentPage() - 1) * $tasks->perPage() }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ Str::limit($task->description, 50) }}</td>
                            <td>
                                <span class="badge bg-light text-dark">
                                    <i class="bi bi-calendar"></i> {{ $task->task_date->format('M d, Y') }}
                                </span>
                            </td>
                            <td>
                                <span class="status-badge status-{{ $task->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('tasks.edit', $task) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST" 
                                      class="d-inline" onsubmit="return confirm('Are you sure?')">
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
            
            <div class="d-flex justify-content-center mt-3">
                {{ $tasks->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Set max date for from_date to to_date and vice versa
    document.addEventListener('DOMContentLoaded', function() {
        const fromDate = document.getElementById('from_date');
        const toDate = document.getElementById('to_date');
        
        if (fromDate && toDate) {
            // Set min/max dates for better UX
            fromDate.max = toDate.value;
            toDate.min = fromDate.value;
            
            fromDate.addEventListener('change', function() {
                toDate.min = this.value;
            });
            
            toDate.addEventListener('change', function() {
                fromDate.max = this.value;
            });
        }
    });
</script>
@endpush