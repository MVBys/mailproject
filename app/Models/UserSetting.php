<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class UserSetting extends Pivot
{
    public $table = 'user_setting';
}
