<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use App\Models\PrayerRequestReply;
use Illuminate\Http\Request;

class PrayerRequestReplyController extends Controller
{
    public function store(Request $request, $prayerRequestId)
    {
        $prayerRequest = PrayerRequest::findOrFail($prayerRequestId);

        $request->validate([
            'reply' => 'required|string',
        ]);

        $reply = PrayerRequestReply::create([
            'prayer_request_id' => $prayerRequestId,
            'user_id' => $request->user()->id,
            'reply' => $request->reply,
        ]);

        $reply->load('user.pastorProfile');

        return response()->json([
            'message' => 'Reply added successfully',
            'reply' => $reply,
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $reply = PrayerRequestReply::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'reply' => 'required|string',
        ]);

        $reply->update(['reply' => $request->reply]);

        return response()->json([
            'message' => 'Reply updated successfully',
            'reply' => $reply,
        ]);
    }

    public function destroy($id)
    {
        $reply = PrayerRequestReply::where('user_id', auth()->id())->findOrFail($id);
        $reply->delete();

        return response()->json([
            'message' => 'Reply deleted successfully',
        ]);
    }
}
