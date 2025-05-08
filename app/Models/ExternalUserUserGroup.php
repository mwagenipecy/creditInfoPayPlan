<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExternalUserUserGroup extends Pivot
{
    use HasFactory;
    
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'external_user_user_group';
    
    /**
     * Get the external user that belongs to this relationship.
     */
    public function externalUser()
    {
        return $this->belongsTo(ExternalUser::class);
    }
    
    /**
     * Get the user group that belongs to this relationship.
     */
    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class);
    }
}