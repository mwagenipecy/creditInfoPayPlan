<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class SearchLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'search_term',
        'search_type',
        'search_category',
        'cost',
        'loan_amount',
    ];

    /**
     * Get the user that performed the search.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}