<?php

namespace App\Http\Controllers;

use App\Models\Objective;
use Illuminate\Http\Request;

class ObjectiveController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $objectives = Objective::all();
        return response()->json($objectives);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Typically used for returning a view (for web apps).
        // Not needed for APIs unless you're returning a custom form structure.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'objective' => 'required|string|max:1000',
            'user_email' => 'required|email',
        ]);
    
        // Check if a record exists with the given user_email
        $found = Objective::where('user_email', $validatedData['user_email'])->first();
    
        if ($found) {
            // Update the existing record
            $found->update(['objective' => $validatedData['objective']]);
            $objective = $found; // Updated record
        } else {
            // Create a new record
            $objective = Objective::create($validatedData);
        }
    
        return response()->json(['message' => 'Objective saved successfully', 'data' => $objective], 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function getByEmail($email)
{
    $record = Objective::where('user_email', $email)->first();

    if (!$record) {  // Check if $record is null
        return response()->json(['message' => 'No records found'], 404);
    }

    return response()->json([
        'message' => 'Record retrieved successfully',
        'data' => $record
    ], 200);
}


   
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $objective = Objective::find($id);

        if (!$objective) {
            return response()->json(['message' => 'Objective not found'], 404);
        }

        $objective->delete();

        return response()->json(['message' => 'Objective deleted successfully']);
    }
}
