<x-app-layout>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-display text-3xl font-700">My Applications</h1>
            <p class="text-gray-400 mt-1">Track every opportunity</p>
        </div>
        <a href="{{ route('jobs.create') }}" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-white font-500 text-sm hover:opacity-90 transition" style="background:var(--accent)">
            <i class="ti ti-plus"></i> Add Job
        </a>
    </div>

    @if($jobs->isEmpty())
        <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-16 text-center">
            <i class="ti ti-search text-5xl text-gray-200"></i>
            <p class="text-gray-400 mt-4">No jobs tracked yet.</p>
        </div>
    @else
        <div class="grid gap-4">
            @foreach($jobs as $job)
            @php
                $colors = ['saved'=>'#6c63ff','applied'=>'#3b82f6','interview'=>'#f59e0b','offer'=>'#10b981','rejected'=>'#ef4444'];
                $bgs = ['saved'=>'#ede9ff','applied'=>'#eff6ff','interview'=>'#fffbeb','offer'=>'#ecfdf5','rejected'=>'#fef2f2'];
            @endphp
            <div class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between hover:shadow-sm transition">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-display font-700 text-lg" style="background:{{ $bgs[$job->status] }};color:{{ $colors[$job->status] }}">
                        {{ strtoupper(substr($job->company_name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-500 text-gray-900">{{ $job->job_title }}</div>
                        <div class="text-sm text-gray-400">{{ $job->company_name }}
                            @if($job->salary_range) · <span class="text-green-500">{{ $job->salary_range }}</span>@endif
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @if($job->deadline)
                    <div class="text-xs text-gray-400 hidden md:block">
                        <i class="ti ti-calendar"></i> {{ $job->deadline->format('d M') }}
                    </div>
                    @endif
                    <span class="text-xs font-500 px-3 py-1 rounded-full" style="color:{{ $colors[$job->status] }};background:{{ $bgs[$job->status] }}">
                        {{ ucfirst($job->status) }}
                    </span>
                    <a href="{{ route('jobs.show', $job) }}" class="text-sm px-4 py-1.5 rounded-lg border border-gray-200 hover:border-gray-400 transition text-gray-500">View</a>
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $jobs->links() }}</div>
    @endif
</x-app-layout>