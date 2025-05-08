<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExternalUser extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'organization',
        'has_access',
        'access_level',
        'access_expires_at',
        'access_revoked_at',
        'access_revoked_by',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'has_access' => 'boolean',
        'access_expires_at' => 'datetime',
        'access_revoked_at' => 'datetime',
    ];

    /**
     * Get the access requests for this external user.
     */
    public function accessRequests()
    {
        return $this->hasMany(AccessRequest::class, 'external_user_id');
    }

    /**
     * Get the user groups this external user belongs to.
     */
  

    /**
     * Get the user who revoked this external user's access.
     */
    public function revokedBy()
    {
        return $this->belongsTo(User::class, 'access_revoked_by');
    }

    public function userGroups()
{
    return $this->belongsToMany(UserGroup::class, 'external_user_user_group')
                ->using(ExternalUserUserGroup::class)
                ->withTimestamps();
}

}