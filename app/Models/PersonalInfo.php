<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'personal_info';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'section',
        'type',
        'is_public'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_public' => 'boolean'
    ];

    /**
     * Scope a query to only include public information.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }

    /**
     * Scope a query to only include items from a specific section.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $section
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeInSection($query, $section)
    {
        return $query->where('section', $section);
    }

    /**
     * Get value by key (static helper method).
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public static function getValue($key, $default = null)
    {
        $info = static::where('key', $key)->first();
        
        return $info ? $info->value : $default;
    }

    /**
     * Get all public personal info as an associative array.
     *
     * @param  string|null  $section  Optional section filter
     * @return array
     */
    public static function getPublicInfo($section = null)
    {
        $query = static::where('is_public', true);
        
        if ($section) {
            $query->where('section', $section);
        }
        
        return $query->get()
            ->keyBy('key')
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Get all public personal info merged with section-specific info.
     *
     * @param  string|null  $section  Section to merge with global data
     * @return \Illuminate\Support\Collection
     */
    public static function getInfoForSection($section = null)
    {
        // Get all public personal info (globally accessible)
        $globalInfo = self::where('is_public', true)
            ->get()
            ->pluck('value', 'key');
        
        // If no section specified, just return global info
        if (!$section) {
            return $globalInfo;
        }
        
        // Get section-specific info
        $sectionInfo = self::where('is_public', true)
            ->where('section', $section)
            ->get()
            ->pluck('value', 'key');
        
        // Merge them with section-specific values taking precedence
        return $globalInfo->merge($sectionInfo);
    }
}
