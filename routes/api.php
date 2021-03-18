<?php

use App\Models\Playground;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\PlaygroundRequest;


Route::get('/playgrounds/{playground:uuid}', fn (Playground $playground) => $playground);

Route::post('/playgrounds', function (PlaygroundRequest $request) {
    $request->validated();

    $hash = md5(implode('.', $request->only(['code'])));

    return Playground::firstOrCreate(
        ['hash' => $hash],
        array_merge($request->only(['code']), [
            'uuid' => Str::random(10),
        ])
    );
})->middleware(['throttle:api']);
