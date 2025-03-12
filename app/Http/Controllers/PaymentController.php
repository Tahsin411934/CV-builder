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
    public function show($id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }
        return response()->json($payment);
    }

    // Update a payment
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);
        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $request->validate([
            'user_email' => 'email',
            'method' => 'in:Bkash,Nagad,Rocket,Card,Bank Transfer',
            'transaction_number' => 'unique:payments,transaction_number,' . $id,
            'upload_ss' => 'string',
        ]);

        $payment->update($request->all());

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
