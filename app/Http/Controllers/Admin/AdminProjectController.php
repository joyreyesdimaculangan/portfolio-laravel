<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProjectController extends BaseAdminController
{
    /**
     * Display a listing of the projects.
     */
    public function index(Request $request) 
    {
        $query = Project::query();
        
        $projects = $this->paginateResults(
            $query, 
            $request, 
            'sort_order',  
            'asc'         
        );
            
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created project in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'github_url' => 'nullable|url',
            'demo_url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'technologies' => 'nullable|string',
            'featured' => 'nullable',
        ]);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('projects', 'public');
            $validated['image'] = $imagePath;
        }
        
        // Convert technologies from comma-separated string to array
        if (isset($validated['technologies']) && !empty($validated['technologies'])) {
            $technologies = explode(',', $validated['technologies']);
            $validated['technologies'] = array_map('trim', $technologies);
        } else {
            $validated['technologies'] = [];
        }
        
        // Set default sort order (add to the end)
        $maxOrder = Project::max('sort_order') ?? 0;
        $validated['sort_order'] = $maxOrder + 1;
        
        // Set featured value explicitly (default to false)
        $validated['featured'] = $request->has('featured');
        
        // Create the project
        Project::create($validated);
        
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project.
     */
    public function edit(Project $project)
    {
        // Using the accessor getTechnologiesStringAttribute(), no need for additional code
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified project in storage.
     */
    public function update(Request $request, Project $project)
    {
        // Add debugging to see if the method is being called
        \Log::info('Update method called for project: ' . $project->id);
        \Log::info('Request data:', $request->all());
        \Log::info('Form action URL: ' . route('admin.projects.update', $project));

        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'technologies' => 'nullable|string',
                'github_url' => 'nullable|url|max:255',
                'demo_url' => 'nullable|url|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'featured' => 'nullable', // Changed from 'sometimes|boolean' to handle checkbox better
                'sort_order' => 'nullable|integer'
            ]);
            
            // Handle image upload with better error handling
            if ($request->hasFile('image')) {
                try {
                    // Delete old image if it exists
                    if ($project->image && Storage::disk('public')->exists($project->image)) {
                        Storage::disk('public')->delete($project->image);
                    }
                    
                    $imagePath = $request->file('image')->store('projects', 'public');
                    $validated['image'] = $imagePath;
                } catch (\Exception $e) {
                    \Log::error('Image handling error: ' . $e->getMessage());
                    return back()->withErrors(['image' => 'Could not upload image: ' . $e->getMessage()])->withInput();
                }
            }
            
            // Handle technologies array conversion with better validation
            if (isset($validated['technologies'])) {
                if (is_string($validated['technologies']) && !empty($validated['technologies'])) {
                    $technologies = explode(',', $validated['technologies']);
                    $validated['technologies'] = array_map('trim', array_filter($technologies));
                } elseif (is_array($validated['technologies'])) {
                    $validated['technologies'] = array_map('trim', array_filter($validated['technologies']));
                } else {
                    $validated['technologies'] = [];
                }
            } else {
                $validated['technologies'] = [];
            }
            
            // Handle featured checkbox explicitly (checkboxes only send values when checked)
            $validated['featured'] = $request->has('featured') ? true : false;
            
            // Only set sort_order if it's provided; otherwise keep the existing value
            if (!isset($validated['sort_order']) || $validated['sort_order'] === null) {
                // Keep the existing sort_order
                $validated['sort_order'] = $project->sort_order;
            }
            
            \Log::info('Final validated data for update:', $validated);
            
            // Try updating project with error catching
            try {
                $project->update($validated);
                \Log::info('Project updated successfully: ' . $project->id);
                
                return redirect()->route('admin.projects.index')
                    ->with('success', 'Project updated successfully.');
            } catch (\Exception $e) {
                \Log::error('Database update error: ' . $e->getMessage());
                return back()->withErrors(['database' => 'Could not update project: ' . $e->getMessage()])->withInput();
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::warning('Validation failed: ' . json_encode($e->errors()));
            throw $e; // Re-throw validation exceptions as Laravel handles them automatically
        } catch (\Exception $e) {
            \Log::error('Unexpected error in update: ' . $e->getMessage());
            return back()->withErrors(['error' => 'An unexpected error occurred: ' . $e->getMessage()])->withInput();
        }
    }
    
    /**
     * Remove the specified project from storage.
     */
    public function destroy(Project $project)
    {
        // Delete project image if it exists
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        
        $project->delete();
        
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    /**
     * Remove the image from a project.
     */
    public function removeImage(Project $project)
    {
        // Delete project image if it exists
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
            $project->update(['image' => null]);
        }
        
        return redirect()->route('admin.projects.edit', $project)
            ->with('success', 'Project image removed successfully.');
    }
}
