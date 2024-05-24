<?php

namespace App\Http\Controllers;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPendingTasks = Task::query()->where("status", "pending")->count();

        $myPendingTasks = Task::query()->where("status", "pending")->where("assigned_user_id", auth()->user()->id ?? "Unassigned")->count();

        $totalInProgressTasks = Task::query()->where("status", "in_progress")->count();

        $myInProgressTasks = Task::query()->where("status", "in_progress")->where("assigned_user_id", auth()->user()->id ?? "Unassigned")->count();

        $totalCompletedTasks = Task::query()->where("status", "completed")->count();

        $myCompletedTasks = Task::query()->where("status", "completed")->where("assigned_user_id", auth()->user()->id ?? "Unassigned")->count();

        $activeTasks = Task::query()->whereIn("status", ["pending", "in_progress"])->where("assigned_user_id", auth()->user()->id ?? "Unassigned")->limit(10)->get();

        $activeTasks = TaskResource::collection($activeTasks);

        return Inertia::render('Dashboard', compact('totalPendingTasks', 'myPendingTasks', 'totalInProgressTasks', 'myInProgressTasks', 'totalCompletedTasks', 'myCompletedTasks', 'activeTasks'));
    }
}
