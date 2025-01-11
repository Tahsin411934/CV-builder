<?php
namespace App\Http\Controllers;

use App\Models\Heading;
use Illuminate\Http\Request;

class HeadingController extends Controller
{
    // Fetch heading by email
    public function show($email)
    {
        $heading = Heading::where('email', $email)->first();
        if ($heading) {
            return response()->json($heading);
        }
        return response()->json(['message' => 'Data not found'], 404);
    }

    // Store new heading
    public function store(Request $request)
    {
     
      
            $validated = $validated = $request->validate([
               
                'first_name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'profession' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'postal_code' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|email|max:255',
            ]);
    
        
    
        
        // Validate the incoming request
        

        // Handle the image upload
        

        // Store the data in the database
        $heading = Heading::create([
            'first_name' => $request->input('first_name'),
            'surname' => $request->input('surname'),
            'profession' => $request->input('profession'),
            'city' => $request->input('city'),
            'postal_code' => $request->input('postal_code'),
            'country' => $request->input('country'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            
        ]);

        // Return a response
        return response()->json([
            'message' => 'Form submitted successfully!',
            'data' => $heading,
        ], 201);
    }

    // Update heading by email
    public function update(Request $request, $email)
    {
        $heading = Heading::where('email', $email)->first();
        if ($heading) {
            $request->validate([
                'firstName' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'profession' => 'required|string|max:255',
                'city' => 'required|string|max:255',
                'postalCode' => 'required|string|max:255',
                'country' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'email' => 'required|email',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif',
            ]);

            $heading->update($request->all());
            return response()->json(['message' => 'Data updated successfully', 'data' => $heading]);
        }
        return response()->json(['message' => 'Data not found'], 404);
    }
}
