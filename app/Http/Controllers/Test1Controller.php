<?php
// app/Http/Controllers/TestController.php
namespace App\Http\Controllers;

use App\Models\Test1;
use Illuminate\Http\Request;

class Test1Controller extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $tests = Test1::all();
        return response()->json($tests);
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('test.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handling the image upload
        $imagePath = $request->file('image')->store('images', 'public');

        $test = Test1::create([
            'image' => $imagePath,
        ]);

        return response()->json($test, 201);
    }

    // Display the specified resource
    public function show($id)
    {
        $test = Test1::findOrFail($id);
        return response()->json($test);
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $test = Test1::findOrFail($id);
        return view('test.edit', compact('test'));
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {dd($request->hasFile('image'));
        $request->validate([
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $test = Test1::findOrFail($id);

        if ($request->hasFile('image')) {
            // Handle image upload if a new image is uploaded
            $imagePath = $request->file('image')->store('images', 'public');
            $test->image = $imagePath;
        }

        $test->save();
        return response()->json($test);
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $test = Test1::findOrFail($id);
        $test->delete();
        return response()->json(['message' => 'Test deleted successfully']);
    }
}
