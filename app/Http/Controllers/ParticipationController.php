<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ParticipationController extends Controller
{
    public function store(Request $request)
    {
        if ($request->eventId && $request->action) {
            $event = Event::find($request->eventId);
            if ($event) {
                if ($request->action === 'join') {
                    $event->participants()->attach(Auth::user()->id);

                    return response()->json(['success' => true, 'action' => 'leave', 'message' => 'Event updated successfully']);
                } elseif ($request->action === 'leave') {
                    $event->participants()->detach(Auth::user()->id);
                    return response()->json(['success' => true, 'action' => 'join', 'message' => 'Event updated successfully']);
                }
            } else {
                return response()->json(['success' => false, 'message' => 'Event not found'], 404);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Invalid request'], 400);
        }
    }
}
