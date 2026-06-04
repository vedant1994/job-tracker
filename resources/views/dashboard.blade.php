<x-app-layout>
    <div class="mb-8">
        <h1 class="font-display text-3xl font-700 text-gray-900">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ auth()->user()->name }} 👋</h1>
        <p class="text-gray-400 mt-1">Here's your job search overview</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-10">
        @foreach([
            ['label'=>'Total','key'=>'total','icon'=>'ti-list','color'=>'#6c63ff','bg'=>'#ede9ff'],
            ['label'=>'Applied','key'=>'applied','icon'=>'ti-send','color'=>'#3b82f6','bg'=>'#eff6ff'],
            ['label'=>'Interview','key'=>'interview','icon'=>'ti-users','color'=>'#f59e0b','bg'=>'#fffbeb'],
            ['label'=>'Offer','key'=>'offer','icon'=>'ti-trophy','color'=>'#10b981','bg'=>'#ecfdf5'],
            ['label'=>'Rejected','key'=>'rejected','icon'=>'ti-x','color'=>'#ef4444','bg'=>'#fef2f2'],
        ] as $s)
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center mb-3" style="background:{{ $s['bg'] }}">
                <i class="ti {{ $s['icon'] }} text-lg" style="color:{{ $s['color'] }}"></i>
            </div>
            <div class="text-2xl font-display font-700" style="color:{{ $s['color'] }}">{{ $stats[$s['key']] }}</div>
            <div class="text-xs text-gray-400 mt-1">{{ $s['label'] }}</div>
        </div>
        @endforeach
    </div>

    {{-- Recent Jobs --}}
    <div class="flex items-center justify-between mb-4">
        <h2 class="font-display text-lg font-600">Recent Applications</h2>
        <a href="{{ route('jobs.create') }}" class="flex items-center gap-2 text-sm px-4 py-2 rounded-xl text-white font-500 transition hover:opacity-90" style="background:var(--accent)">
            <i class="ti ti-plus"></i> Add Job
        </a>
    </div>

    @if($recentJobs->isEmpty())
        <div class="bg-white rounded-2xl border border-dashed border-gray-200 p-12 text-center">
            <i class="ti ti-briefcase text-4xl text-gray-300"></i>
            <p class="text-gray-400 mt-3">No applications yet. Add your first job!</p>
            <a href="{{ route('jobs.create') }}" class="inline-block mt-4 px-6 py-2 rounded-xl text-white text-sm" style="background:var(--accent)">Add Job</a>
        </div>
    @else
        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
            @foreach($recentJobs as $job)
            <a href="{{ route('jobs.show', $job) }}" class="flex items-center justify-between px-6 py-4 border-b border-gray-50 hover:bg-gray-50 transition last:border-0">
                <div>
                    <div class="font-500 text-gray-900">{{ $job->job_title }}</div>
                    <div class="text-sm text-gray-400">{{ $job->company_name }}</div>
                </div>
                @php
                    $colors = ['saved'=>'#6c63ff','applied'=>'#3b82f6','interview'=>'#f59e0b','offer'=>'#10b981','rejected'=>'#ef4444'];
                    $bgs = ['saved'=>'#ede9ff','applied'=>'#eff6ff','interview'=>'#fffbeb','offer'=>'#ecfdf5','rejected'=>'#fef2f2'];
                @endphp
                <span class="text-xs font-500 px-3 py-1 rounded-full" style="color:{{ $colors[$job->status] }};background:{{ $bgs[$job->status] }}">
                    {{ ucfirst($job->status) }}
                </span>
            </a>
            @endforeach
        </div>
        <div class="mt-4 text-center">
            <a href="{{ route('jobs.index') }}" class="text-sm" style="color:var(--accent)">View all applications →</a>
        </div>
    @endif
</x-app-layout>