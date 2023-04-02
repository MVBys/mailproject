<?php

namespace Tests\Feature;

use App\Http\Controllers\LetterController;
use App\Models\Letter;
use App\Models\User;
use Psy\Util\Str;
use Tests\BaseTestClass;

class LetterStoreTest extends BaseTestClass
{
    public function testStoreLetterSuccess(): void
    {
        $user = User::factory()->create();
        $request = [
            'email' => $user->email,
            'recipient' => $this->faker()->email(),
            'subject_letter' => $this->faker()->sentence(3),
            'img_token' => $this->faker->uuid(),
        ];

        $response = $this->postJson(action([LetterController::class, 'store']), $request);

        $response->assertStatus(201);

        $this->assertDatabaseHas('letters', [
            "recipient" => $request['recipient'],
            "subject_letter" => $request['subject_letter'],
            "user_id" => $user->id,
        ]);
    }
}
