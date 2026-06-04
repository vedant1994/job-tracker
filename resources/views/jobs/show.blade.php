<x-app-layout>
    @php
        $colors = ['saved'=>'#6c63ff','applied'=>'#3b82f6','interview'=>'#f59e0b','offer'=>'#10b981','rejected'=>'#ef4444'];
        $bgs = ['saved'=>'#ede9ff','applied'=>'#eff6ff','interview'=>'#fffbeb','offer'=>'#ecfdf5','rejected'=>'#fef2f2'];
    @endphp

    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('jobs.index') }}" class="text-sm text-gray-400 hover:text-gray-600"><i class="ti ti-arrow-left"></i> Back to jobs</a>
        <div class="flex gap-2">
            <a href="{{ route('jobs.edit', $job) }}" class="text-sm px-4 py-2 rounded-xl border border-gray-200 hover:border-gray-400 transition text-gray-500"><i class="ti ti-edit"></i> Edit</a>
            <form method="POST" action="{{ route('jobs.destroy', $job) }}" onsubmit="return confirm('Delete this job?')">
                @csrf @method('DELETE')
                <button class="text-sm px-4 py-2 rounded-xl border border-red-100 text-red-400 hover:border-red-300 transition"><i class="ti ti-trash"></i> Delete</button>
            </form>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">

        {{-- Left: Job Info --}}
        <div class="col-span-2 space-y-6">
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl flex items-center justify-center font-display font-700 text-2xl" style="background:{{ $bgs[$job->status] }};color:{{ $colors[$job->status] }}">
                            {{ strtoupper(substr($job->company_name,0,1)) }}
                        </div>
                        <div>
                            <h1 class="font-display text-2xl font-700">{{ $job->job_title }}</h1>
                            <p class="text-gray-400">{{ $job->company_name }}</p>
                        </div>
                    </div>
                    <span class="text-sm font-500 px-4 py-1.5 rounded-full" style="color:{{ $colors[$job->status] }};background:{{ $bgs[$job->status] }}">{{ ucfirst($job->status) }}</span>
                </div>

                <div class="grid grid-cols-3 gap-4 mt-4 pt-4 border-t border-gray-50">
                    @if($job->applied_date)
                    <div><p class="text-xs text-gray-400">Applied</p><p class="text-sm font-500 mt-0.5">{{ $job->applied_date->format('d M Y') }}</p></div>
                    @endif
                    @if($job->deadline)
                    <div><p class="text-xs text-gray-400">Deadline</p><p class="text-sm font-500 mt-0.5 {{ $job->deadline->isPast() ? 'text-red-500' : '' }}">{{ $job->deadline->format('d M Y') }}</p></div>
                    @endif
                    @if($job->salary_range)
                    <div><p class="text-xs text-gray-400">Salary</p><p class="text-sm font-500 mt-0.5 text-green-600">{{ $job->salary_range }}</p></div>
                    @endif
                    @if($job->job_url)
                    <div><p class="text-xs text-gray-400">Link</p><a href="{{ $job->job_url }}" target="_blank" class="text-sm text-indigo-500 hover:underline mt-0.5 block truncate">View Job ↗</a></div>
                    @endif
                </div>

                @if($job->notes)
                <div class="mt-4 pt-4 border-t border-gray-50">
                    <p class="text-xs text-gray-400 mb-1">Notes</p>
                    <p class="text-sm text-gray-600">{{ $job->notes }}</p>
                </div>
                @endif
            </div>

            {{-- AI Result --}}
            @if(session('ai_result'))
            <div class="bg-white rounded-2xl border border-indigo-100 p-6" id="ai-result">
                <div class="flex items-center gap-2 mb-4">
                    <span class="text-sm font-500 px-3 py-1 rounded-full" style="background:#ede9ff;color:#4b44cc"><i class="ti ti-wand"></i> {{ session('ai_type') }}</span>
                </div>
                <div class="text-sm text-gray-700 leading-relaxed whitespace-pre-line">{{ session('ai_result') }}</div>
            </div>
            @endif

            {{-- Past AI generations --}}
            @if($aiGenerations->count())
            <div class="bg-white rounded-2xl border border-gray-100 p-6">
                <h3 class="font-display font-600 text-lg mb-4">Past AI Generations</h3>
                <div class="space-y-4">
                    @foreach($aiGenerations as $gen)
                    <details class="border border-gray-100 rounded-xl">
                        <summary class="px-4 py-3 cursor-pointer text-sm font-500 flex items-center justify-between">
                            <span><i class="ti ti-robot text-indigo-400"></i> {{ ucwords(str_replace('_',' ',$gen->type)) }}</span>
                            <span class="text-xs text-gray-400">{{ $gen->created_at->diffForHumans() }}</span>
                        </summary>
                        <div class="px-4 pb-4 text-sm text-gray-600 whitespace-pre-line leading-relaxed border-t border-gray-50 pt-3">{{ $gen->result }}</div>
                    </details>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        {{-- Right: AI Actions --}}
        <div class="space-y-4">
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="font-display font-600 mb-4 flex items-center gap-2"><i class="ti ti-robot text-indigo-400"></i> AI Tools</h3>

                <form method="POST" action="{{ route('ai.cover-letter', $job) }}" class="mb-3">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 rounded-xl border border-gray-100 hover:border-indigo-200 hover:bg-indigo-50 transition text-sm">
                        <div class="font-500 text-gray-800"><i class="ti ti-file-text text-indigo-400"></i> Generate Cover Letter</div>
                        <div class="text-xs text-gray-400 mt-0.5">AI writes a tailored cover letter</div>
                    </button>
                </form>

                <form method="POST" action="{{ route('ai.interview-questions', $job) }}" class="mb-3">
                    @csrf
                    <button type="submit" class="w-full text-left px-4 py-3 rounded-xl border border-gray-100 hover:border-amber-200 hover:bg-amber-50 transition text-sm">
                        <div class="font-500 text-gray-800"><i class="ti ti-messages text-amber-400"></i> Interview Questions</div>
                        <div class="text-xs text-gray-400 mt-0.5">7 likely questions + how to answer</div>
                    </button>
                </form>

                <details class="border border-gray-100 rounded-xl">
                    <summary class="px-4 py-3 cursor-pointer text-sm">
                        <div class="font-500 text-gray-800"><i class="ti ti-file-check text-green-400"></i> Score My Resume</div>
                        <div class="text-xs text-gray-400 mt-0.5">Paste resume → get match %</div>
                    </summary>
                    <form method="POST" action="{{ route('ai.resume-score', $job) }}" class="p-3 border-t border-gray-50">
                        @csrf
                        <textarea name="resume_text" rows="6" placeholder="Paste your resume text here..." class="w-full border border-gray-200 rounded-xl px-3 py-2 text-xs focus:outline-none focus:border-indigo-400 transition resize-none mb-2"></textarea>
                        <button type="submit" class="w-full py-2 rounded-xl text-white text-sm font-500 hover:opacity-90 transition" style="background:var(--accent)">Score It</button>
                    </form>
                </details>
            </div>

            {{-- Update Status --}}
            <div class="bg-white rounded-2xl border border-gray-100 p-5">
                <h3 class="font-display font-600 mb-3 text-sm">Update Status</h3>
                <form method="POST" action="{{ route('jobs.status', $job) }}">
                    @csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="w-full border border-gray-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:border-indigo-400 transition">
                        @foreach(['saved','applied','interview','offer','rejected'] as $s)
                            <option value="{{ $s }}" {{ $job->status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>