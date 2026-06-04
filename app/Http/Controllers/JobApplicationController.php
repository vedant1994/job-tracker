<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    public function index()
    {
        $jobs = JobApplication::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
        return view('jobs.index', compact('jobs'));
    }

    public function create()
    {
        return view('jobs.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name'    => 'required|string|max:255',
            'job_title'       => 'required|string|max:255',
            'job_url'         => 'nullable|url',
            'job_description' => 'nullable|string',
            'status'          => 'required|in:saved,applied,interview,offer,rejected',
            'applied_date'    => 'nullable|date',
            'deadline'        => 'nullable|date',
            'salary_range'    => 'nullable|string|max:100',
            'notes'           => 'nullable|string',
        ]);

        $validated['user_id'] = auth()->id();
        JobApplication::create($validated);

        return redirect()->route('jobs.index')->with('success', 'Job added successfully!');
    }

    public function show(JobApplication $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);
        $aiGenerations = $job->aiGenerations()->latest()->get();
        return view('jobs.show', compact('job', 'aiGenerations'));
    }

    public function edit(JobApplication $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);
        return view('jobs.edit', compact('job'));
    }

    public function update(Request $request, JobApplication $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);

        $validated = $request->validate([
            'company_name'    => 'required|string|max:255',
            'job_title'       => 'required|string|max:255',
            'job_url'         => 'nullable|url',
            'job_description' => 'nullable|string',
            'status'          => 'required|in:saved,applied,interview,offer,rejected',
            'applied_date'    => 'nullable|date',
            'deadline'        => 'nullable|date',
            'salary_range'    => 'nullable|string|max:100',
            'notes'           => 'nullable|string',
        ]);

        $job->update($validated);
        return redirect()->route('jobs.show', $job)->with('success', 'Job updated!');
    }

    public function destroy(JobApplication $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);
        $job->delete();
        return redirect()->route('jobs.index')->with('success', 'Job deleted.');
    }

    public function updateStatus(Request $request, JobApplication $job)
    {
        abort_if($job->user_id !== auth()->id(), 403);
        $request->validate(['status' => 'required|in:saved,applied,interview,offer,rejected']);
        $job->update(['status' => $request->status]);
        return back()->with('success', 'Status updated!');
    }
}