<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PrayerRequest;
use Illuminate\Http\Request;

class PrayerRequestController extends Controller
{
    public function index()
    {
        $prayerRequests = PrayerRequest::with(['user.pastorProfile', 'replies.user'])
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($prayerRequests);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'in:open,answered,closed',
            'is_anonymous' => 'boolean',
        ]);

        $prayerRequest = $request->user()->prayerRequests()->create($request->all());

        return response()->json([
            'message' => 'Prayer request created successfully',
            'prayer_request' => $prayerRequest,
        ], 201);
    }

    public function show($id)
    {
        $prayerRequest = PrayerRequest::with(['user.pastorProfile', 'replies.user.pastorProfile'])
            ->findOrFail($id);

        return response()->json($prayerRequest);
    }

    public function update(Request $request, $id)
    {
        $prayerRequest = PrayerRequest::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'in:open,answered,closed',
            'is_anonymous' => 'boolean',
        ]);

        $prayerRequest->update($request->all());

        return response()->json([
            'message' => 'Prayer request updated successfully',
            'prayer_request' => $prayerRequest,
        ]);
    }

    public function destroy($id)
    {
        $prayerRequest = PrayerRequest::where('user_id', auth()->id())->findOrFail($id);
        $prayerRequest->delete();

        return response()->json([
            'message' => 'Prayer request deleted successfully',
        ]);
    }

    public function myPrayerRequests(Request $request)
    {
        $prayerRequests = $request->user()->prayerRequests()
            ->with('replies.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json($prayerRequests);
    }

    public function updateStatus(Request $request, $id)
    {
        $prayerRequest = PrayerRequest::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'status' => 'required|in:open,answered,closed',
        ]);

        $prayerRequest->update(['status' => $request->status]);

        return response()->json([
            'message' => 'Prayer request status updated successfully',
            'prayer_request' => $prayerRequest,
        ]);
    }
}
