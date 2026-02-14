<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'user_role', 'user_id', 'role_id');
    }
    public function userProfile(): HasOne
    {
        return $this->hasOne(UserProfile::class, 'user_id');
    }
    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id');
    }
    public function teacher(): HasOne
    {
        return $this->hasOne(Teacher::class, 'user_id');
    }
    public function reportexports():HasMany
    {
        return $this->hasMany(ReportExports::class, 'user_id');
    }
    public function recordedAttendance():HasMany
    {
        return $this->hasMany(AttendanceRecord::class, 'recorded_by');
    }
}
