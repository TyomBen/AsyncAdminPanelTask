<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateEventRequest;
use App\Models\Event;
use App\Models\EventUser;
use Illuminate\Support\Facades\Auth;

class CreateEventController extends Controller
{
    public function store(CreateEventRequest $request)
    {
        $event = Event::create([
            'creator_id' => Auth::user()->id,
            'title' => $request->title,
            'text' => $request->text,
        ]);
        return response()->json($event, 201);
    }
}
