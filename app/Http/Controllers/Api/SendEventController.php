<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\GetEventResource;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SendEventController extends Controller
{
    public function index ()
    {
        $events = Event::with('participants')->get();
        $myEvents = Event::where('creator_id', Auth::user()->id)->get();
        return response()->json([
            'myEvents' => $myEvents,
            'allEvents' =>  GetEventResource::collection($events),
        ], 200);
    }
}
