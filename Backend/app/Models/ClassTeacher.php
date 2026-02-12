<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ClassTeacher extends Model
{
    use HasFactory;

    protected $table = 'class_teacher';

    protected $fillable = [
        'class_id',
        'teacher_id',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function class(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id', 'id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teachers::class, 'teacher_id', 'id');
    }
}
