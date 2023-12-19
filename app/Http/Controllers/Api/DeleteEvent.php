<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class DeleteEvent extends Controller
{
    public function delete(Request $request)
    {
        $event = Event::find($request->id);

        if ($event) {
            $event->delete();
            return response()->json(null, 204);
        } else {
            return response()->json(['error' => 'Not Found'], 404);
        }
    }
}
