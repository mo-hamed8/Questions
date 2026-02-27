<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Home • English Grammar App</title>

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
        }

        .card-hover {
            transition: all 0.25s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body class="min-h-screen flex flex-col items-center justify-center antialiased">

    <main class="w-full max-w-4xl px-6 py-12">

        <!-- Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">English Grammar App</h1>
            <p class="text-gray-500">Your gateway to interactive English grammar worksheets</p>
        </div>

        <!-- Links Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

            <a href="{{ route("questions.index") }}"
               class="card-hover block p-6 bg-white rounded-xl shadow hover:bg-blue-50 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">All Questions</h2>
                <p class="text-gray-500 text-sm">Browse and manage all existing questions.</p>
            </a>

            <a href="{{ route("questions.create") }}"
               class="card-hover block p-6 bg-white rounded-xl shadow hover:bg-green-50 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Create Question</h2>
                <p class="text-gray-500 text-sm">Add a new question to your question bank.</p>
            </a>

            <a href="{{ route("selectFilters") }}"
               class="card-hover block p-6 bg-white rounded-xl shadow hover:bg-indigo-50 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Select Filters</h2>
                <p class="text-gray-500 text-sm">Choose categories to generate a worksheet.</p>
            </a>
            <a href="{{ route("wrongQuestionsToday") }}"
               class="card-hover block p-6 bg-white rounded-xl shadow hover:bg-indigo-50 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">wrong Questions Today</h2>
                <p class="text-gray-500 text-sm">Choose categories to generate a worksheet.</p>
            </a>

        </div>

    </main>

</body>

</html>
