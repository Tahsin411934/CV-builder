<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objective;
use App\Models\Test;
use App\Models\Education;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\LanguageProficiency;
use App\Models\Project;
use App\Models\SelectedTemplate;
use App\Models\Instruction;
use Illuminate\Support\Facades\Auth;
class SummaryController extends Controller
{
    public function getAllSummaries($email)
    {
       
        // Fetch all data in one go and handle missing values gracefully
        $data = [
            'tamplete' =>           SelectedTemplate::where('user_email', $email)->with('cvTemplate')->first() ?? null,
            'instruction'             => Instruction::where('user_email', $email)->first() ?? null,
            'heading'             => Test::where('email', $email)->first() ?? null,
            'objective'           => Objective::where('user_email', $email)->first() ?? null,
            'skills'              => Skill::where('user_email', $email)->first() ?? null,
            'experience'          => Experience::where('user_email', $email)->get() ?? [],
            'education'           => Education::where('user_mail', $email)->get() ?? [],
            'languageProficiency' => LanguageProficiency::where('user_email', $email)->get() ?? [],
            'projects' => Project::where('user_email', $email)->get() ?? [],
        ];
    
        // Return a JSON response with grouped data
        return response()->json([
            'message' => 'Records retrieved successfully',
            'data'    => $data,
        ], 200);
    }
    

}
