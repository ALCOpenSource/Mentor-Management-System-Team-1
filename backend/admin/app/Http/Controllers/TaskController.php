<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Get all tasks.
     */
    public function getTasks()
    {
        $tasks = callStatic(Task::class, 'paginate', 20);

        return new ApiResource($tasks);
    }

    /**
     * Get a task.
     *
     * @param mixed $task_id
     */
    public function getTask($task_id)
    {
        $task = callStatic(Task::class, 'findOrFail', $task_id);

        return new ApiResource(['data' => $task]);
    }

    /**
     * Create a task.
     */
    public function createTask(Request $request)
    {
        // Lowercase the priority and status
        if ($request->has('priority')) {
            $request->merge(['priority' => strtolower($request->priority)]);
        }

        if ($request->has('status')) {
            $request->merge(['status' => strtolower($request->status)]);
        }

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:32',
            'details' => 'required|string',
            'start_date' => 'nullable|date:Y-m-d H:i:s',
            'due_date' => 'nullable|date:Y-m-d H:i:s|after_or_equal:start_date',
            'priority' => 'nullable|string|in:'.implode(',', AppConstants::TASK_PRIORITY_VALUES),
            'status' => 'nullable|string|in:'.implode(',', AppConstants::TASK_STATUS_VALUES),
            'assignees' => 'nullable|array',
            'assignees.*' => 'nullable|integer|exists:users,id',
        ]);

        // Remove all null values from the request
        $request->replace(array_filter($request->all(), function ($value) {
            return ! is_null($value);
        }));

        // Create the task
        $task = callStatic(Task::class, 'create', $request->only([
            'title',
            'details',
            'start_date',
            'due_date',
            'priority',
            'status',
        ]));

        // Assign the task to the assignees
        if ($request->has('assignees')) {
            $task->assignments()->createMany(
                array_map(function ($assignee_id) {
                    return ['user_id' => $assignee_id];
                }, $request->assignees)
            );
        }

        return new ApiResource(['data' => $task]);
    }

    /**
     * Update a task.
     *
     * @param mixed $task_id
     */
    public function updateTask(Request $request, $task_id)
    {
        // Lowercase the priority and status
        if ($request->has('priority')) {
            $request->merge(['priority' => strtolower($request->priority)]);
        }

        if ($request->has('status')) {
            $request->merge(['status' => strtolower($request->status)]);
        }

        // Validate the request
        $request->validate([
            'title' => 'nullable|string|max:32',
            'details' => 'nullable|string',
            'start_date' => 'nullable|date:Y-m-d H:i:s',
            'due_date' => 'nullable|date:Y-m-d H:i:s|after_or_equal:start_date',
            'priority' => 'nullable|string|in:'.implode(',', AppConstants::TASK_PRIORITY_VALUES),
            'status' => 'nullable|string|in:'.implode(',', AppConstants::TASK_STATUS_VALUES),
            'assignees' => 'nullable|array',
            'assignees.*' => 'nullable|integer|exists:users,id',
        ]);

        // Remove all null values from the request
        $request->replace(array_filter($request->all(), function ($value) {
            return ! is_null($value);
        }));

        // If the request is empty, return an error
        if (empty($request->all())) {
            return new ApiResource([
                'error' => 'No data to update',
                'status' => 422,
            ]);
        }

        // Update the task
        $task = callStatic(Task::class, 'findOrFail', $task_id);

        // If the task is not created by the user, return an error
        if ($task->created_by !== auth()->user()->id) {
            return new ApiResource([
                'error' => 'You are not authorized to update this task',
                'status' => 403,
            ]);
        }

        $task->update($request->only([
            'title',
            'details',
            'start_date',
            'due_date',
            'priority',
            'status',
        ]));

        // Assign the task to the assignees
        if ($request->has('assignees')) {
            $task->assignments()->delete();
            $task->assignments()->createMany(
                array_map(function ($assignee_id) {
                    return ['user_id' => $assignee_id];
                }, $request->assignees)
            );
        }

        return new ApiResource(['data' => $task]);
    }

    /**
     * Delete a task.
     *
     * @param mixed $task_id
     */
    public function deleteTask($task_id)
    {
        $task = callStatic(Task::class, 'findOrFail', $task_id);

        // If the task is not created by the user, return an error
        if ($task->created_by !== auth()->user()->id) {
            return new ApiResource([
                'error' => 'You are not authorized to delete this task',
                'status' => 403,
            ]);
        }

        // Delete the task assignments
        $task->assignments()->delete();

        // Delete the task reports
        $task->reports()->delete();

        // Delete the task
        $task->delete();

        return new ApiResource(['data' => $task]);
    }

    /**
     * Delete all tasks.
     */
    public function deleteAllTasks()
    {
        // Delete all tasks created by the user
        callStatic(Task::class, 'where', 'created_by', auth()->user()->id)->delete();

        // Delete all task
        return new ApiResource(['message' => 'All tasks deleted successfully']);
    }

    /**
     * Get cached tasks.
     */
    public function getCachedTaskAssignments()
    {
        $cache_key = 'task_assignments_'.auth()->user()->id;

        // If cache exists, return the cached tasks
        if (cache()->has($cache_key)) {
            return new ApiResource(['data' => cache()->get($cache_key)]);
        }

        $task_assignments = cache()->remember($cache_key, 0, function () {
            return callStatic(Task::class, 'whereHas', 'assignments', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })->join('task_assignments', 'tasks.id', '=', 'task_assignments.task_id')
                ->join('users', 'task_assignments.user_id', '=', 'users.id')
                ->select('tasks.*', 'users.name as assignee_name, users.role as assignee_role')
                ->get()
                ->groupBy('assignee_role');
        });

        return new ApiResource(['data' => $task_assignments]);
    }

    /**
     * Invalidate cached tasks.
     */
    public function invalidateCachedTaskAssignments()
    {
        $cache_key = 'task_assignments_'.auth()->user()->id;

        // If cache exists, return the cached tasks
        if (cache()->has($cache_key)) {
            cache()->forget($cache_key);
        }

        return new ApiResource(['message' => 'Cached task assignments invalidated successfully']);
    }
}
