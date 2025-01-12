<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function store(Request $request)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'city' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'profession' => 'required|string|max:255',
            'postal_code' => 'required|string',
            'image' => 'nullable',
        ]);

        // Check if the email already exists in the database
        $dataByEmail = Test::where('email', $validated['email'])->first();

        // Handle the image upload
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('images', 'public')
            : ($dataByEmail ? $dataByEmail->image : null); // Keep existing image if updating

        if ($dataByEmail) {
            // Update the existing record
            $dataByEmail->update([
                'name' => $validated['name'],
                'city' => $validated['city'],
                'phone' => $validated['phone'],
                'country' => $validated['country'],
                'profession' => $validated['profession'],
                'postal_code' => $validated['postal_code'],
                'image' => $imagePath, // Update image if provided
            ]);

            // Return a success response for the update
            return response()->json([
                'message' => 'Data updated successfully.',
                'data' => $dataByEmail,
            ], 200); // 200 OK
        } else {
            // Create a new record if the email doesn't exist
            $test = Test::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'city' => $validated['city'],
                'phone' => $validated['phone'],
                'country' => $validated['country'],
                'profession' => $validated['profession'],
                'postal_code' => $validated['postal_code'],
                'image' => $imagePath,
            ]);

            // Return a success response for the creation
            return response()->json([
                'message' => 'Data stored successfully.',
                'data' => $test,
            ], 201); // 201 Created
        }
    }

    public function findDataByEmail($email)
    {
        // Retrieve data by email
        $dataByEmail = Test::where('email', $email)->first();

        if ($dataByEmail) {
            return response()->json([
                'message' => 'Data retrieved successfully.',
                'data' => $dataByEmail,
            ], 200); // 200 OK
        }

        // Return error if no data found
        return response()->json([
            'message' => 'No data found for the provided email.',
        ], 404); // 404 Not Found
    }
}
