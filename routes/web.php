<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPersonalInfoController;
use App\Http\Controllers\Admin\AdminProjectController;
use App\Http\Controllers\Admin\AdminSkillController;
use App\Http\Controllers\Admin\AdminEducationController;
use App\Http\Controllers\Admin\AdminExperienceController;
use App\Http\Controllers\Admin\AdminCertificateController;
use App\Http\Controllers\Admin\AdminContactMessageController;
use App\Http\Controllers\Admin\AdminResumeController;
use App\Http\Controllers\Admin\AppearanceController;
use App\Http\Controllers\ResumeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Main public pages
Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/projects', [PageController::class, 'projects'])->name('projects');
Route::get('/projects/{project}', [PageController::class, 'showProject'])->name('projects.show'); 
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'submitContactForm'])->name('contact.submit');

// Resume routes - consolidated
Route::get('/download-cv', [PageController::class, 'downloadCV'])->name('download.cv');
Route::get('/resume', [ResumeController::class, 'customize'])->name('resume.customize');
Route::get('/resume/pdf', [ResumeController::class, 'generatePDF'])->name('resume.pdf');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// Admin routes - protected by authentication
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Resume settings routes
    Route::get('/resume/settings', [AdminResumeController::class, 'settings'])->name('resume.settings');
    Route::post('/resume/settings', [AdminResumeController::class, 'updateSettings'])->name('resume.settings.update');
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // Personal Info management
    Route::resource('personal-info', AdminPersonalInfoController::class);
    
    // Projects management
    Route::resource('projects', AdminProjectController::class);
    Route::delete('projects/{project}/remove-image', [AdminProjectController::class, 'removeImage'])
        ->name('projects.remove-image');
    
    // Skills management
    Route::resource('skills', AdminSkillController::class);
    
    // Education management
    Route::resource('education', AdminEducationController::class);
    
    // experiences management
    Route::resource('experiences', AdminExperienceController::class);
    
    // Certificate management
    Route::resource('certificates', AdminCertificateController::class);
    
    // Contact message management
    Route::get('messages', [AdminContactMessageController::class, 'index'])->name('messages.index');
    Route::get('messages/{message}', [AdminContactMessageController::class, 'show'])->name('messages.show');
    Route::delete('messages/{message}', [AdminContactMessageController::class, 'destroy'])->name('messages.destroy');
    Route::patch('messages/{message}/mark-as-read', [AdminContactMessageController::class, 'markAsRead'])
        ->name('messages.mark-as-read');
    Route::patch('messages/{message}/mark-as-replied', [AdminContactMessageController::class, 'markAsReplied'])
        ->name('messages.mark-as-replied');

    // Appearance settings
    Route::get('/appearance', [AppearanceController::class, 'index'])->name('appearance');
    Route::post('/appearance', [AppearanceController::class, 'update'])->name('appearance.update');
    Route::get('/appearance/reset', [AppearanceController::class, 'reset'])->name('appearance.reset');
});

/*
|--------------------------------------------------------------------------
| Default Dashboard Redirect
|--------------------------------------------------------------------------
*/

// Add this line to fix the "Route [dashboard] not defined" error
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| User Profile Routes
|--------------------------------------------------------------------------
*/

// Keep original auth routes for user profile management
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Laravel's auth routes
require __DIR__.'/auth.php';
