<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountUsageLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'reports_used',
        'remaining_reports',
        'action_type',
        'metadata',
        'used_at',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'metadata' => 'array',
        'reports_used' => 'integer',
        'remaining_reports' => 'integer',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
