<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasAvatar
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar_url'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function orders()
    {
        return $this->belongsToMany(Order::class, 'orders_users', 'users_id', 'orders_id')
            ->withTimestamps();
    }

    public function stores()
    {
        return $this->hasMany(Store::class, 'users_id');
    }

    public function getFilamentAvatarUrl(): ?string
    {
        return $this->avatar_url ? Storage::disk('profile-photos')->url($this->avatar_url) : 
        'https://ui-avatars.com/api/?name=' . $this->name . '&color=FFFFFF&background=09090b';
    }


    public function scopeOnlyAgents($query)
    {
        return $query->whereHas('roles', function ($query) {
            $query->where('name', 'agent');
        });
    }
}
