<?php

namespace App\Http\Controllers;

use App\Models\CvTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CvTemplateController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $cvTemplates = CvTemplate::all();
        return response()->json($cvTemplates);
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    { 
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('public/images'); // Store in storage/app/public/images
            $imageUrl = Storage::url($imagePath); // Generate URL for the stored image
        } else {
            return response()->json(['error' => 'Image is required'], 400);
        }

        // Create the CV template
        $cvTemplate = CvTemplate::create([
            'image' => $imageUrl, // Save the image URL
            'title' => $request->title,
            'description' => $request->description,
        ]);

        return response()->json($cvTemplate, 201);
    }

    // Display the specified resource
    public function show($id)
    {
        $cvTemplate = CvTemplate::findOrFail($id);
        return response()->json($cvTemplate);
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $cvTemplate = CvTemplate::findOrFail($id);
    
        // Log the request payload for debugging
        \Log::info('Request Payload:', $request->all());
        \Log::info('Has File Image:', [$request->hasFile('image')]);
    
        $request->validate([
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($cvTemplate->image) {
                $oldImagePath = str_replace('/storage', 'public', $cvTemplate->image);
                Storage::delete($oldImagePath);
            }
    
            // Store the new image
            $imagePath = $request->file('image')->store('public/images');
            $imageUrl = Storage::url($imagePath);
            $cvTemplate->image = $imageUrl;
        }
    
        // Update title and description if provided
        if ($request->has('title')) {
            $cvTemplate->title = $request->title;
        }
        if ($request->has('description')) {
            $cvTemplate->description = $request->description;
        }
    
        $cvTemplate->save();
    
        return response()->json($cvTemplate);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $cvTemplate = CvTemplate::findOrFail($id);

        // Delete the associated image file
        if ($cvTemplate->image) {
            $imagePath = str_replace('/storage', 'public', $cvTemplate->image);
            Storage::delete($imagePath);
        }

        $cvTemplate->delete();

        return response()->json(['message' => 'CvTemplate deleted successfully']);
    }
}