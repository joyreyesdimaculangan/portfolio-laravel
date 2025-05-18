<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'subject',
        'message',
        'read',
        'replied',
        'read_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'read' => 'boolean',
        'replied' => 'boolean',
        'read_at' => 'datetime'
    ];

    /**
     * Mark the message as read.
     *
     * @return bool
     */
    public function markAsRead()
    {
        if (!$this->read) {
            $this->read = true;
            $this->read_at = now();
            return $this->save();
        }
        
        return true;
    }

    /**
     * Mark the message as replied.
     *
     * @return bool
     */
    public function markAsReplied()
    {
        $this->replied = true;
        return $this->save();
    }
    
    /**
     * Scope a query to only include unread messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnread($query)
    {
        return $query->where('read', false);
    }
}
