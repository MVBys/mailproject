<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $img_token
 * @property string $recipient
 * @property string $subject_letter
 * @property Carbon $last_open
 * @property integer $read_count
 * @property-read  User $user
 */
class Letter extends Model
{
    use HasFactory;

    public $guarded = [
        'id',
        'created_at',
        'updated_at'
    ];
    protected $casts = [
        'recipient' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
