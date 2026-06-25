<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventor+ Dashboard</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600;700;800&family=Nunito:wght@700;800&display=swap"
        rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-[#F8FAFC] text-gray-900 font-['Lexend',sans-serif] antialiased">

    <div class="flex h-screen w-full overflow-hidden">

        @include('layouts.sidebar')

        <div class="flex-1 flex flex-col h-full overflow-hidden bg-[#F8FAFC]">

            @include('layouts.header')

            <main class="flex-1 overflow-y-auto p-8">
                @yield('content')
            </main>
        </div>
    </div>

</body>

</html>
