<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use App\Http\Resources\ApiResource;
use App\Models\Report;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    protected function getModelIdKey(Model|string $model)
    {
        if (is_string($model)) {
            $model = new $model();
        }

        $model_table = $model->getTable();

        return strHelper('singular', $model_table).'_id';
    }

    protected function validateParent(Request $request, $nullable = false)
    {
        // Validatable model
        $validatable_model = AppConstants::REPORTABLES[$request->reportable];

        // Validate that the data exists
        $table = (new $validatable_model())->getTable();
        $id_key = strHelper('singular', $table).'_id';

        $request->validate([
            $id_key => [
                $nullable ? 'nullable' : 'required',
                'exists:'.$table.',id',
            ],
        ]);
    }

    protected function validateReportable(Request $request, string $reportable)
    {
        $request->merge([
            'reportable' => strtolower($reportable),
        ]);

        $request->validate([
            'reportable' => 'required|string|in:'.implode(',', array_keys(AppConstants::REPORTABLES)),
        ]);
    }

    /**
     * Get reports.
     */
    public function getReports(Request $request, string $reportable)
    {
        // Validate the request
        $this->validateReportable($request, $reportable);

        // Validate that the data exists
        $model = AppConstants::REPORTABLES[$reportable];
        $id_key = $this->getModelIdKey($model);

        if ($request->$id_key) {
            $this->validateParent($request);
        }

        // Get reports for the model
        if ($request->$id_key) {
            $reports = callStatic(Report::class, 'where', 'report_type', $model)
                ->where('report_id', $request->$id_key)
                ->latest()
                ->paginate(20);

            return new ApiResource($reports);
        }

        $reports = callStatic(Report::class, 'where', 'report_type', $model)->latest()->paginate(20);

        return new ApiResource($reports);
    }

    /**
     * Create a report.
     */
    public function createReport(Request $request, string $reportable)
    {
        $this->validateReportable($request, $reportable);

        $request->validate([
            'details' => 'required|string',
            'type' => 'nullable|string|in:text',
        ]);

        // Remove all null values from the request
        $request->replace(array_filter($request->all(), function ($value) {
            return ! is_null($value);
        }));

        // Model
        $model = AppConstants::REPORTABLES[$reportable];
        $id_key = $this->getModelIdKey($model);

        // If reportable id is set then create
        $report = (new $model())->reports()->create($request->only(['details', 'type', $id_key]));

        return new ApiResource(['data' => $report]);
    }

    /**
     * Update a report.
     *
     * @param mixed $report_id
     */
    public function updateReport(Request $request, string $reportable, $report_id)
    {
        $this->validateReportable($request, $reportable);

        $request->validate([
            'details' => 'required|string',
            'type' => 'nullable|string|in:text',
        ]);

        // Validate that the data exists
        $this->validateParent($request, true);

        // Remove all null values from the request
        $request->replace(array_filter($request->all(), function ($value) {
            return ! is_null($value);
        }));

        // If the request is empty return an error
        if (empty($request->all())) {
            return new ApiResource(['error' => 'No data to update', 'status' => 422]);
        }

        // Update the report
        $model = AppConstants::REPORTABLES[$reportable];
        $id_key = $this->getModelIdKey($model);
        $report = callStatic(Report::class, 'where', 'report_type', $model)->where('id', $report_id)->first();

        if (! $report) {
            return new ApiResource([
                'error' => 'Report not found',
                'status' => 404,
            ]);
        }

        // If report is not created by the user return an error
        if ($report->created_by != auth()->user()->id) {
            return new ApiResource(['error' => 'You are not authorized to delete this report', 'status' => 403]);
        }

        // Set report_id = $id_key value
        $request->merge([
            'report_id' => $request->$id_key,
        ]);

        $report->update($request->only(['report_id', 'details', 'type']));

        return new ApiResource(['data' => $report]);
    }

    /**
     * Delete a report.
     *
     * @param mixed $report_id
     */
    public function deleteReport(Request $request, string $reportable, $report_id)
    {
        $this->validateReportable($request, $reportable);

        $model = AppConstants::REPORTABLES[$reportable];

        // Delete the report
        $report = callStatic(Report::class, 'where', 'report_type', $model)->find($report_id);

        // If no report return 404
        if (! $report) {
            return new ApiResource([
                'error' => 'Report not found',
                'status' => 404,
            ]);
        }

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
    public function deleteAllReports(Request $request, string $reportable)
    {
        $this->validateReportable($request, $reportable);

        $model = AppConstants::REPORTABLES[$reportable];

        // Delete all reports
        callStatic(Report::class, 'where', 'report_type', $model)
            ->where('created_by', auth()->user()->id)
            ->delete();

        return new ApiResource(['message' => 'All reports deleted successfully']);
    }
}
