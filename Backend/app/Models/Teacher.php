<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    use HasFactory;
    // protected $table = 'teacher';
    protected $fillable = [
        "user_id",
        "teacher_code",
        "status"
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function classes()
    {
        return $this->belongsToMany(
            Classes::class,
            'class_teacher',
            'teacher_id',
            'class_id'
        );
    }
    public function classSections():BelongsToMany
    {
        return $this->belongsToMany(ClassSection::class, 'class_teachers')
            ->withTimestamps();
    }
    public function attendencesRecords():HasMany
    {
        return $this->hasMany(AttendenceRecord::class, 'recorded_by', 'user_id');
    }
}
