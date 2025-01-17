<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the projects.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projects = Project::all();
        return response()->json($projects);
    }

    /**
     * Store multiple projects in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'projects' => 'required|array', // Ensures `projects` is an array
            'projects.*.name' => 'required|string|max:255',
            'projects.*.overview' => 'nullable|string',
            'projects.*.feature' => 'nullable|string',
            'projects.*.technology_used' => 'nullable|string',
            'projects.*.credential_mail_or_user_name' => 'nullable|string|max:255',
            'projects.*.password' => 'nullable|string|max:255',
            'projects.*.live_link' => 'nullable|string|max:255',
            'projects.*.client_side' => 'nullable|string|max:255',
            'projects.*.server_side' => 'nullable|string|max:255',
            'projects.*.user_email' => 'nullable|email|max:255', // Validation for user_email
        ]);
    
        // Store or update multiple projects
        $projects = [];
        foreach ($request->projects as $projectData) {
            // Check if the project already exists
            $found = Project::where('name', $projectData['name'])
                            ->where('user_email', $projectData['user_email'])
                            ->first();
    
            if ($found) {
                // Update the existing project
                $found->update($projectData);
                $projects[] = $found;
            } else {
                // Create a new project
                $projects[] = Project::create($projectData);
            }
        }
    
        // Return success response
        return response()->json(['message' => 'Projects created or updated successfully', 'projects' => $projects], 201);
    }
    


    public function getByEmail($email){
        $records = Project::where('user_email', $email)->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No records found'], 404);
        }

        return response()->json([
            'message' => 'Records retrieved successfully',
            'data' => $records
        ], 200);
    }

    /**
     * Display the specified project.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return response()->json($project);
    }

    /**
     * Update the specified project in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'overview' => 'nullable|string',
            'feature' => 'nullable|string',
            'technology_used' => 'nullable|string',
            'credential_mail_or_user_name' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'live_link' => 'nullable|string|max:255',
            'client_side' => 'nullable|string|max:255',
            'server_side' => 'nullable|string|max:255',
            'user_email' => 'nullable|email|max:255', // Validation for user_email
        ]);

        // Update the project
        $project->update($request->all());

        // Return success response
        return response()->json(['message' => 'Project updated successfully', 'project' => $project]);
    }

    /**
     * Remove the specified project from storage.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        // Delete the project
        $project->delete();

        // Return success response
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
