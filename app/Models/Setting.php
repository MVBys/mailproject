<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

/**
 * @property boolean $is_pro
 * @property string $name
 * @property string $description
 * @property-read  Collection $users
 */
class Setting extends Model
{
    use HasFactory;

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, UserSetting::class)
            ->withPivot('enabled');
    }
}
