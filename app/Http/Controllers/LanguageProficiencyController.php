<?php
namespace App\Http\Controllers;

use App\Models\LanguageProficiency;
use Illuminate\Http\Request;

class LanguageProficiencyController extends Controller
{
    

    // Store newly created resources in storage (bulk insert)
    public function store(Request $request)
    {
        // Validate the request data for multiple records
        $validatedData = $request->validate([
            'languages' => 'required|array',  // Ensure that it's an array of data
            'languages.*.Language' => 'required|string|max:100',  // Each entry must have a language
            'languages.*.Proficiency' => 'required|string|max:50', // Each entry must have a proficiency
            'languages.*.user_email' => 'required|email|max:100', // Each entry must have a valid email
        ]);
    
        // Iterate over each record
        foreach ($validatedData['languages'] as $data) {
            // Check if a record with the same Language and user_email already exists
            $found = LanguageProficiency::where('Language', $data['Language'])
                                         ->where('user_email', $data['user_email'])
                                         ->first();
    
            if ($found) {
                // If the record exists, update it
                $found->update([
                    'Proficiency' => $data['Proficiency'],
                ]);
            } else {
                // If the record does not exist, create a new one
                LanguageProficiency::create([
                    'Language' => $data['Language'],
                    'Proficiency' => $data['Proficiency'],
                    'user_email' => $data['user_email'],
                ]);
            }
        }
    
        // Return response (success message)
        return response()->json(['message' => 'Records added/updated successfully'], 201);
    }
    

    public function getByEmail($email){
        
        $records = LanguageProficiency::where('user_email', $email)->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json([
            'message' => 'Records retrieved successfully',
            'data' => $records
        ], 200);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $proficiency = LanguageProficiency::findOrFail($id);
        $proficiency->delete(); // Delete the proficiency record

        // Return response (usually a success message)
        return response()->json(['message' => 'Record deleted successfully']);
    }
}
