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

            <a href="{{ route('questions.index') }}"
                class="card-hover block p-6 bg-white rounded-xl shadow hover:bg-blue-50 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">All Questions</h2>
                <p class="text-gray-500 text-sm">Browse and manage all existing questions.</p>
            </a>

            <a href="{{ route('questions.create') }}"
                class="card-hover block p-6 bg-white rounded-xl shadow hover:bg-green-50 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Create Question</h2>
                <p class="text-gray-500 text-sm">Add a new question to your question bank.</p>
            </a>

            <a href="{{ route('selectFilters') }}"
                class="card-hover block p-6 bg-white rounded-xl shadow hover:bg-indigo-50 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">Select Filters</h2>
                <p class="text-gray-500 text-sm">Choose categories to generate a worksheet.</p>
            </a>
            <a href="{{ route('wrongQuestionsToday') }}"
                class="card-hover block p-6 bg-white rounded-xl shadow hover:bg-indigo-50 text-center">
                <h2 class="text-xl font-semibold text-gray-800 mb-2">wrong Questions Today</h2>
                <p class="text-gray-500 text-sm">Choose categories to generate a worksheet.</p>
            </a>

        </div>

<br>
<br>
<br>
        <div data-slot="card"
            class="bg-card text-card-foreground flex flex-col gap-6 rounded-xl border py-6 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm border-collapse">
                    <thead>
                        <tr class="bg-muted/50 border-b border-border">
                            <th class="text-left py-2.5 px-4 font-semibold text-foreground">Type</th>
                            <th class="text-left py-2.5 px-4 font-semibold text-foreground">Structure</th>
                            <th class="text-left py-2.5 px-4 font-semibold text-foreground">Use</th>
                            <th class="text-left py-2.5 px-4 font-semibold text-foreground">Example</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-border/50 ">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline" href="/exercises/tenses/present-simple">Present
                                    Simple</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">Subject + base verb (+ s/es)
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground">Habits, facts, routines</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">She works in a hospital.</td>
                        </tr>
                        <tr class="border-b border-border/50 bg-muted/20">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline"
                                    href="/exercises/tenses/present-continuous">Present Continuous</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">am/is/are + verb-ing</td>
                            <td class="py-2.5 px-4 text-muted-foreground">Actions happening now, temporary situations
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">I'm reading a great book this week.
                            </td>
                        </tr>
                        <tr class="border-b border-border/50 ">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline"
                                    href="/exercises/tenses/present-perfect">Present Perfect</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">have/has + past participle
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground">Past actions with present relevance</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">I've visited Paris three times.</td>
                        </tr>
                        <tr class="border-b border-border/50 bg-muted/20">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline"
                                    href="/exercises/tenses/present-perfect-continuous">Present Perfect Continuous</a>
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">have/has been + verb-ing
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground">Duration of an action up to now</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">She's been studying English for two
                                years.</td>
                        </tr>
                        <tr class="border-b border-border/50 ">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline" href="/exercises/tenses/past-simple">Past
                                    Simple</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">Subject + past form (verb-ed
                                / irregular)</td>
                            <td class="py-2.5 px-4 text-muted-foreground">Completed past actions</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">We moved to London in 2019.</td>
                        </tr>
                        <tr class="border-b border-border/50 bg-muted/20">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline" href="/exercises/tenses/past-continuous">Past
                                    Continuous</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">was/were + verb-ing</td>
                            <td class="py-2.5 px-4 text-muted-foreground">Actions in progress at a past moment</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">I was sleeping when the phone rang.
                            </td>
                        </tr>
                        <tr class="border-b border-border/50 ">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline" href="/exercises/tenses/past-perfect">Past
                                    Perfect</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">had + past participle</td>
                            <td class="py-2.5 px-4 text-muted-foreground">An action before another past action</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">She had already left when I arrived.
                            </td>
                        </tr>
                        <tr class="border-b border-border/50 bg-muted/20">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline"
                                    href="/exercises/tenses/past-perfect-continuous">Past Perfect Continuous</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">had been + verb-ing</td>
                            <td class="py-2.5 px-4 text-muted-foreground">Duration of an action before a past event</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">They had been waiting for an hour
                                before the bus came.</td>
                        </tr>
                        <tr class="border-b border-border/50 ">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline" href="/exercises/tenses/future-simple">Future
                                    Simple</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">will + base verb</td>
                            <td class="py-2.5 px-4 text-muted-foreground">Predictions, decisions, promises</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">I'll help you with your homework.</td>
                        </tr>
                        <tr class="border-b border-border/50 bg-muted/20">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline"
                                    href="/exercises/tenses/future-continuous">Future Continuous</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">will be + verb-ing</td>
                            <td class="py-2.5 px-4 text-muted-foreground">Actions in progress at a future moment</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">This time tomorrow, I'll be flying to
                                Tokyo.</td>
                        </tr>
                        <tr class="border-b border-border/50 ">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline"
                                    href="/exercises/tenses/future-perfect">Future Perfect</a></td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">will have + past participle
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground">Actions completed before a future point</td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">By June, I will have finished the
                                course.</td>
                        </tr>
                        <tr class="border-b border-border/50 bg-muted/20">
                            <td class="py-2.5 px-4 font-medium whitespace-nowrap"><a
                                    class="text-primary hover:underline"
                                    href="/exercises/tenses/future-perfect-continuous">Future Perfect Continuous</a>
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground font-mono text-xs">will have been + verb-ing
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground">Duration of an action up to a future point
                            </td>
                            <td class="py-2.5 px-4 text-muted-foreground italic">By next year, she will have been
                                teaching for 20 years.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </main>

</body>

</html>
