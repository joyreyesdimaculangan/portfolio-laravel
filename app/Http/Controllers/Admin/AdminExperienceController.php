<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminExperienceController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $experiences = $this->paginateResults(
            Experience::query(), 
            $request, 
            'start_date',  
            'desc'         
        );

        return view('admin.experiences.index', compact('experiences'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.experiences.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'ongoing' => 'nullable|boolean',
            'description' => 'nullable|string',
            'achievements' => 'nullable|string',
        ]);

        // Handle the ongoing checkbox
        $validated['ongoing'] = $request->has('ongoing');

        // If ongoing is checked, set end_date to null
        if ($validated['ongoing']) {
            $validated['end_date'] = null;
        }

        try {
            Experience::create($validated);
            
            return redirect()->route('admin.experiences.index')
                ->with('success', 'Experience created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create experience: ' . $e->getMessage());
            
            return back()->withInput()
                ->withErrors(['error' => 'Failed to create experience. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Experience $experience)
    {
        return view('admin.experiences.show', compact('experience'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'company' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'ongoing' => 'nullable|boolean',
            'description' => 'nullable|string',
            'achievements' => 'nullable|string',
        ]);

        // Handle the ongoing checkbox
        $validated['ongoing'] = $request->has('ongoing');

        // If ongoing is checked, set end_date to null
        if ($validated['ongoing']) {
            $validated['end_date'] = null;
        }

        try {
            $experience->update($validated);
            
            return redirect()->route('admin.experiences.index')
                ->with('success', 'Experience updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update experience: ' . $e->getMessage());
            
            return back()->withInput()
                ->withErrors(['error' => 'Failed to update experience. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Experience $experience)
    {
        try {
            $experience->delete();
            
            return redirect()->route('admin.experiences.index')
                ->with('success', 'Experience deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete experience: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Failed to delete experience. Please try again.']);
        }
    }
}
