<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('description')->nullable();
            $table->boolean('is_pro');
            $table->timestamps();
        });


        DB::table('settings')->insert([
            [
                'name' => 'emails_opened',
                'description' => 'when emails are opened',
                'is_pro' => false
            ],
            [
                'name' => 'not_opened_24',
                'description' => "if email's not opened in 24h",
                'is_pro' => false
            ],
            [
                'name' => 'no_reply_72',
                'description' => "if there's no reply in 72h",
                'is_pro' => true
            ],
            [
                'name' => 'daily_report',
                'description' => "daily report",
                'is_pro' => true
            ],
            [
                'name' => 'many_opened',
                'description' => "if email's opened many times",
                'is_pro' => true
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
