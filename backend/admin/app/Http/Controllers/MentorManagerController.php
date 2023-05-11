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
    public function getMentorManagers()
    {
        return $this->mentor_controller->getMentors();
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
     * @param mixed $id
     */
    public function getMentorManager($id)
    {
        return $this->mentor_controller->getMentor($id);
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
     * @param mixed $id
     */
    public function updateMentorManager(Request $request, $id)
    {
        return $this->mentor_controller->updateMentor($request, $id);
    }

    /**
     * Delete mentor.
     *
     * @param mixed $id
     */
    public function deleteMentorManager($id)
    {
        return $this->mentor_controller->deleteMentor($id);
    }
}
