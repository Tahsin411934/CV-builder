<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HeadingController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\LanguageProficiencyController;
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

Route::prefix('educations')->group(function () {
  Route::post('/store', [EducationController::class, 'store']); // Store multiple records
  Route::get('/user/{user_mail}', [EducationController::class, 'getByUserMail']); // Get records by user_mail
  Route::put('/update/{id}', [EducationController::class, 'update']); // Update a record
  Route::delete('/delete/{id}', [EducationController::class, 'destroy']); // Delete a record
});



Route::resource('experiences', ExperienceController::class);
Route::get('/experience/{email}', [ExperienceController::class, 'getByEmail']);

Route::resource('objectives', ObjectiveController::class);
Route::get('/objective/{email}', [ObjectiveController::class, 'getByEmail']);

Route::post('skills', [SkillController::class, 'store']);
Route::get('/skills/{email}', [SkillController::class, 'getByEmail']);

Route::resource('language-proficiency', LanguageProficiencyController::class);
Route::get('/language-proficiencybyemail/{email}', [LanguageProficiencyController::class, 'getByEmail']);
