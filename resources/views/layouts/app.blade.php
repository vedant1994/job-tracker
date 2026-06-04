<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} - Job Tracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/tabler-icons.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'DM Sans', sans-serif; }
        .font-display { font-family: 'Syne', sans-serif; }
        :root {
            --accent: #6c63ff;
            --accent-light: #ede9ff;
            --accent-dark: #4b44cc;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-900">

<nav class="bg-white border-b border-gray-100 sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 flex items-center justify-between h-16">
        <a href="{{ route('dashboard') }}" class="font-display font-700 text-xl tracking-tight flex items-center gap-2">
            <span style="color:var(--accent)"><i class="ti ti-briefcase"></i></span>
            JobTrackr
        </a>
        <div class="flex items-center gap-6">
            <a href="{{ route('dashboard') }}" class="text-sm text-gray-500 hover:text-gray-900 transition {{ request()->routeIs('dashboard') ? 'text-gray-900 font-500' : '' }}">Dashboard</a>
            <a href="{{ route('jobs.index') }}" class="text-sm text-gray-500 hover:text-gray-900 transition {{ request()->routeIs('jobs.*') ? 'text-gray-900 font-500' : '' }}">My Jobs</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-sm text-gray-400 hover:text-red-500 transition">Logout</button>
            </form>
        </div>
    </div>
</nav>

<main class="max-w-6xl mx-auto px-4 py-8">
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-50 border border-green-200 text-green-700 rounded-xl text-sm flex items-center gap-2">
            <i class="ti ti-circle-check"></i> {{ session('success') }}
        </div>
    @endif
    {{ $slot }}
</main>

</body>
</html>