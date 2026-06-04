<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('jobs.show', $job) }}" class="text-sm text-gray-400 hover:text-gray-600"><i class="ti ti-arrow-left"></i> Back</a>
            <h1 class="font-display text-3xl font-700 mt-3">Edit Job</h1>
        </div>

        <form method="POST" action="{{ route('jobs.update', $job) }}" class="bg-white rounded-2xl border border-gray-100 p-8 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-500 text-gray-700 mb-1.5">Company Name *</label>
                    <input type="text" name="company_name" value="{{ old('company_name', $job->company_name) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-500 text-gray-700 mb-1.5">Job Title *</label>
                    <input type="text" name="job_title" value="{{ old('job_title', $job->job_title) }}" required class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-500 text-gray-700 mb-1.5">Job URL</label>
                <input type="url" name="job_url" value="{{ old('job_url', $job->job_url) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition">
            </div>

            <div>
                <label class="block text-sm font-500 text-gray-700 mb-1.5">Job Description</label>
                <textarea name="job_description" rows="5" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition resize-none">{{ old('job_description', $job->job_description) }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-6">
                <div>
                    <label class="block text-sm font-500 text-gray-700 mb-1.5">Status</label>
                    <select name="status" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition">
                        @foreach(['saved','applied','interview','offer','rejected'] as $s)
                            <option value="{{ $s }}" {{ $job->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-500 text-gray-700 mb-1.5">Applied Date</label>
                    <input type="date" name="applied_date" value="{{ old('applied_date', $job->applied_date?->format('Y-m-d')) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition">
                </div>
                <div>
                    <label class="block text-sm font-500 text-gray-700 mb-1.5">Deadline</label>
                    <input type="date" name="deadline" value="{{ old('deadline', $job->deadline?->format('Y-m-d')) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition">
                </div>
            </div>

            <div>
                <label class="block text-sm font-500 text-gray-700 mb-1.5">Salary Range</label>
                <input type="text" name="salary_range" value="{{ old('salary_range', $job->salary_range) }}" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition">
            </div>

            <div>
                <label class="block text-sm font-500 text-gray-700 mb-1.5">Notes</label>
                <textarea name="notes" rows="3" class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition resize-none">{{ old('notes', $job->notes) }}</textarea>
            </div>

            <div class="flex gap-3 pt-2">
                <button type="submit" class="px-6 py-2.5 rounded-xl text-white font-500 text-sm hover:opacity-90 transition" style="background:var(--accent)">Update Job</button>
                <a href="{{ route('jobs.show', $job) }}" class="px-6 py-2.5 rounded-xl border border-gray-200 text-gray-500 font-500 text-sm hover:border-gray-400 transition">Cancel</a>
            </div>
        </form>
    </div>
</x-app-layout>