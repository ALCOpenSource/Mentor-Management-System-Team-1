<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Models\Program;
use App\Models\ProgramCriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProgramController extends Controller
{
    /**
     * Uploads program avatar.
     *
     * @param mixed $file
     * @param mixed $program
     *
     * @return mixed
     */
    protected function updateAvatar($file, $program)
    {
        $avatar = $program->attachments()->where('type', 'avatar')->first();

        // If avatar already exists, delete it.
        if ($avatar) {
            callStatic(File::class, 'delete', storage_path('app/public/'.$avatar->path));
            $avatar->delete();
        }

        return $program->storeAttachment($file, 'avatar');
    }

    /**
     * Update program criteria.
     *
     * @param mixed $request
     * @param mixed $program
     *
     * @return mixed
     */
    protected function updateCriteria($request, $program)
    {
        // If has criteria, update them.
        if ($request->has('criteria')) {
            foreach ($request->criteria as $criteria) {
                $program->criteria()->updateOrCreate([
                    'id' => $criteria['id'] ?? null,
                ], [
                    'name' => $criteria['name'],
                    'input_type' => $criteria['input_type'],
                    'label' => $criteria['label'],
                    'meta' => ($criteria['meta'] ?? null),
                    'pre_validation' => ($criteria['pre_validation'] ?? null),
                    'validation' => ($criteria['validation'] ?? null),
                ]);
            }
        }
    }

    /**
     * Get all Programs.
     */
    public function getPrograms()
    {
        $programs = callStatic(Program::class, 'latest')->paginate(20);

        return new ApiResource($programs);
    }

    /**
     * Get all archived Programs.
     */
    public function getArchivedPrograms()
    {
        $programs = callStatic(Program::class, 'onlyTrashed')->latest()->paginate(20);

        return new ApiResource($programs);
    }

    /**
     * Create a new Program.
     */
    public function createProgram(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string|max:3000',
                'avatar' => 'nullable|image|max:2048',
                'assignees' => 'nullable|array',
                'assignees.*' => 'nullable|integer|exists:users,id',
                'criteria' => 'nullable|array',
                'criteria.*.name' => 'required|string|max:255',
                'criteria.*.input_type' => 'required|string|max:255',
                'criteria.*.label' => 'required|string|max:255',
                'criteria.*.meta' => 'nullable|array',
                // 'criteria.*.pre_validation' => 'nullable|array',
                // 'criteria.*.validation' => 'nullable|array',
            ]
        );

        $program = callStatic(
            Program::class,
            'create',
            $request->only(
                [
                    'name',
                    'description',
                ]
            )
        );

        if (true === $request->hasFile('avatar')) {
            $this->updateAvatar($request->file('avatar'), $program);
        }

        // If has assignees, assign them to the program.
        if ($request->has('assignees')) {
            foreach ($request->assignees as $assignee) {
                $program->assignees()->create(
                    [
                        'user_id' => $assignee,
                    ]
                );
            }
        }

        // If has criteria, create them.
        $this->updateCriteria($request, $program);

        return new ApiResource(['data' => $program]);
    }

    /**
     * Update a Program.
     *
     * @param mixed $request
     * @param mixed $program_id
     *
     * @return mixed
     */
    public function updateProgram(Request $request, $program_id)
    {
        $request->validate(
            [
                'name' => 'nullable|string|max:255',
                'description' => 'nullable|string|max:3000',
                'avatar' => 'nullable|image|max:2048',
                'assignees' => 'nullable|array',
                'assignees.*' => 'nullable|integer|exists:users,id',
                'criteria' => 'nullable|array',
                'criteria.*.id' => 'nullable|integer|exists:program_criteria,id',
                'criteria.*.name' => 'required|string|max:255',
                'criteria.*.input_type' => 'required|string|max:255',
                'criteria.*.label' => 'required|string|max:255',
                'criteria.*.meta' => 'nullable|array',
                // 'criteria.*.pre_validation' => 'nullable|array',
                // 'criteria.*.validation' => 'nullable|array',
            ]
        );

        $program = callStatic(Program::class, 'find', $program_id);

        if (false === (bool) $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        foreach ($request->only(
            [
                'name',
                'description',
            ]
        ) as $key => $value) {
            if (true === (bool) $value) {
                $program->$key = $value;
            }
        }

        // Update program.
        $program->save();

        if ($request->hasFile('avatar')) {
            $this->updateAvatar($request->file('avatar'), $program);
        }

        // If has assignees, assign them to the program.
        if ($request->has('assignees')) {
            $program->assignees()->delete();

            foreach ($request->assignees as $assignee) {
                $program->assignees()->create([
                    'user_id' => $assignee,
                ]);
            }
        }

        // If has criteria, update them.
        $this->updateCriteria($request, $program);

        return new ApiResource(['data' => $program]);
    }

    /**
     * Get a Program.
     *
     * @param mixed $program_id
     */
    public function getProgram($program_id)
    {
        $program = callStatic(Program::class, 'find', $program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        return new ApiResource(['data' => $program]);
    }

    /**
     * Archive a Program.
     *
     * @param mixed $request
     * @param mixed $program_id
     */
    public function archiveProgram(Request $request, $program_id)
    {
        $program = callStatic(Program::class, 'find', $program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        // TODO: Check roles and permissions to archive program.
        if ($request->force_delete) {
            $program->forceDelete();

            return new ApiResource(['message' => 'Program deleted permanently.']);
        }

        $program->delete();

        return new ApiResource(['message' => 'Program archived.']);
    }

    /**
     * Archive all Programs.
     */
    public function archiveAllPrograms()
    {
        callStatic(Program::class, 'where', 'created_by', auth()->user()->id)->delete();

        return new ApiResource(['message' => 'All programs created by user archived.']);
    }

    /**
     * Search Programs.
     */
    public function searchPrograms(Request $request)
    {
        $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $programs = callStatic(Program::class, 'where', 'name', 'like', '%'.$request->keyword.'%')->paginate(20);

        return new ApiResource($programs);
    }

    /**
     * Restore a Program.
     *
     * @param mixed $program_id
     */
    public function restoreProgram($program_id)
    {
        $program = callStatic(Program::class, 'onlyTrashed')->find($program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        $program->restore();

        return new ApiResource(['data' => $program]);
    }

    /**
     * Get all Program Criteria.
     *
     * @param mixed $program_id
     */
    public function getProgramCriteria($program_id)
    {
        $program = callStatic(Program::class, 'find', $program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        $criteria = callStatic(ProgramCriteria::class, 'where', 'program_uuid', $program->id)->get();

        return new ApiResource(['data' => $criteria]);
    }

    /**
     * Create a Program Criteria.
     *
     * @param mixed $program_id
     */
    public function createProgramCriteria(Request $request, $program_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'input_type' => 'required|string|max:255',
            'label' => 'required|string|max:255',
            'meta' => 'nullable|array',
            // 'pre_validation' => 'nullable|array',
            // 'validation' => 'nullable|array',
        ]);

        $program = callStatic(Program::class, 'find', $program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        $criteria = callStatic(ProgramCriteria::class, 'create', [
            'program_uuid' => $program->id,
            'name' => $request->name,
            'input_type' => $request->input_type,
            'label' => $request->label,
            'meta' => $request->meta,
            // 'pre_validation' => $request->pre_validation,
            // 'validation' => $request->validation,
        ]);

        return new ApiResource(['data' => $criteria]);
    }

    /**
     * Update a Program Criteria.
     *
     * @param mixed $program_id
     * @param mixed $criteria_id
     */
    public function updateProgramCriteria(Request $request, $program_id, $criteria_id)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
            'input_type' => 'nullable|string|max:255',
            'label' => 'nullable|string|max:255',
            'meta' => 'nullable|array',
            // 'pre_validation' => 'nullable|array',
            // 'validation' => 'nullable|array',
        ]);

        $program = callStatic(Program::class, 'find', $program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        $criteria = callStatic(ProgramCriteria::class, 'find', $criteria_id);

        if (! $criteria) {
            return new ApiResource([
                'error' => 'Criteria not found.',
                'status' => 404,
            ]);
        }

        foreach ($request->only([
            'name',
            'input_type',
            'label',
            'meta',
            // 'pre_validation',
            // 'validation',
        ]) as $key => $value) {
            if ($value) {
                $criteria->$key = $value;
            }
        }

        // Update criteria.
        $criteria->save();

        return new ApiResource(['data' => $criteria]);
    }

    /**
     * Delete a Program Criteria.
     *
     * @param mixed $program_id
     * @param mixed $criteria_id
     */
    public function deleteProgramCriteria($program_id, $criteria_id)
    {
        $program = callStatic(Program::class, 'find', $program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        $criteria = callStatic(ProgramCriteria::class, 'find', $criteria_id);

        if (! $criteria) {
            return new ApiResource([
                'error' => 'Criteria not found.',
                'status' => 404,
            ]);
        }

        $criteria->delete();

        return new ApiResource(['data' => $criteria]);
    }

    /**
     * Delete all Program Criteria.
     *
     * @param mixed $program_id
     */
    public function deleteAllProgramCriteria($program_id)
    {
        $program = callStatic(Program::class, 'find', $program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        callStatic(ProgramCriteria::class, 'where', 'program_uuid', $program->id)->delete();

        return new ApiResource(['message' => 'All criteria for program deleted.']);
    }

    /**
     * Get all Program Criteria Options.
     *
     * @param mixed $program_id
     * @param mixed $criteria_id
     */
    public function getSpecificProgramCriteria($program_id, $criteria_id)
    {
        $program = callStatic(Program::class, 'find', $program_id);

        if (! $program) {
            return new ApiResource([
                'error' => 'Program not found.',
                'status' => 404,
            ]);
        }

        $criteria = callStatic(ProgramCriteria::class, 'find', $criteria_id);

        if (! $criteria) {
            return new ApiResource([
                'error' => 'Criteria not found.',
                'status' => 404,
            ]);
        }

        $options = callStatic(ProgramCriteriaOption::class, 'where', 'criteria_uuid', $criteria->id)->get();

        return new ApiResource(['data' => $options]);
    }
}
