<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
   

    // Store multiple experiences (with user_email)
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'experiences' => 'required|array',
            'experiences.*.job_title' => 'required|string|max:255',
            'experiences.*.employer' => 'required|string|max:255',
            'experiences.*.start_date' => 'required|date',
            'experiences.*.end_date' => 'nullable|date',
            'experiences.*.current_work' => 'required|boolean', // Assuming it's a boolean (0 or 1)
            'experiences.*.short_description' => 'nullable|string|max:500',
            'experiences.*.user_email' => 'required|email|max:255',
        ]);
    
        foreach ($validatedData['experiences'] as $experience) {
            // Check if an existing record matches the employer and job title
            $found = Experience::where('job_title', $experience['job_title'])
                                ->where('user_email', $experience['user_email'])
                                ->first();
   
            if ($found) {
                // Update the existing record
                $found->update([
                    'job_title' => $experience['job_title'],
                    'employer' => $experience['employer'],
                    'start_date' => $experience['start_date'],
                    'end_date' => $experience['end_date'],
                    'current_work' => $experience['current_work'],
                    'short_description' => $experience['short_description'],
                    'user_email' => $experience['user_email'],
                ]);
            } else {
                // Insert a new record
                Experience::create([
                    'job_title' => $experience['job_title'],
                    'employer' => $experience['employer'],
                    'start_date' => $experience['start_date'],
                    'end_date' => $experience['end_date'],
                    'current_work' => $experience['current_work'],
                    'short_description' => $experience['short_description'],
                    'user_email' => $experience['user_email'],
                ]);
            }
        }
    
        return response()->json([
            'message' => 'Experience records stored successfully',
            'data' => $validatedData['experiences']
        ], 201);
    }
    
    

    public function getByEmail($email){
        $records = Experience::where('user_email', $email)->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json([
            'message' => 'Records retrieved successfully',
            'data' => $records
        ], 200);
    }

    // Fetch a single experience by ID
    public function show($id)
    {
        $experience = Experience::findOrFail($id);
        return response()->json($experience);
    }

    // Update an existing experience
    public function update(Request $request, $id)
    {
        // Validation for update
        $request->validate([
            'job_title' => 'string|max:255',
            'employer' => 'string|max:255',
            'start_date' => 'date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'current_work' => 'boolean',
            'short_description' => 'nullable|string',
            'user_email' => 'nullable|email', // Optional validation for user_email
        ]);

        $experience = Experience::findOrFail($id);
        $experience->update($request->all());

        return response()->json([
            'message' => 'Experience updated successfully',
            'data' => $experience,
        ]);
    }

    // Delete an experience
    public function destroy($id)
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return response()->json(['message' => 'Experience deleted successfully']);
    }
}