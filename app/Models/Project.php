<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'technologies',
        'github_url',
        'demo_url',
        'image',
        'featured',
        'sort_order'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'technologies' => 'array', // This will handle JSON conversion automatically
        'featured' => 'boolean',
    ];

    /**
     * Scope a query to only include featured projects.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Get the technologies as a comma-separated string.
     *
     * @return string
     */
    public function getTechnologiesStringAttribute()
    {
        if (!$this->technologies) {
            return '';
        }
        
        return is_array($this->technologies) ? implode(', ', $this->technologies) : '';
    }

    public function getTechnologiesArrayAttribute()
    {
        if (empty($this->technologies)) {
            return [];
        }
        
        if (is_string($this->technologies)) {
            return json_decode($this->technologies, true) ?? [];
        }
        
        return is_array($this->technologies) ? $this->technologies : [];
    }
}