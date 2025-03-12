<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\PremiumCv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PremiumCvController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $premiumCvs = PremiumCv::all();
        return response()->json(['data' => $premiumCvs], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'user_email' => 'nullable|email',
            'selected_template_id' => 'nullable|integer',
            'file_path' => 'nullable|string',
            'payment_amount' => 'nullable|numeric',
            'instruction' => 'nullable|string',
            'additional_info' => 'nullable|string',
            'screenshot_upload' => 'nullable|string',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        // Create the record
        $premiumCv = PremiumCv::create($request->all());

        return response()->json(['message' => 'Premium CV created successfully', 'data' => $premiumCv], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $premiumCv = PremiumCv::find($id);

        // If record not found, return error response
        if (!$premiumCv) {
            return response()->json(['message' => 'Premium CV not found'], 404);
        }

        return response()->json(['data' => $premiumCv], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $premiumCv = PremiumCv::find($id);

        // If record not found, return error response
        if (!$premiumCv) {
            return response()->json(['message' => 'Premium CV not found'], 404);
        }

        // Validate the request
        $validator = Validator::make($request->all(), [
            'user_email' => 'nullable|email',
            'selected_template_id' => 'nullable|integer',
            'file_path' => 'nullable|string',
            'payment_amount' => 'nullable|numeric',
            'instruction' => 'nullable|string',
            'additional_info' => 'nullable|string',
            'screenshot_upload' => 'nullable|string',
        ]);

        // If validation fails, return error response
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        // Update the record
        $premiumCv->update($request->all());

        return response()->json(['message' => 'Premium CV updated successfully', 'data' => $premiumCv], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $premiumCv = PremiumCv::find($id);

        // If record not found, return error response
        if (!$premiumCv) {
            return response()->json(['message' => 'Premium CV not found'], 404);
        }

        // Delete the record
        $premiumCv->delete();

        return response()->json(['message' => 'Premium CV deleted successfully'], 200);
    }
}