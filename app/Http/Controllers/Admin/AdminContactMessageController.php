<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class AdminContactMessageController extends Controller
{
    /**
     * Display a listing of the messages.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $messages = ContactMessage::orderBy('created_at', 'desc')->paginate(15);
        $unreadCount = ContactMessage::unread()->count();
        
        return view('admin.messages.index', compact('messages', 'unreadCount'));
    }
    
    /**
     * Display the specified message.
     *
     * @param  \App\Models\ContactMessage  $message
     * @return \Illuminate\View\View
     */
    public function show(ContactMessage $message)
    {
        // Mark as read when viewed
        $message->markAsRead();
        
        return view('admin.messages.show', compact('message'));
    }
    
    /**
     * Mark message as read.
     *
     * @param  \App\Models\ContactMessage  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsRead(ContactMessage $message)
    {
        $message->markAsRead();
        
        return back()->with('success', 'Message marked as read.');
    }
    
    /**
     * Mark message as replied.
     *
     * @param  \App\Models\ContactMessage  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function markAsReplied(ContactMessage $message)
    {
        $message->markAsReplied();
        
        return back()->with('success', 'Message marked as replied.');
    }
    
    /**
     * Remove the specified message.
     *
     * @param  \App\Models\ContactMessage  $message
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(ContactMessage $message)
    {
        $message->delete();
        
        return redirect()->route('admin.messages.index')
                         ->with('success', 'Message deleted successfully.');
    }
}
