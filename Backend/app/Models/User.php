<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        return $this->belongsToMany(Role::class, 'user_role')
            ->withTimestamps();
    }
    // public function permissions()
    // {
    //     // permissions through roles (no direct pivot in diagram)
    //     return Permission::query()
    //         ->select('permissions.*')
    //         ->join('role_permission', 'permissions.id', '=', 'role_permission.permission_id')
    //         ->join('user_role', 'role_permission.role_id', '=', 'user_role.role_id')
    //         ->where('user_role.user_id', $this->id)
    //         ->distinct();
    // }
    // public function hasRole(string $roleKey): bool
    // {
    //     return $this->roles()->where('key', $roleKey)->exists();
    // }

    // public function hasPermission(string $permissionKey): bool
    // {
    //     return $this->permissions()->where('permissions.key', $permissionKey)->exists();
    // }
}
