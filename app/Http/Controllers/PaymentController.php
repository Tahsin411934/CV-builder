<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Get all payments
    public function index()
    {
        return response()->json(Payment::all());
    }

    // Store a new payment
    public function store(Request $request)
    {
        $request->validate([
            'user_email' => 'required|email',
            'method' => 'required',
            'transaction_number' => 'required|unique:payments',
            'upload_ss' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Add file validation
        ]);
    
        // Handle file upload
        if ($request->hasFile('upload_ss')) {
            $file = $request->file('upload_ss');
            $path = $file->store('uploads', 'public'); 
    
            // Create the payment record with the file path
            $payment = Payment::create([
                'user_email' => $request->user_email,
                'method' => $request->method,
                'transaction_number' => $request->transaction_number,
                'upload_ss' => $path, // Save the file path in the database
            ]);
    
            return response()->json($payment, 201);
        }
    }

 // Show a single payment
 public function show($email)
 {
     // Fetch the last payment record for the given email
     $payment = Payment::where('user_email', $email)
                       ->orderBy('created_at', 'desc') // Order by creation date in descending order
                       ->first();
 
     // Check if the payment exists
     if (!$payment) {
         return response()->json(['message' => 'Payment not found or invalid verification status'], 404);
     }
 
     // Return the payment as a JSON response
     return response()->json($payment);
 }


 // Show a single payment
 public function getdataByMail($email)
 {
     // Fetch the last payment record for the given email
     $payment = Payment::where('user_email', $email)
                       ->orderBy('created_at', 'desc') // Order by creation date in descending order
                       ->get();
 
     // Check if the payment exists
     if (!$payment) {
         return response()->json(['message' => 'Payment not found or invalid verification status'], 404);
     }
 
     // Return the payment as a JSON response
     return response()->json($payment);
 }

    // Update a payment
    public function update(Request $request, $id)
    {
        // Find the payment
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }
    
        // Handle file upload if a file is present in the request
        if ($request->hasFile('updated_cv')) {
            $file = $request->file('updated_cv');
    
           
    
            // Validate the file
            $request->validate([
                'updated_cv' => 'file|mimes:pdf,doc,docx|max:2048', // Allow PDF, Word files, max 2MB
            ]);
    
            // Store the file in the public/uploads directory
            $fileName = time() . '_' . $file->getClientOriginalName(); // Generate a unique file name
            $filePath = $file->storeAs('uploads', $fileName, 'public'); // Save the file to the "public/uploads" directory
    
    
            // Update the payment with the new file path
            $payment->updated_cv = $filePath; // Directly update the `updated_cv` field
        }
    
        // Update other fields in the payment
        $payment->update($request->except('updated_cv')); // Exclude `updated_cv` from the request data
    
        return response()->json($payment);
    }

    // Delete a payment
    public function destroy($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $payment->delete();
        return response()->json(['message' => 'Payment deleted successfully']);
    }
}