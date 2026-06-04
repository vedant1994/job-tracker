<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\JobApplicationController;
use App\Http\Controllers\AiGenerationController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    Route::resource('jobs', JobApplicationController::class);
    Route::Patch('jobs/{job}/status', [JobApplicationController::class, 'updateStatus'])->name('jobs.status');

    Route::post('jobs/{job}/ai/cover-letter', [AiGenerationController::class, 'coverLetter'])->name('ai.cover-letter');
    Route::post('jobs/{job}/ai/interview-questions', [AiGenerationController::class, 'interviewQuestions'])->name('ai.interview-questions');
    Route::post('jobs/{job}/ai/resume-score', [AiGenerationController::class, 'resumeScore'])->name('ai.resume-score');
});

Route::get('/test-ai', function () {
    $apiKey = config('services.openai.key');
    
    $response = \Illuminate\Support\Facades\Http::withHeaders([
        'Authorization' => 'Bearer ' . $apiKey,
        'Content-Type' => 'application/json',
    ])->post('https://api.openai.com/v1/chat/completions', [
        'model' => 'gpt-3.5-turbo',
        'messages' => [['role' => 'user', 'content' => 'Say hello']],
        'max_tokens' => 100,
    ]);
    
    dd([
        'api_key_loaded' => $apiKey ? 'YES - ' . substr($apiKey, 0, 10) . '...' : 'NO - KEY IS EMPTY',
        'status' => $response->status(),
        'response' => $response->json(),
    ]);
});

require __DIR__.'/auth.php';
