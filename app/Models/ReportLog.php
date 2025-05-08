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
}