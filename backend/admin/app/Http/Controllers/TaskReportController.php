<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\TaskReport;
use Illuminate\Http\Request;

class TaskReportController extends Controller
{
    /**
     * Get all reports.
     *
     * @param mixed|null $task_id
     */
    public function getReports($task_id = null)
    {
        if ($task_id) {
            $reports = callStatic(Task::class, 'findOrFail', $task_id)->reports()->paginate(20);

            return new ApiResource($reports);
        }

        $reports = callStatic(TaskReport::class, 'paginate', 20);

        return new ApiResource($reports);
    }

    /**
     * Create a report.
     */
    public function createReport(Request $request)
    {
        // Validate the request
        $request->validate([
            'task_id' => 'nullable|integer|exists:tasks,id',
            'details' => 'required|string',
            'type' => 'nullable|string|in:text',
        ]);

        // Remove all null values from the request
        $request->replace(array_filter($request->all(), function ($value) {
            return ! is_null($value);
        }));

        // Create the report
        $report = callStatic(TaskReport::class, 'create', $request->only(['task_id', 'details', 'type']));

        return new ApiResource(['data' => $report]);
    }

    /**
     * Update a report.
     *
     * @param mixed $report_id
     */
    public function updateReport(Request $request, $report_id)
    {
        // Validate the request
        $request->validate([
            'task_id' => 'nullable|integer|exists:tasks,id',
            'details' => 'nullable|string',
            'type' => 'nullable|string|in:text',
        ]);

        // Remove all null values from the request
        $request->replace(array_filter($request->all(), function ($value) {
            return ! is_null($value);
        }));

        // If the request is empty return an error
        if (empty($request->all())) {
            return new ApiResource(['error' => 'No data to update', 'status' => 422]);
        }

        // Update the report
        $report = callStatic(TaskReport::class, 'findOrFail', $report_id);

        // If report is not created by the user return an error
        if ($report->created_by != auth()->user()->id) {
            return new ApiResource(['error' => 'You are not authorized to delete this report', 'status' => 403]);
        }

        $report->update($request->only(['task_id', 'details', 'type']));

        return new ApiResource(['data' => $report]);
    }

    /**
     * Delete a report.
     *
     * @param mixed $report_id
     */
    public function deleteReport($report_id)
    {
        // Delete the report
        $report = callStatic(TaskReport::class, 'findOrFail', $report_id);

        // If report is not created by the user return an error
        if ($report->created_by != auth()->user()->id) {
            return new ApiResource(['error' => 'You are not authorized to delete this report', 'status' => 403]);
        }

        $report->delete();

        return new ApiResource(['data' => $report]);
    }

    /**
     * Delete all reports created by the user.
     */
    public function deleteAllReports()
    {
        // Delete all reports created by the user
        callStatic(TaskReport::class, 'where', 'created_by', auth()->user()->id)->delete();

        return new ApiResource(['message' => 'All reports deleted successfully']);
    }
}
