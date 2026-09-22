<?php

namespace App\Http\Controllers;

use App\Models\Award;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\SiteSetting;

class HomeController extends Controller
{
    /**
     * Show the portfolio landing page.
     */
    public function index()
    {
        $setting = SiteSetting::current();
        app()->setLocale($setting->portfolio_locale);

        $profile = Profile::first();

        if (! $profile) {
            $profile = new Profile([
                'name' => 'Nama Anda',
                'title' => 'Data Analyst & Engineer',
                'bio' => 'I am an enthusiastic learner in the field of data, with a strong interest in data analysis, visualization, and turning raw information into meaningful insights. I also have hands-on experience building interactive web applications using Laravel, which allows me to present data, projects, and information in a clear and user-friendly way.',
                'email' => '',
                'skills' => [],
            ]);
        }

        $experiences = Experience::orderBy('start_date', 'desc')->get();

        $projects = Project::orderBy('is_featured', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $awards = Award::orderBy('is_featured', 'desc')
            ->orderBy('award_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('welcome', compact('profile', 'experiences', 'projects', 'awards', 'setting'));
    }
}
