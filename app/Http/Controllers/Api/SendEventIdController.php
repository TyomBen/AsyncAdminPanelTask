<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SendEventIdController extends Controller
{
    public function store(Request $request)
    {
        $event = Event::with('participants')->find($request->event_id);
        if ($event) {
            $currentUser = Auth::user();
            $eventParticipants = $event->participants->contains($currentUser->id);
            if ($eventParticipants) {
                return response()->json(['isParticipant' => true, 'participants' => $event]);
            } else {
                return response()->json(['isParticipant' => false, 'participants' => $event]);
            }
        } else {
            return response()->json(['isParticipant' => false]);
        }
    }
}
