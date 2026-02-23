<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Select Filters • English Grammar</title>

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #eef2ff, #f8fafc);
        }

        .glass {
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            background: rgba(255, 255, 255, 0.6);
        }

        .card-hover {
            transition: all .25s ease;
        }

        .card-hover:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08);
        }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center antialiased">

    <main class="w-full max-w-4xl px-6 py-12">

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="inline-block px-4 py-1 mb-4 text-xs font-medium text-blue-600 bg-blue-100 rounded-full">
                English Grammar .app
            </div>

            <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                Build Your Worksheet
            </h1>

            <p class="text-gray-500 mt-3">
                Select one or more categories and generate your custom practice sheet
            </p>
        </div>

        <!-- Glass Card -->
        <div class="glass rounded-2xl shadow-xl p-8 border border-white/40">

            <!-- Controls -->
            <div class="flex justify-between items-center mb-6">
                <h2 class="font-semibold text-gray-700">Available Categories</h2>

                <button id="selectAllBtn"
                    class="text-sm px-3 py-1 rounded-md bg-gray-100 hover:bg-gray-200 transition">
                    Select All
                </button>
            </div>

            <!-- Categories -->
            <div id="categoriesContainer"
                class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            </div>

            <!-- Error Message -->
            <div id="errorBox"
                class="hidden mt-6 text-center text-sm text-red-600 font-medium">
                Please select at least one category.
            </div>

            <!-- Start Button -->
            <div class="mt-10 text-center">
                <button id="startBtn"
                    class="inline-block px-8 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-medium shadow-lg hover:scale-105 transform transition">
                    🚀 Start Worksheet
                </button>
            </div>

        </div>

    </main>

    <script>
        const API_BASE = "api";
        const baseUrl = "{{ url('questionByFilter') }}";
        let CATEGORIES = [];

        async function loadCategories() {
            try {
                const res = await fetch(`${API_BASE}/categories`);
                if (!res.ok) throw new Error("Failed to load categories");
                CATEGORIES = await res.json();
                renderCategories();
            } catch (e) {
                console.error(e);
            }
        }

        function renderCategories() {
            const container = document.getElementById("categoriesContainer");
            container.innerHTML = "";

            CATEGORIES.forEach(cat => {

                const label = document.createElement("label");
                label.className = `
                    card-hover flex items-center justify-between
                    p-4 rounded-xl border border-gray-200
                    bg-white cursor-pointer
                `;

                const left = document.createElement("div");
                left.className = "flex items-center gap-3";

                const checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.value = cat.id ?? cat;
                checkbox.className = "h-5 w-5 text-blue-600 rounded focus:ring-blue-500";

                const span = document.createElement("span");
                span.className = "font-medium text-gray-700";
                span.textContent = cat.name ?? cat;

                left.appendChild(checkbox);
                left.appendChild(span);

                const badge = document.createElement("span");
                badge.className = "text-xs bg-gray-100 px-2 py-1 rounded-md text-gray-500";
                badge.textContent = "Grammar";

                label.appendChild(left);
                label.appendChild(badge);

                container.appendChild(label);
            });
        }

        document.getElementById("selectAllBtn").addEventListener("click", () => {
            const checkboxes = document.querySelectorAll("input[type=checkbox]");
            const allChecked = [...checkboxes].every(cb => cb.checked);
            checkboxes.forEach(cb => cb.checked = !allChecked);
        });

        document.getElementById("startBtn").addEventListener("click", () => {

            const selected = [...document.querySelectorAll("input[type=checkbox]:checked")]
                .map(cb => cb.value);

            if (selected.length === 0) {
                document.getElementById("errorBox").classList.remove("hidden");
                return;
            }

            document.getElementById("errorBox").classList.add("hidden");

            const categories = selected.join(",");

            // انتقال إلى Laravel route
            window.location.href = `${baseUrl}/${categories}`;
        });

        document.addEventListener("DOMContentLoaded", loadCategories);
    </script>

</body>

</html>
