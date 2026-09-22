<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Award;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $projectCount = Project::count();
        $experienceCount = Experience::count();
        $awardCount = Award::count();
        $profile = Profile::first();

        return view('admin.dashboard', compact('projectCount', 'experienceCount', 'awardCount', 'profile'));
    }
}
