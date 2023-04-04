<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLetterRequest;
use App\Http\Resources\LetterCollection;
use App\Http\Resources\LetterResource;
use App\Mail\LetterRead;
use App\Models\Letter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class LetterController extends AbstractBaseController
{
    public function index(Request $request): LetterCollection
    {
        /**@var $user User */
        $user = Auth::getUser();
        $request->validate(['per_page' => 'int|min:1']);
        return new LetterCollection(
            $user->letters()->paginate($request->get('per_page', $this->parePage))->setPath('')
        );
    }

    public function store(StoreLetterRequest $request): LetterResource
    {
        /**@var $user User */
        $user = User::query()->Where('email', $request->get('email'))->first();

        $prepareData = array_merge($request->only('recipient', 'subject_letter'), [
            'img_token' => $request->get('img_token'),
            'user_id' => $user->id
        ]);

        $letter = $user->letters()->create($prepareData);

        return new LetterResource($letter);
    }

    public function update($uuid)
    {
        /**@var $letter Letter */
        $letter = Letter::query()->where('img_token', $uuid)->first();
        $letter->read_count = ++$letter->read_count;
        $letter->last_open = now();
        $letter->save();

        if ($letter->read_count === 1){
            Mail::to($letter->user)->send(new LetterRead($letter));
        }
    }

}
