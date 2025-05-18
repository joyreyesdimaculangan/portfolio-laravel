<?php

namespace App\Http\Controllers\Admin;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\BaseAdminController;
use Illuminate\Support\Str;

class AdminEducationController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $education = $this->paginateResults(
            Education::query(), 
            $request, 
            'start_date',  // Default sort field
            'desc'         // Default direction
        );
        
        return view('admin.education.index', compact('education'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.education.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'ongoing' => 'nullable|boolean',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);
        
        // Handle the ongoing checkbox
        $validated['ongoing'] = $request->has('ongoing');
        
        // If ongoing is checked, set end_date to null
        if ($validated['ongoing']) {
            $validated['end_date'] = null;
        }
        
        Education::create($validated);
        
        return redirect()->route('admin.education.index')
            ->with('success', 'Education record created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Education $education)
    {
        return view('admin.education.show', compact('education'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Education $education)
    {
        return view('admin.education.edit', compact('education'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Education $education)
    {
        $validated = $request->validate([
            'institution' => 'required|string|max:255',
            'degree' => 'required|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'ongoing' => 'nullable|boolean',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
        ]);
        
        // Handle the ongoing checkbox
        $validated['ongoing'] = $request->has('ongoing');
        
        // If ongoing is checked, set end_date to null
        if ($validated['ongoing']) {
            $validated['end_date'] = null;
        }
        
        $education->update($validated);
        
        return redirect()->route('admin.education.index')
            ->with('success', 'Education record updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Education $education)
    {
        $education->delete();
        
        return redirect()->route('admin.education.index')
            ->with('success', 'Education record deleted successfully.');
    }
}
