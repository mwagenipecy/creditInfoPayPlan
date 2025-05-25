<?php
// app/Models/ReportLog.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportLog extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'creditinfo_id',
        'retrieved_at',
    ];
    
    protected $casts = [
        'retrieved_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Scope to get reports for a specific company
     */
    public function scopeForCompany($query, $companyId)
    {
        return $query->whereHas('user', function($q) use ($companyId) {
            $q->where('company_id', $companyId);
        });
    }

    /**
     * Scope to get unique credit reports for a company
     */
    public function scopeUniqueForCompany($query, $companyId)
    {
        return $query->forCompany($companyId)
            ->select('creditinfo_id')
            ->distinct();
    }

    /**
     * Scope to get reports within a date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('retrieved_at', [$startDate, $endDate]);
    }

    /**
     * Scope to get recent reports
     */
    public function scopeRecent($query, $days = 30)
    {
        return $query->where('retrieved_at', '>=', now()->subDays($days));
    }

    /**
     * Check if this creditinfo_id has been retrieved by the company before
     */
    public static function hasBeenRetrievedByCompany($creditinfoId, $companyId)
    {
        return self::whereHas('user', function($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
        ->where('creditinfo_id', $creditinfoId)
        ->exists();
    }

    /**
     * Get the count of unique credit reports for a company
     */
    public static function uniqueCountForCompany($companyId)
    {
        return self::whereHas('user', function($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
        ->distinct('creditinfo_id')
        ->count('creditinfo_id');
    }


}