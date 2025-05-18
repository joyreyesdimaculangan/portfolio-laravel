<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Models\PersonalInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminPersonalInfoController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $section = $request->query('section');
        
        $query = PersonalInfo::query();
        
        if ($section) {
            $query->where('section', $section);
        }
        
        $personalInfo = $this->paginateResults(
            $query, 
            $request, 
            'section',  
            'asc'       
        );
        
        // Get all unique sections for filter dropdown
        $sections = PersonalInfo::select('section')
            ->distinct()
            ->whereNotNull('section')
            ->pluck('section');
            
        return view('admin.personal-info.index', compact('personalInfo', 'sections', 'section'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.personal-info.create');
    }

    public function store(Request $request)
    {
        // Determine the actual key value to validate
        $actualKey = $request->key === 'custom' ? $request->custom_key : $request->key;
        $section = $request->section;

        // Check if the key-section combination already exists
        $existingInfo = PersonalInfo::where('key', $actualKey)
        ->where('section', $section)
        ->first();

        if ($existingInfo) {
            // Redirect to edit instead of creating
            return redirect()->route('admin.personal-info.edit', $existingInfo)
                ->with('info', "A record with key '{$actualKey}' in section '{$section}' already exists. Please edit the existing record.");
        }
        
        // Start with base validation rules
        $rules = [
            'key' => 'required|string|max:255',
            'custom_key' => $request->key === 'custom' ? 'required|string|max:255|alpha_dash' : 'nullable',
            'section' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'is_public' => 'boolean',
        ];

        // Determine if this is a file type
        $isFileType = in_array($request->type, ['image', 'file']);

        // Remove placeholder values from the request before validation
        $requestData = $request->all();
        if ($isFileType && isset($requestData['value']) && 
            in_array($requestData['value'], ['file_upload_placeholder', 'placeholder'])) {
            unset($requestData['value']);
            $request->replace($requestData);
        }
        
        // Apply conditional validation rules based on the input type
        if ($isFileType) {
            // For file uploads, require the file but not the value
            $rules['file_upload'] = 'required|file|max:5120';
            
            if ($request->type === 'image') {
                $rules['file_upload'] .= '|mimes:jpeg,png,jpg,gif,svg';
            }
        } else {
            // For non-file types, value is required
            $rules['value'] = 'required|string';
        }
        
        // Run validation
        $validated = $request->validate($rules);
        
        // Create the personal info entry
        $personalInfo = new PersonalInfo();
        $personalInfo->key = $actualKey;
        $personalInfo->section = $validated['section'];
        $personalInfo->type = $validated['type'];
        $personalInfo->is_public = $request->has('is_public');
        
        // Handle file uploads if needed
        if ($isFileType && $request->hasFile('file_upload')) {
            $file = $request->file('file_upload');
            
            if ($actualKey === 'profile_image') {
                // Special handling for profile image
                $filename = 'profile.' . $file->getClientOriginalExtension();
            } else {
                // Regular file upload
                $filename = time() . '_' . $file->getClientOriginalName();
            }

            // Store the file
            $path = $request->file('file_upload')->storeAs(
                'personal_info', $filename, 'public'
            );
            
            $personalInfo->value = $path;
        } else {
            // For non-file types, use the value from the form
            $personalInfo->value = $request->value;
        }
        
        $personalInfo->save();
        
        return redirect()->route('admin.personal-info.index')
            ->with('success', 'Personal information added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalInfo $personalInfo)
    {
        return view('admin.personal-info.show', compact('personalInfo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalInfo $personalInfo)
    {
        return view('admin.personal-info.edit', compact('personalInfo'));
    }

    public function update(Request $request, PersonalInfo $personalInfo)
    {
        // Determine if this is a file type
        $isFileType = in_array($request->type, ['image', 'file']);
        
        // DEBUG: Log incoming data
        \Log::info('Personal Info Update Request', [
            'type' => $request->type,
            'is_file_type' => $isFileType,
            'has_file' => $request->hasFile('file_upload'),
            'value_present' => $request->has('value'),
            'value' => $request->value,
        ]);

        // Determine the actual key value
        $actualKey = $request->key === 'custom' ? $request->custom_key : $request->key;
        
        // Check if the key has changed
        $keyHasChanged = $actualKey !== $personalInfo->key;
        
        // Build validation rules based on input type
        $rules = [
            'key' => 'required|string|max:255',
            'custom_key' => $request->key === 'custom' ? 'required|string|max:255|alpha_dash' : 'nullable',
            'section' => 'required|string|max:255',
            'type' => 'required|string|max:50',
            'is_public' => 'boolean',
        ];
        
        // Only check uniqueness if the key has actually changed
        if ($keyHasChanged) {
            // Check manually if the key exists elsewhere
            $keyExists = PersonalInfo::where('key', $actualKey)
                ->where('id', '!=', $personalInfo->id)
                ->exists();
                
            if ($keyExists) {
                return back()->withErrors(['key' => 'This key already exists. Keys must be unique across all sections.'])
                    ->withInput();
            }
        }
        
        // Determine if this was a file type before
        $wasFileType = in_array($personalInfo->type, ['image', 'file']);
        
        // Remove placeholder values from the request to avoid validation errors
        $requestData = $request->all();
        if ($isFileType && isset($requestData['value']) && 
            in_array($requestData['value'], ['file_upload_placeholder', 'placeholder'])) {
            unset($requestData['value']);
            $request->replace($requestData);
        }
        
        // Apply conditional validation rules based on type
        if ($isFileType) {
            // For file types, file_upload is only required when changing from non-file to file type
            if (!$wasFileType) {
                $rules['file_upload'] = 'required|file|max:5120';
            } else {
                $rules['file_upload'] = $request->hasFile('file_upload') ? 'file|max:5120' : 'nullable';
            }
            
            // Add specific validation for image types
            if ($request->type === 'image' && $request->hasFile('file_upload')) {
                $rules['file_upload'] .= '|mimes:jpeg,png,jpg,gif,svg';
            }
            
            // IMPORTANT FIX: For file types, completely exclude value from validation
            unset($rules['value']);
        } else {
            // Value is required when not uploading a file
            $rules['value'] = 'required|string';
        }
        
        // Validate the request
        $validated = $request->validate($rules);
        
        // Update personal info
        $personalInfo->key = $actualKey;
        $personalInfo->section = $validated['section'];
        $personalInfo->type = $validated['type'];
        $personalInfo->is_public = (bool)$request->input('is_public'); $request->input('is_public') == 1;
        
        // Handle file uploads if needed
        if ($isFileType && $request->hasFile('file_upload')) {
            // Delete old file if exists
            if (!empty($personalInfo->value)) {
                try {
                    if (Storage::disk('public')->exists($personalInfo->value)) {
                        Storage::disk('public')->delete($personalInfo->value);
                    } else if (str_starts_with($personalInfo->value, 'storage/')) {
                        Storage::delete(str_replace('storage/', 'public/', $personalInfo->value));
                    } else {
                        Storage::delete('public/' . $personalInfo->value);
                    }
                } catch (\Exception $e) {
                    \Log::error('Failed to delete old file: ' . $e->getMessage());
                    // Continue even if file removal failed
                }
            }

            $file = $request->file('file_upload');
            
            if ($actualKey === 'profile_image') {
                // Special handling for profile image
                $filename = 'profile.' . $file->getClientOriginalExtension();
                $path = $request->file('file_upload')->storeAs(
                    'personal_info', $filename, 'public'
                );
            } else {
                // Regular file upload
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $request->file('file_upload')->storeAs(
                    'personal_info', $filename, 'public'
                );
            }
            
            $personalInfo->value = 'storage/personal_info/' . $filename;
        } else if ($isFileType) {
            // This is a file type but no new file was uploaded
            // If we're changing from non-file to file type without a file, set value to empty string
            if (!$wasFileType) {
                $personalInfo->value = '';  // Empty string instead of null
            }
            // Otherwise, keep the existing file value
        } else {
            // For non-file types, update the value
            // FIX: Only check if the value is a placeholder, not if it exists
            if ($request->has('value') && 
                $request->value !== 'file_upload_placeholder' && 
                $request->value !== 'placeholder') {
                $personalInfo->value = $request->value;
            }
        }
        
        $personalInfo->save();
        $publicStatus = $personalInfo->is_public ? 'public' : 'private';
        return redirect()->route('admin.personal-info.index')
            ->with('success', 'Personal information updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalInfo $personalInfo)
    {
        // Delete file if it's an image or file
        if (in_array($personalInfo->type, ['image', 'file']) && !empty($personalInfo->value)) {
            try {
                // Try both possible storage formats
                if (Storage::disk('public')->exists($personalInfo->value)) {
                    Storage::disk('public')->delete($personalInfo->value);
                } else if (str_starts_with($personalInfo->value, 'storage/')) {
                    Storage::delete(str_replace('storage/', 'public/', $personalInfo->value));
                } else {
                    Storage::delete('public/' . $personalInfo->value);
                }
            } catch (\Exception $e) {
                \Log::error('Failed to delete file for personal info: ' . $e->getMessage());
                // Continue with deletion even if file removal failed
            }
        }
        
        $personalInfo->delete();
        
        return redirect()->route('admin.personal-info.index')
            ->with('success', 'Personal information deleted successfully.');
    }
}
