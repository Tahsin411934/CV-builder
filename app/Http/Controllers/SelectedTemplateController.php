<?php

namespace App\Http\Controllers;
use App\Models\SelectedTemplate;
use Illuminate\Http\Request;

class SelectedTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tamplate_id' => 'required|string',
            'user_email' => 'required|email'
        ]);
    
        // Check if a record exists for the given user_email
        $template = SelectedTemplate::where('user_email', $request->user_email)->first();
    
        if ($template) {
            // If found, update the record
            $template->update(['tamplate_id' => $request->tamplate_id]);
            return response()->json(['message' => 'Updated successfully', 'data' => $template], 200);
        } else {
            // If not found, create a new record
            $newTemplate = SelectedTemplate::create($request->all());
            return response()->json(['message' => 'Created successfully', 'data' => $newTemplate], 201);
        }
    }
    public function findByEmail($email)
    {
        $template = SelectedTemplate::where('user_email', $email)->first();
    
        if (!$template) {
            return response()->json(['message' => 'Template not found'], 404);
        }
    
        return response()->json($template, 200);
    }
        

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
