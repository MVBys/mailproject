<?php

namespace Tests\Feature;

use App\Http\Controllers\LetterController;
use App\Models\Letter;
use App\Models\User;
use Tests\BaseTestClass;

class LetterIndexTest extends BaseTestClass
{
    public function testIndexLetterSuccess(): void
    {
        $user = User::factory()->create();
        Letter::factory()->count($this->faker()->randomDigitNotNull())->create([
            'user_id' => $user->id,
        ]);

        $response = $this->getJson(action([LetterController::class, 'index'], $user->id));

        $response->assertStatus(200);
    }
}
