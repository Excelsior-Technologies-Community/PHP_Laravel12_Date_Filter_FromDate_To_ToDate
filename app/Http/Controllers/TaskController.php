<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $query = Task::query();

        // ==========================
        // Search
        // ==========================
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // ==========================
        // Date Filter
        // ==========================
        if ($request->filled('from_date') && $request->filled('to_date')) {

            $query->whereBetween('task_date', [
                Carbon::parse($request->from_date)->startOfDay(),
                Carbon::parse($request->to_date)->endOfDay(),
            ]);

        } elseif ($request->filled('from_date')) {

            $query->where(
                'task_date',
                '>=',
                Carbon::parse($request->from_date)->startOfDay()
            );

        } elseif ($request->filled('to_date')) {

            $query->where(
                'task_date',
                '<=',
                Carbon::parse($request->to_date)->endOfDay()
            );
        }

        // ==========================
        // Status Filter
        // ==========================
        if ($request->filled('status') && $request->status != 'all') {

            $query->where('status', $request->status);
        }

        // ==========================
        // Sorting
        // ==========================
        switch ($request->sort) {

            case 'title_asc':
                $query->orderBy('title', 'asc');
                break;

            case 'title_desc':
                $query->orderBy('title', 'desc');
                break;

            case 'oldest':
                $query->orderBy('task_date', 'asc');
                break;

            default:
                $query->orderBy('task_date', 'desc');
        }

        // ==========================
        // Pagination
        // ==========================
        $tasks = $query->paginate(5)->appends($request->query());

        // ==========================
        // Dashboard Statistics
        // ==========================
        $stats = [

            'total' => Task::count(),

            'pending' => Task::where('status', 'pending')->count(),

            'progress' => Task::where('status', 'in_progress')->count(),

            'completed' => Task::where('status', 'completed')->count(),

            'today' => Task::whereDate('task_date', today())->count(),

        ];

        return view('tasks.index', compact('tasks', 'stats'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $request->validate([

            'title' => 'required|max:255',

            'description' => 'nullable',

            'task_date' => 'required|date',

            'status' => 'required'

        ]);

        Task::create($request->all());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task created successfully.');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $request->validate([

            'title' => 'required|max:255',

            'description' => 'nullable',

            'task_date' => 'required|date',

            'status' => 'required'

        ]);

        $task->update($request->all());

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()
            ->route('tasks.index')
            ->with('success', 'Task deleted successfully.');
    }
}