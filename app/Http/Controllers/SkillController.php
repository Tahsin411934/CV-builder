<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller {
    /**
    * Store a newly created skill in the database.
    */

    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'hard_skills' => 'nullable|string',
            'soft_skills' => 'nullable|string',
            'user_email' => 'required|email|max:255',
        ]);
    
        // Check if a record with the provided user_email already exists
        $record = Skill::where('user_email', $validated['user_email'])->first();
    
        if ($record) {
            // If a record exists, update it
            $record->update([
                'hard_skills' => $validated['hard_skills'],
                'soft_skills' => $validated['soft_skills'],
            ]);
            $skill = $record; // Updated record
        } else {
            // If no record exists, create a new skill record
            $skill = Skill::create([
                'hard_skills' => $validated['hard_skills'],
                'soft_skills' => $validated['soft_skills'],
                'user_email' => $validated['user_email'],
            ]);
        }
    
        // Return a response
        return response()->json([
            'message' => 'Skill data stored successfully!',
            'data' => $skill,
        ], 201); // HTTP 201 - Created
    }
    public function getByEmail($email)
{
    $record = Skill::where('user_email', $email)->first();

    if (!$record) {  // Check if $record is null
        return response()->json(['message' => 'No records found'], 404);
    }

    return response()->json([
        'message' => 'Record retrieved successfully',
        'data' => $record
    ], 200);
}

}