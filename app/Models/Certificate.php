<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'issuer',
        'issue_date',
        'expiry_date',
        'credential_id',
        'proof_url'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'issue_date' => 'date',
        'expiry_date' => 'date'
    ];

    /**
     * Check if the certificate is still valid.
     *
     * @return bool
     */
    public function getIsValidAttribute()
    {
        return !$this->expiry_date || $this->expiry_date->isFuture();
    }
}
