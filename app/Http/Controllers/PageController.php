<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Certificate;
use App\Models\PersonalInfo;
use App\Models\ContactMessage;

use Barryvdh\DomPDF\Facade\PDF;

use Illuminate\Http\Request; // form submissions
use Illuminate\Support\Facades\Response; // sending files and file downloads
use Illuminate\Support\Facades\Storage; // useful if I want to store files in different locations
use Symfony\Component\HttpFoundation\BinaryFileResponse; // handles binary file responses like PDFs, ensures file streaming


class PageController extends Controller
{
    public function home() {
        $personalInfo = PersonalInfo::getInfoForSection('home');
        return view('home', compact('personalInfo'));
    }

    public function about() {
        $skills = Skill::organized()->get();
        $skillsByCategory = $skills->groupBy('category');
        
        $education = Education::orderBy('end_date', 'desc')
            ->orderBy('start_date', 'desc')
            ->get();
            
        $experiences = Experience::orderBy('end_date', 'desc')
            ->orderBy('start_date', 'desc')
            ->get();
            
        $certificates = Certificate::orderBy('issue_date', 'desc')->get();

        $personalInfo = PersonalInfo::getInfoForSection('about');
        
        return view('about', compact(
            'skillsByCategory',
            'education',
            'experiences',
            'certificates',
            'personalInfo'
        ));
    }

    public function projects() {
        $featuredProjects = Project::where('featured', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
            
        $allProjects = Project::orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
            
            return view('pages.projects', compact('featuredProjects', 'allProjects'));
    }
    
    /**
     * Display the specified project.
     * 
     * @param Project $project
     * @return \Illuminate\View\View
     */
    public function showProject(Project $project)
    {
        // Get related projects (optional)
        $relatedProjects = Project::where('id', '!=', $project->id)
            ->inRandomOrder()
            ->limit(3)
            ->get();
            
        return view('pages.project-detail', compact('project', 'relatedProjects'));
    }

    public function contact() {
        $personalInfo = PersonalInfo::getInfoForSection('Contact');
        
        $socialInfo = PersonalInfo::where('section', 'Social')
            ->where('is_public', true)
            ->get()
            ->pluck('value', 'key');
            
        // Merge into personalInfo
        $personalInfo = $personalInfo->merge($socialInfo);
        
        return view('contact', compact('personalInfo'));
    }

    /**
     * Process the contact form submission
     */
    public function submitContactForm(Request $request)
    {
        // Validate the form data
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string'
        ]);
        
        // Save the message to the database
        $contactMessage = ContactMessage::create($validated);
        
        // Optionally send an email notification
        // Mail::to('your-email@example.com')->send(new ContactFormSubmission($contactMessage));
        
        // Redirect with success message
        return redirect()
            ->route('contact')
            ->with('success', 'Thank you for your message! I will get back to you soon.');
    }

    /**
     * Download the CV directly
     * 
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadCV()
    {
        // Get the resume controller instance
        $resumeController = app()->make(\App\Http\Controllers\ResumeController::class);
        
        // Generate the PDF using the same method as the preview
        $pdf = $resumeController->generatePDF(true); // Pass true to indicate download mode
        
        // Get name for the file from PersonalInfo
        try {
            $nameInfo = \App\Models\PersonalInfo::where('key', 'name')->first();
            $name = $nameInfo ? $nameInfo->value : 'Resume';
        } catch (\Exception $e) {
            $name = 'Resume';
        }
        
        // Return as download with proper filename
        return $pdf->download($name . ' - CV.pdf');
    }

    /**
     * Get personal information
     * 
     * @return array
     */
    private function getPersonalInfo()
    {
        $personalInfo = [];
        
        try {
            $infoItems = \App\Models\PersonalInfo::where('section', 'Resume')
                ->orWhere('key', 'name')
                ->get();
                
            foreach ($infoItems as $item) {
                $personalInfo[$item->key] = $item->value;
            }
        } catch (\Exception $e) {
            // Fallback if database query fails
            $personalInfo['name'] = 'Joy Dimaculangan';
        }
        
        return $personalInfo;
    }

    /**
     * Get all public personal info merged with section-specific info.
     *
     * @param  string|null  $section  Section to merge with global data
     * @return \Illuminate\Support\Collection
     */
    public static function getInfoForSection($section = null)
    {
        // Get all public personal info (globally accessible)
        $globalInfo = static::public()
            ->get()
            ->pluck('value', 'key');
        
        // If no section specified, just return global info
        if (!$section) {
            return $globalInfo;
        }
        
        // Get section-specific info
        $sectionInfo = static::public()
            ->inSection($section)
            ->get()
            ->pluck('value', 'key');
        
        // Merge them with section-specific values taking precedence
        return $globalInfo->merge($sectionInfo);
    }
}
