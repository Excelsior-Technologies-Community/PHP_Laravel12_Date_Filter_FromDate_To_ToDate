<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    public function run(): void
    {
        $tasks = [
            ['title' => 'Complete project proposal', 'description' => 'Finish writing the project proposal document', 'task_date' => now()->subDays(2), 'status' => 'completed'],
            ['title' => 'Team meeting', 'description' => 'Weekly team sync meeting', 'task_date' => now()->subDay(), 'status' => 'completed'],
            ['title' => 'Code review', 'description' => 'Review pull requests from team members', 'task_date' => now(), 'status' => 'in_progress'],
            ['title' => 'Update documentation', 'description' => 'Update API documentation', 'task_date' => now()->addDay(), 'status' => 'pending'],
            ['title' => 'Client presentation', 'description' => 'Prepare slides for client presentation', 'task_date' => now()->addDays(2), 'status' => 'pending'],
            ['title' => 'Bug fixing', 'description' => 'Fix reported bugs in production', 'task_date' => now()->subDays(5), 'status' => 'completed'],
            ['title' => 'Database optimization', 'description' => 'Optimize database queries', 'task_date' => now()->addDays(3), 'status' => 'pending'],
            ['title' => 'Unit tests', 'description' => 'Write unit tests for new features', 'task_date' => now()->addDays(1), 'status' => 'in_progress'],
            ['title' => 'Deploy to staging', 'description' => 'Deploy latest changes to staging environment', 'task_date' => now(), 'status' => 'in_progress'],
            ['title' => 'Performance testing', 'description' => 'Run performance tests on the application', 'task_date' => now()->addDays(4), 'status' => 'pending'],
        ];

        foreach ($tasks as $task) {
            Task::create($task);
        }
    }
}