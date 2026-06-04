<?php

namespace App\Http\Controllers;

use App\Models\AiGeneration;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiGenerationController extends Controller
{
    private function callAI(string $prompt): string
    {
    $apiKey = config('services.gemini.key');

    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'X-goog-api-key' => $apiKey,
    ])->post(
        "https://generativelanguage.googleapis.com/v1beta/models/gemini-flash-latest:generateContent",
        ['contents' => [['parts' => [['text' => $prompt]]]]]
    );

    return $response->json('candidates.0.content.parts.0.text') ?? 'No response from AI.';
    }   

    public function coverLetter(Request $request, JobApplication $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);

        $prompt = "Write a professional cover letter for this job:\nCompany: {$job->company_name}\nRole: {$job->job_title}\nJob Description: {$job->job_description}\n\nMake it enthusiastic, concise (3 paragraphs), and professional.";

        $result = $this->callAI($prompt);

        AiGeneration::create([
            'user_id'            => auth()->id(),
            'job_application_id' => $job->id,
            'type'               => 'cover_letter',
            'result'             => $result,
        ]);

        return back()->with('ai_result', $result)->with('ai_type', 'Cover Letter');
    }

    public function interviewQuestions(Request $request, JobApplication $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);

        $prompt = "Generate 7 likely interview questions for this role:\nCompany: {$job->company_name}\nRole: {$job->job_title}\nJob Description: {$job->job_description}\n\nFor each question, add a brief tip on how to answer it well.";

        $result = $this->callAI($prompt);

        AiGeneration::create([
            'user_id'            => auth()->id(),
            'job_application_id' => $job->id,
            'type'               => 'interview_questions',
            'result'             => $result,
        ]);

        return back()->with('ai_result', $result)->with('ai_type', 'Interview Questions');
    }

    public function resumeScore(Request $request, JobApplication $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);

        $request->validate(['resume_text' => 'required|string']);

        $prompt = "You are a hiring manager. Score this resume against the job description.\n\nJob Title: {$job->job_title}\nJob Description: {$job->job_description}\n\nResume:\n{$request->resume_text}\n\nGive:\n1. A match score out of 100\n2. Top 3 strengths\n3. Top 3 gaps/improvements\n4. One-line verdict";

        $result = $this->callAI($prompt);

        AiGeneration::create([
            'user_id'            => auth()->id(),
            'job_application_id' => $job->id,
            'type'               => 'resume_score',
            'result'             => $result,
        ]);

        return back()->with('ai_result', $result)->with('ai_type', 'Resume Score');
    }
}