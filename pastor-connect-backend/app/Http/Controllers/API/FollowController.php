<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function follow(Request $request, $userId)
    {
        $userToFollow = User::findOrFail($userId);

        if ($request->user()->id === $userToFollow->id) {
            return response()->json([
                'message' => 'You cannot follow yourself',
            ], 400);
        }

        if ($request->user()->isFollowing($userToFollow)) {
            return response()->json([
                'message' => 'You are already following this pastor',
            ], 400);
        }

        $request->user()->follow($userToFollow);

        return response()->json([
            'message' => 'Successfully followed pastor',
        ]);
    }

    public function unfollow(Request $request, $userId)
    {
        $userToUnfollow = User::findOrFail($userId);

        if (!$request->user()->isFollowing($userToUnfollow)) {
            return response()->json([
                'message' => 'You are not following this pastor',
            ], 400);
        }

        $request->user()->unfollow($userToUnfollow);

        return response()->json([
            'message' => 'Successfully unfollowed pastor',
        ]);
    }

    public function followers(Request $request)
    {
        $followers = $request->user()->followers()->with('pastorProfile')->get();
        return response()->json($followers);
    }

    public function following(Request $request)
    {
        $following = $request->user()->following()->with('pastorProfile')->get();
        return response()->json($following);
    }

    public function pastors(Request $request)
    {
        $pastors = User::with('pastorProfile')
            ->where('id', '!=', $request->user()->id)
            ->get();

        return response()->json($pastors);
    }
}
