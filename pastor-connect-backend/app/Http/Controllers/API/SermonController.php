<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Sermon;
use Illuminate\Http\Request;

class SermonController extends Controller
{
    public function index(Request $request)
    {
        $query = Sermon::with('user.pastorProfile');

        // Only show published sermons unless viewing own sermons
        if (!$request->has('my_sermons')) {
            $query->where('is_published', true);
        } else {
            $query->where('user_id', $request->user()->id);
        }

        $sermons = $query->orderBy('created_at', 'desc')->get();
        return response()->json($sermons);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'scripture_reference' => 'nullable|string|max:255',
            'content' => 'required|string',
            'preached_date' => 'nullable|date',
            'sermon_series' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $sermon = $request->user()->sermons()->create($request->all());

        return response()->json([
            'message' => 'Sermon created successfully',
            'sermon' => $sermon,
        ], 201);
    }

    public function show($id)
    {
        $sermon = Sermon::with('user.pastorProfile')->findOrFail($id);

        // Check if sermon is published or belongs to the authenticated user
        if (!$sermon->is_published && $sermon->user_id !== auth()->id()) {
            return response()->json([
                'message' => 'Sermon not found',
            ], 404);
        }

        return response()->json($sermon);
    }

    public function update(Request $request, $id)
    {
        $sermon = Sermon::where('user_id', $request->user()->id)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'scripture_reference' => 'nullable|string|max:255',
            'content' => 'required|string',
            'preached_date' => 'nullable|date',
            'sermon_series' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
            'is_published' => 'boolean',
        ]);

        $sermon->update($request->all());

        return response()->json([
            'message' => 'Sermon updated successfully',
            'sermon' => $sermon,
        ]);
    }

    public function destroy($id)
    {
        $sermon = Sermon::where('user_id', auth()->id())->findOrFail($id);
        $sermon->delete();

        return response()->json([
            'message' => 'Sermon deleted successfully',
        ]);
    }

    public function mySermons(Request $request)
    {
        $sermons = $request->user()->sermons()->orderBy('created_at', 'desc')->get();
        return response()->json($sermons);
    }
}
