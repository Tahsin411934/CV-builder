<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instruction;
use Illuminate\Support\Facades\Storage;

class InstructionController extends Controller
{
    /**
     * Store or update instruction.
     */
    public function store(Request $request)
    {
        // Validate input data
        $validatedData = $request->validate([
            'instruction' => 'required|string|max:1000',
            'user_email' => 'required|email',
            'pdf_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240', // Max 10MB PDF
        ]);
    
        // Find existing record by user email
        $instruction = Instruction::where('user_email', $validatedData['user_email'])->first();
    
        // Handle PDF upload
        if ($request->hasFile('pdf_file')) {
            $pdfFile = $request->file('pdf_file');
            $filePath = $pdfFile->store('instructions', 'public'); // Store file in storage/app/public/instructions
    
            // Save only the file path in the database
            $validatedData['pdf_file'] = $filePath;
        }
    
        if ($instruction) {
            // Update existing record
            $instruction->update($validatedData);
        } else {
            // Create a new record
            $instruction = Instruction::create($validatedData);
        }
    
        return response()->json([
            'message' => 'Instruction saved successfully',
            'data' => $instruction
        ], 201);
    }
    
    /**
     * Retrieve instruction by email.
     */
    public function getByEmail($email)
{
    $record = Instruction::where('user_email', $email)->first();

    if (!$record) {
        return response()->json(['message' => 'No records found'], 404);
    }

    // Generate the full URL for the PDF file
    $record->pdf_file_url = $record->pdf_file ? asset('storage/' . $record->pdf_file) : null;

    return response()->json([
        'message' => 'Record retrieved successfully',
        'data' => [
            'id' => $record->id,
            'instruction' => $record->instruction,
            'user_email' => $record->user_email,
            'pdf_file_url' => $record->pdf_file_url,
        ],
    ], 200);
}
    

    /**
     * Download the PDF file.
     */
    public function downloadPdf($id)
    {
        $instruction = Instruction::find($id);
    
        if (!$instruction || !$instruction->pdf_file) {
            return response()->json(['message' => 'PDF not found'], 404);
        }
    
        $filePath = storage_path('app/public/' . $instruction->pdf_file);
    
        if (!file_exists($filePath)) {
            return response()->json(['message' => 'File does not exist'], 404);
        }
    
        return response()->download($filePath, 'instructions.pdf');
    }
    
    /**
     * Delete instruction by ID.
     */
    public function destroy($id)
    {
        $instruction = Instruction::find($id);

        if (!$instruction) {
            return response()->json(['message' => 'Instruction not found'], 404);
        }

        $instruction->delete();

        return response()->json(['message' => 'Instruction deleted successfully'], 200);
    }
}
