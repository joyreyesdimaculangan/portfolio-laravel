<?php

namespace App\Http\Controllers;

use App\Models\PersonalInfo;
use App\Models\Experience;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Certificate;
use App\Models\Project;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\PDF;

class ResumeController extends Controller
{
    /**
     * Show resume template preview/customize page
     * 
     * @return \Illuminate\View\View
     */
    public function customize()
    {
        // Get resume data for preview
        try {
            // Get personal information collection
            $result = PersonalInfo::where('section', 'resume')->get();
            
            // Convert to key-value array
            $personalInfo = [];
            foreach ($result as $item) {
                $personalInfo[$item->key] = $item->value;
            }
            
            // Check for name and add defaults if missing
            if (!isset($personalInfo['name'])) {
                // Try to get name from general section
                $nameInfo = PersonalInfo::where('key', 'name')->first();
                if ($nameInfo) {
                    $personalInfo['name'] = $nameInfo->value;
                } else {
                    $personalInfo['name'] = 'My Resume';
                }
            }
        } catch (\Exception $e) {
            // Return default values if anything fails
            $personalInfo = [
                'name' => 'My Resume',
                'email' => 'email@example.com',
                'phone' => '',
                'location' => '',
                'resume_objective' => 'Please add a professional summary in your resume settings.'
            ];
        }
        
        // Check if we have data for each section
        $hasExperiences = Experience::count() > 0;
        $hasEducation = Education::count() > 0;
        $hasSkills = Skill::count() > 0;
        $hasCertificates = Certificate::count() > 0;
        $hasProjects = Project::where('featured', true)->count() > 0;
        
        return view('resume.customize', compact(
            'personalInfo', 
            'hasExperiences',
            'hasEducation',
            'hasSkills',
            'hasCertificates',
            'hasProjects'
        ));
    }

    /**
     * Generate PDF version of resume
     *
     * @param bool $forDownload Whether this is for direct download (optional)
     * @return mixed PDF response or PDF object depending on $forDownload
     */
    public function generatePDF($forDownload = false)
    {
        // Get all necessary data for the resume
        $personalInfo = $this->getPersonalInfo();
        
        // Experiences sorted by date (newest first)
        // Remove the is_visible check if the column doesn't exist
        $experiences = \App\Models\Experience::orderBy('end_date', 'desc')
            ->orderBy('start_date', 'desc')
            ->get();
        
        // Education sorted by date (newest first)
        $education = \App\Models\Education::orderBy('end_date', 'desc')
            ->orderBy('start_date', 'desc')
            ->get();
        
        // Skills without visibility check
        $skills = \App\Models\Skill::all();
        $skillsByCategory = $skills->groupBy('category');
        
        // Add generic "My Skills" category if no categories exist
        if ($skillsByCategory->isEmpty() && !$skills->isEmpty()) {
            $skillsByCategory = collect(['My Skills' => $skills]);
        }
        
        // Certificates sorted by date (newest first)
        $certificates = \App\Models\Certificate::orderBy('issue_date', 'desc')
            ->get();
        
        // Featured projects only - if is_published doesn't exist, remove it
        $projects = \App\Models\Project::where('featured', true)
            ->orderBy('sort_order')
            ->take(5)
            ->get();
        
        // Rest of the method remains the same
        $sections = [
            'objective', 'experience', 'education', 'skills', 'certificates', 'projects'
        ];
        
        $styling = [
            'accent_color' => $personalInfo['accent_color'] ?? '#774C0C',
            'font_family' => $personalInfo['font_family'] ?? 'helvetica'
        ];
        
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('resume.pdf', [
            'personalInfo' => $personalInfo,
            'experiences' => $experiences,
            'education' => $education,
            'skillsByCategory' => $skillsByCategory,
            'certificates' => $certificates,
            'projects' => $projects,
            'sections' => $sections,
            'styling' => $styling
        ]);
        
        $pdf->setPaper('a4');
        $pdf->setOptions([
            'dpi' => 150,
            'defaultFont' => $styling['font_family'],
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ]);
        
        if ($forDownload) {
            return $pdf;
        }
        
        return $pdf->stream('resume.pdf');
    }
    
    public function resumeSettings()
    {
        $personalInfo = PersonalInfo::where('section', 'resume')->get();
        
        return view('admin.resume.settings', compact('personalInfo'));
    }

    /**
     * Get personal information with proper fallbacks
     * 
     * @return array
     */
    private function getPersonalInfo(): array
    {
        try {
            // Get personal information collection
            $result = PersonalInfo::where('section', 'resume')->get();
            
            // Convert to key-value array
            $personalInfo = [];
            foreach ($result as $item) {
                $personalInfo[$item->key] = $item->value;
            }
            
            // Check for name and add defaults if missing
            if (!isset($personalInfo['name'])) {
                // Try to get name from general section
                $nameInfo = PersonalInfo::where('key', 'name')->first();
                if ($nameInfo) {
                    $personalInfo['name'] = $nameInfo->value;
                } else {
                    $personalInfo['name'] = 'My Resume';
                }
            }
            
            return $personalInfo;
            
        } catch (\Exception $e) {
            // Return default values if anything fails
            return [
                'name' => 'My Resume',
                'email' => 'email@example.com',
                'phone' => '',
                'location' => '',
                'resume_objective' => 'Please add a professional summary in your resume settings.'
            ];
        }
    }
}