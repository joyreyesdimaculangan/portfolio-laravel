<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'company',
        'location',
        'start_date',
        'end_date',
        'ongoing',
        'description',
        'achievements'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'ongoing' => 'boolean'
    ];
    
    /**
     * Get the formatted date range.
     *
     * @return string
     */
    public function getDateRangeAttribute()
    {
        $start = $this->start_date->format('M Y');
        if ($this->ongoing) {
            return $start . ' - Present';
        }
        
        return $start . ' - ' . ($this->end_date ? $this->end_date->format('M Y') : 'Present');
    }
    
    /**
     * Get the achievements as an array.
     *
     * @return array
     */
    public function getAchievementsArrayAttribute()
    {
        if (!$this->achievements) {
            return [];
        }
        
        // Split achievements by new lines
        return array_filter(explode("\n", $this->achievements));
    }
}
