<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\BaseAdminController;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdminCertificateController extends BaseAdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $certificates = $this->paginateResults(
            Certificate::query(), 
            $request, 
            'issue_date',  
            'desc'         
        );
    
        return view('admin.certificates.index', compact('certificates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.certificates.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'proof_url' => 'nullable|url|max:255',
        ]);

        try {
            Certificate::create($validated);
            return redirect()->route('admin.certificates.index')
                           ->with('success', 'Certificate created successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to create certificate: ' . $e->getMessage());
            return back()->withInput()
                       ->withErrors(['error' => 'Failed to create certificate. Please try again.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Certificate $certificate)
    {
        return view('admin.certificates.show', compact('certificate'));
    }
    
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'issuer' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'proof_url' => 'nullable|url|max:255',
        ]);

        try {
            $certificate->update($validated);
            return redirect()->route('admin.certificates.index')
                           ->with('success', 'Certificate updated successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to update certificate: ' . $e->getMessage());
            return back()->withInput()
                       ->withErrors(['error' => 'Failed to update certificate. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Certificate $certificate)
    {
        try {
            $certificate->delete();
            return redirect()->route('admin.certificates.index')
                           ->with('success', 'Certificate deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to delete certificate: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to delete certificate. Please try again.']);
        }
    }
}
