<?php

namespace Tests\Feature;

use App\Http\Controllers\LetterController;
use App\Models\Letter;
use App\Models\User;
use Tests\BaseTestClass;

class LetterUpdateTest extends BaseTestClass
{
    public function testUpdateLetterSuccess(): void
    {
        $user = User::factory()->create();
        $letter = Letter::factory()->create([
            'user_id'=>$user->id,
            'read_count'=>0,
        ]);


        $response = $this->getJson(action([LetterController::class, 'update'],$letter->img_token));

        $response->assertStatus(200);
        $letter->refresh();
        $this->assertTrue($letter->last_open == now());
        $this->assertTrue($letter->read_count === 1);
    }
}
