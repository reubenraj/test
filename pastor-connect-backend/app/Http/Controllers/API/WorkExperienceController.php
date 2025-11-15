<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\WorkExperience;
use Illuminate\Http\Request;

class WorkExperienceController extends Controller
{
    public function index(Request $request)
    {
        $workExperiences = $request->user()->workExperiences;
        return response()->json($workExperiences);
    }

    public function store(Request $request)
    {
        $request->validate([
            'church_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_current' => 'boolean',
            'responsibilities' => 'nullable|string',
        ]);

        $workExperience = $request->user()->workExperiences()->create($request->all());

        return response()->json([
            'message' => 'Work experience added successfully',
            'work_experience' => $workExperience,
        ], 201);
    }

    public function show($id)
    {
        $workExperience = WorkExperience::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($workExperience);
    }

    public function update(Request $request, $id)
    {
        $workExperience = WorkExperience::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'church_name' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'is_current' => 'boolean',
            'responsibilities' => 'nullable|string',
        ]);

        $workExperience->update($request->all());

        return response()->json([
            'message' => 'Work experience updated successfully',
            'work_experience' => $workExperience,
        ]);
    }

    public function destroy($id)
    {
        $workExperience = WorkExperience::where('user_id', auth()->id())->findOrFail($id);
        $workExperience->delete();

        return response()->json([
            'message' => 'Work experience deleted successfully',
        ]);
    }
}
