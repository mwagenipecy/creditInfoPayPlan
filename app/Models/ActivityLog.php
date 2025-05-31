<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    protected $guarded=[];

    


    public function user(){

        return $this->belongsTo(User::class);
    }


    /**
     * Get the subject of the activity (polymorphic)
     */
    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the company associated with the activity
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * Scope for filtering by activity type
     */
    public function scopeOfActivity($query, $activity)
    {
        return $query->where('activity', $activity);
    }

    /**
     * Scope for filtering by user
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope for filtering by company
     */
    public function scopeByCompany($query, $companyId)
    {
        return $query->where('company_id', $companyId);
    }

    /**
     * Get formatted activity description
     */
    public function getFormattedDescriptionAttribute(): string
    {
        return $this->description ?? "Activity: {$this->activity}";
    }

    /**
     * Get human-readable changes
     */
    public function getFormattedChangesAttribute(): array
    {
        $formatted = [];
        
        if (!$this->changes) {
            return $formatted;
        }

        foreach ($this->changes as $field => $change) {
            $formatted[] = [
                'field' => $this->formatFieldName($field),
                'from' => $change['from'] ?? 'N/A',
                'to' => $change['to'] ?? 'N/A'
            ];
        }
        
        return $formatted;
    }

    /**
     * Format field names for display
     */
    private function formatFieldName(string $field): string
    {
        return match($field) {
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email Address',
            'company' => 'Company',
            'role' => 'Role',
            'status' => 'Account Status',
            'password' => 'Password',
            'created_at' => 'Created Date',
            'updated_at' => 'Updated Date',
            default => ucfirst(str_replace('_', ' ', $field))
        };
    }



}
