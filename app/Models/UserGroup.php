<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];

    /**
     * Get the external users belonging to this group.
     */
    // public function externalUsers()
    // {
    //     return $this->belongsToMany(ExternalUser::class, 'external_user_user_group');
    // }

    /**
     * Get the access requests for this user group.
     */
    public function accessRequests()
    {
        return $this->hasMany(AccessRequest::class, 'user_group_id');
    }

    public function externalUsers()
{
    return $this->belongsToMany(ExternalUser::class, 'external_user_user_group')
                ->using(ExternalUserUserGroup::class)
                ->withTimestamps();
}
}