<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Models\Skill; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminSkillController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $category = $request->query('category');

        $query = Skill::organized();

        if ($category) {
            $query->where('category', $category);
        }

        $skills = $this->paginateResults(
            $query, 
            $request,
            'category',  // Default sort field
            'asc'       // Default direction
        );

        $skillsByCategory = $skills->groupBy('category');

        $categories = Skill::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');

        return view('admin.skills.index', compact('skillsByCategory', 'skills', 'categories', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     * 
     */
    public function create()
    {
        $categories = Skill::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');
        
        return view('admin.skills.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'proficiency' => 'required|integer|min:0|max:100',
            'category' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        
        // If order is not provided, set it to the next available number in the category
        if (!isset($validated['sort_order']) || is_null($validated['sort_order'])) {
            try {
                $maxOrder = Skill::where('category', $validated['category'])
                            ->max('sort_order') ?? 0;
                $validated['sort_order'] = $maxOrder + 1;
            } catch (\Exception $e) {
                $validated['sort_order'] = 1;
                Log::warning('Could not determine max order: ' . $e->getMessage());
            }
        }
        
        try {
            $skill = Skill::create($validated);
            
            // THIS IS LIKELY LINE 61 - Make sure you're returning the redirect
            return redirect()->route('admin.skills.index')
                        ->with('success', 'Skill created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create skill: ' . $e->getMessage());
            
            return back()->withInput()
                    ->withErrors(['error' => 'Failed to create skill: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Skill $skill)
    {
        return view('admin.skills.show', compact('skill'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Skill $skill)
    {
        $categories = Skill::select('category')
            ->distinct()
            ->whereNotNull('category')
            ->pluck('category');
        
        return view('admin.skills.edit', compact('skill', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'proficiency' => 'required|integer|min:0|max:100',
            'category' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);
        
        try {
            $skill->update($validated);
            
            return redirect()->route('admin.skills.index')
                ->with('success', 'Skill updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update skill: ' . $e->getMessage());
            
            return back()->withInput()
                ->withErrors(['error' => 'Failed to update skill. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Skill $skill)
    {
        try {
            $skill->delete();
            
            return redirect()->route('admin.skills.index')
                ->with('success', 'Skill deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete skill: ' . $e->getMessage());
            
            return back()->withErrors(['error' => 'Failed to delete skill. Please try again.']);
        }
    }
}
