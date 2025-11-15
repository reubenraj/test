<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        $educations = $request->user()->educations;
        return response()->json($educations);
    }

    public function store(Request $request)
    {
        $request->validate([
            'institution_name' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $education = $request->user()->educations()->create($request->all());

        return response()->json([
            'message' => 'Education added successfully',
            'education' => $education,
        ], 201);
    }

    public function show($id)
    {
        $education = Education::where('user_id', auth()->id())->findOrFail($id);
        return response()->json($education);
    }

    public function update(Request $request, $id)
    {
        $education = Education::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'institution_name' => 'nullable|string|max:255',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'description' => 'nullable|string',
        ]);

        $education->update($request->all());

        return response()->json([
            'message' => 'Education updated successfully',
            'education' => $education,
        ]);
    }

    public function destroy($id)
    {
        $education = Education::where('user_id', auth()->id())->findOrFail($id);
        $education->delete();

        return response()->json([
            'message' => 'Education deleted successfully',
        ]);
    }
}
