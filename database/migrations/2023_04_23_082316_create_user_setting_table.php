<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_setting', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Setting::class)->constrained()->cascadeOnDelete();
            $table->unique(['user_id','setting_id']);
            $table->boolean('enabled')->default(false);
            $table->timestamps();
        });

        $settings = Setting::all();
        User::all()->each(function (User $user) use ($settings) {
            $user->settings()->sync($settings);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_setting');
    }
};
