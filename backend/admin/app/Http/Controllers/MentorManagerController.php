<?php

namespace App\Http\Controllers;

use App\Helpers\AppConstants;
use Illuminate\Http\Request;

class MentorManagerController extends Controller
{
    protected $mentor_controller = null;

    public function __construct()
    {
        $this->mentor_controller = new MentorController(AppConstants::ROLE_MENTOR_MANAGER);
    }

    /**
     * Get all mentors.
     */
    public function getMentorManagers(Request $request)
    {
        return $this->mentor_controller->getMentors($request);
    }

    /**
     * Search mentor managers.
     *
     * @param mixed $keyword
     */
    public function searchMentorManagers(Request $request, $keyword)
    {
        return $this->mentor_controller->searchMentors($request, $keyword);
    }

    /**
     * Get specific mentor.
     *
     * @param mixed $mentor_manager_id
     */
    public function getMentorManager($mentor_manager_id)
    {
        return $this->mentor_controller->getMentor($mentor_manager_id);
    }

    /**
     * Invite mentor.
     */
    public function inviteMentorManager(Request $request)
    {
        return $this->mentor_controller->inviteMentor($request);
    }

    /**
     * Update mentor.
     *
     * @param mixed $mentor_manager_id
     */
    public function updateMentorManager(Request $request, $mentor_manager_id)
    {
        return $this->mentor_controller->updateMentor($request, $mentor_manager_id);
    }

    /**
     * Delete mentor.
     *
     * @param mixed $mentor_manager_id
     */
    public function deleteMentorManager($mentor_manager_id)
    {
        return $this->mentor_controller->deleteMentor($mentor_manager_id);
    }
}
