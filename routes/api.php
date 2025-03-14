<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HeadingController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\ObjectiveController;
use App\Http\Controllers\InstructionController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\LanguageProficiencyController;
use App\Http\Controllers\SummaryController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CvTemplateController;
use App\Http\Controllers\Test1Controller;
use App\Http\Controllers\PremiumCvController;
use App\Http\Controllers\PaymentController;

Route::apiResource('payments', PaymentController::class);

Route::post('/register', [AuthController::class, 'registration']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/user/{email}', [AuthController::class, 'getByUserMail']);
Route::post('/user/update', [UserController::class, 'updateUserProfile']);
Route::post('/user/change-password', [UserController::class, 'changePassword']);
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


Route::get('/instructions/{id}/download-pdf', [InstructionController::class, 'downloadPdf'])->name('instruction.downloadPdf');
Route::resource('experiences', ExperienceController::class);
Route::get('/experience/{email}', [ExperienceController::class, 'getByEmail']);

Route::resource('objectives', ObjectiveController::class);
Route::get('/objective/{email}', [ObjectiveController::class, 'getByEmail']);


Route::resource('instructions', InstructionController::class);
Route::get('/instruction/{email}', [InstructionController::class, 'getByEmail']);

Route::post('skills', [SkillController::class, 'store']);
Route::get('/skills/{email}', [SkillController::class, 'getByEmail']);

Route::resource('language-proficiency', LanguageProficiencyController::class);
Route::get('/language-proficiencybyemail/{email}', [LanguageProficiencyController::class, 'getByEmail']);
 Route::get('/summary/{email}', [SummaryController::class, 'getAllSummaries']);

 Route::resource('projects', ProjectController::class);
 Route::get('/project/{email}', [ProjectController::class, 'getByEmail']);



Route::apiResource('cv-templates', CvTemplateController::class);
Route::put('/update/{id}', [CvTemplateController::class, 'update']);
// routes/api.php


Route::apiResource('premium-cvs', PremiumCvController::class);

Route::apiResource('tests', TestController::class);
