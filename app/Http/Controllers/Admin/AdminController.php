<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Project;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Get counts for dashboard widgets
        $stats = [
            'projects' => Project::count(),
            'skills' => Skill::count(),
            'education' => Education::count(),
            'experiences' => Experience::count(),
            'certificates' => Certificate::count(),
            'personal_info' => PersonalInfo::count(),
            'unread_messages' => ContactMessage::where('read', false)->count(),
        ];
        
        // Get recent messages
        $recentMessages = ContactMessage::latest()
            ->take(5)
            ->get();
            
        // Get recent projects
        $recentProjects = Project::latest()
            ->take(5)
            ->get();
        
        return view('admin.dashboard', compact('stats', 'recentMessages', 'recentProjects'));
    }
}
