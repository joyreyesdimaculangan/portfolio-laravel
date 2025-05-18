<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminResumeController extends Controller
{
    /**
     * Show the resume settings page.
     *
     * @return \Illuminate\View\View
     */
    public function settings()
    {
        // Get resume info
        $resumeInfo = PersonalInfo::where('section', 'resume')->get();
        
        // Convert to associative array
        $infoArray = [];
        foreach ($resumeInfo as $item) {
            $infoArray[$item->key] = $item->value;
        }
        
        return view('admin.resume.settings', compact('infoArray'));
    }

    /**
     * Update the resume settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateSettings(Request $request)
    {
        // Validate form data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'resume_objective' => 'nullable|string',
            'linkedin_url' => 'nullable|url|max:255',
            'github_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
            'accent_color' => 'nullable|string|max:7',
            'font_family' => 'nullable|string|max:20',
        ]);

        // Update or create each setting
        foreach ($validated as $key => $value) {
            PersonalInfo::updateOrCreate(
                [
                    'key' => $key,
                    'section' => 'resume'
                ],
                [
                    'value' => $value,
                    'type' => $key === 'resume_objective' ? 'textarea' : 'text',
                    'is_public' => true
                ]
            );
        }

        // Add timestamp for the last update
        PersonalInfo::updateOrCreate(
            [
                'key' => 'updated_at',
                'section' => 'resume'
            ],
            [
                'value' => now()->setTimezone('Asia/Manila')->format('Y-m-d H:i:s'),
                'type' => 'timestamp',
                'is_public' => true
            ]
        );

        return redirect('/admin/resume/settings')->with('success', 'Resume settings updated successfully!');
    }
}