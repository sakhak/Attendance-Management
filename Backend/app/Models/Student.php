<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasOne;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'student_code',
        'status',
    ];

    // Relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enrollments(): hasOne
    {
        return $this->hasOne(Enrollment::class, 'student_id');
    }
}
