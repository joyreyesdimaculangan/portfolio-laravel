<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    
    /**
     * Specify the table name (since "education" is singular).
     *
     * @var string
     */
    protected $table = 'education';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'institution',
        'degree',
        'field_of_study',
        'start_date',
        'end_date',
        'ongoing',
        'description',
        'location'
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
}
