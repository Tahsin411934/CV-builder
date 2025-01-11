<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HeadingController;
use App\Http\Controllers\TestController;
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/register', [AuthController::class, 'registration']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

  // Fetch by email
Route::post('/headings', [HeadingController::class, 'store']);        // Create new entry
Route::put('/headings/{email}', [HeadingController::class, 'update']); // Update existing entry



Route::post('/test', [TestController::class, 'store']);
Route::get('/headings/{email}', [TestController::class, 'findDataByEmail']);
