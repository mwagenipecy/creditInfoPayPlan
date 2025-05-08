<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'requester_id',
        'external_user_id',
        'user_group_id',
        'reason',
        'access_level',
        'expiry_date',
        'status',
        'approved_by',
        'approved_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'expiry_date' => 'datetime',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the requester of this access request.
     */
    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id');
    }

    /**
     * Get the external user this request is for.
     */
    public function externalUser()
    {
        return $this->belongsTo(ExternalUser::class, 'external_user_id');
    }

    /**
     * Get the user group this request is for (if applicable).
     */
    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class, 'user_group_id');
    }

    /**
     * Get the user who approved or rejected this request.
     */
    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}