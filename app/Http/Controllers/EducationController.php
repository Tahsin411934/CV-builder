<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    // Store multiple records at once
    public function store(Request $request)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'educations' => 'required|array',
            'educations.*.name_of_institute' => 'required|string|max:255',
            'educations.*.name_of_exam' => 'required|string|max:255',
            'educations.*.institute' => 'nullable|string|max:255',
            'educations.*.board' => 'nullable|string|max:100',
            'educations.*.CGPA' => 'nullable|numeric',
            'educations.*.user_mail' => 'required|email|max:255',
        ]);
    
        foreach ($validatedData['educations'] as $education) {
            // Check if an existing record matches the institute
            $found = Education::where('institute', $education['institute'])->first();
    
            if ($found) {
                // Update the existing record
                $found->update($education);
            } else {
                // Insert a new record
                Education::create($education);
            }
        }
    
        return response()->json([
            'message' => 'Records stored successfully',
            'data' => $validatedData['educations']
        ], 201);
    }
    

    // Get records by user_mail
    public function getByUserMail($user_mail)
    {
        // Fetch records for the given user_mail
        $records = Education::where('user_mail', $user_mail)->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json([
            'message' => 'Records retrieved successfully',
            'data' => $records
        ], 200);
    }

    // Update a record
    public function update(Request $request, $id)
    {
        // Find the record
        $education = Education::find($id);

        if (!$education) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Validate incoming data
        $validatedData = $request->validate([
            'name_of_institute' => 'nullable|string|max:255',
            'name_of_exam' => 'nullable|string|max:255',
            'institute' => 'nullable|string|max:255',
            'board' => 'nullable|string|max:100',
            'CGPA' => 'nullable|numeric',
            'user_mail' => 'nullable|email|max:255',
        ]);

        // Update the record
        $education->update($validatedData);

        return response()->json([
            'message' => 'Record updated successfully',
            'data' => $education
        ], 200);
    }

    // Delete a record
    public function destroy($id)
    {
        // Find the record
        $education = Education::find($id);

        if (!$education) {
            return response()->json(['message' => 'Record not found'], 404);
        }

        // Delete the record
        $education->delete();

        return response()->json(['message' => 'Record deleted successfully'], 200);
    }
}
