<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PastorProfile;
use Illuminate\Http\Request;

class PastorProfileController extends Controller
{
    public function index()
    {
        $profiles = PastorProfile::with('user')->get();
        return response()->json($profiles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_church_name' => 'nullable|string|max:255',
            'current_church_address' => 'nullable|string',
            'denomination' => 'nullable|string|max:255',
            'ordination_status' => 'nullable|string|max:255',
            'ordination_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|string',
        ]);

        $profile = $request->user()->pastorProfile()->updateOrCreate(
            ['user_id' => $request->user()->id],
            $request->all()
        );

        return response()->json([
            'message' => 'Profile saved successfully',
            'profile' => $profile,
        ]);
    }

    public function show($id)
    {
        $profile = PastorProfile::with('user')->findOrFail($id);
        return response()->json($profile);
    }

    public function update(Request $request, $id)
    {
        $profile = PastorProfile::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'current_church_name' => 'nullable|string|max:255',
            'current_church_address' => 'nullable|string',
            'denomination' => 'nullable|string|max:255',
            'ordination_status' => 'nullable|string|max:255',
            'ordination_date' => 'nullable|date',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|string',
        ]);

        $profile->update($request->all());

        return response()->json([
            'message' => 'Profile updated successfully',
            'profile' => $profile,
        ]);
    }

    public function destroy($id)
    {
        $profile = PastorProfile::where('user_id', auth()->id())->findOrFail($id);
        $profile->delete();

        return response()->json([
            'message' => 'Profile deleted successfully',
        ]);
    }

    public function myProfile(Request $request)
    {
        $profile = $request->user()->pastorProfile;
        return response()->json($profile);
    }
}
