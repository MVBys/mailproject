<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;
use Laravel\Sanctum\HasApiTokens;

/**
 * @property integer $id
 * @property string $email
 * @property string $pro_status
 * @property-read  Collection $letters
 * @property-read  Collection $settings
 */
class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'pro_status'
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
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function booted(): void
    {
        static::created(function (User $user) {
            $setting = Setting::all();
            $user->settings()->sync($setting);
        });
    }

    public function letters(): HasMany
    {
        return $this->hasMany(Letter::class);
    }

    public function settings(): BelongsToMany
    {
        return $this->belongsToMany(Setting::class, UserSetting::class)
            ->withPivot('enabled');
    }

    public function isPro(): bool
    {
        return !!$this->pro_status;
    }
}
