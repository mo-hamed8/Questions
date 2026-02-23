<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>JSON Input</title>
    <style>
        body {
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Arial;
            margin: 0;
            background: #f6f7fb;
        }

        .wrap {
            max-width: 950px;
            margin: 40px auto;
            padding: 0 16px;
        }

        .card {
            background: #fff;
            border: 1px solid #e7e7ef;
            border-radius: 14px;
            padding: 18px;
        }

        h1 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        p {
            margin: 0 0 14px;
            color: #555;
            font-size: 13px;
            line-height: 1.6;
        }

        textarea,
        pre {
            width: 100%;
            border-radius: 12px;
            border: 1px solid #e7e7ef;
            padding: 12px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Consolas, monospace;
            font-size: 13px;
            background: #fafafa;
        }

        textarea {
            min-height: 220px;
            resize: vertical;
        }

        .row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 12px;
        }

        button {
            border: 0;
            padding: 10px 14px;
            border-radius: 12px;
            cursor: pointer;
            background: #111827;
            color: white;
            font-weight: 600;
        }

        button.secondary {
            background: #eef2ff;
            color: #111827;
            border: 1px solid #dbe2ff;
        }

        .status {
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 12px;
            font-size: 13px;
            display: none;
        }

        .ok {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        .bad {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        pre {
            min-height: 180px;
            overflow: auto;
            margin-top: 12px;
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div class="card">
            <h1>Paste JSON</h1>
            <p>Paste your JSON below, then click <b>Validate</b>. If valid, it will be formatted in the output box.</p>

            <textarea id="jsonInput" placeholder='Enter JSON.'></textarea>

            <div class="row">
                <button type="button" onclick="validateJson()">Validate & Format</button>
                <button type="button" class="secondary" onclick="loadExample()">Load Example</button>
                <button type="button" class="secondary" onclick="clearAll()">Clear</button>
            </div>

            <div id="status" class="status"></div>

            <pre id="output" aria-label="formatted-json"></pre>
        </div>
    </div>

    <script>
        const input = document.getElementById('jsonInput');
        const statusEl = document.getElementById('status');
        const outputEl = document.getElementById('output');

        function setStatus(type, msg) {
            statusEl.className = 'status ' + (type === 'ok' ? 'ok' : 'bad');
            statusEl.textContent = msg;
            statusEl.style.display = 'block';
        }

        async function validateJson() {

            const text = input.value.trim();
            outputEl.textContent = '';
            statusEl.style.display = 'none';

            if (!text) {
                setStatus('bad', 'Please paste JSON first.');
                return;
            }

            try {
                const obj = JSON.parse(text);

                // عرض JSON منسق
                outputEl.textContent = JSON.stringify(obj, null, 2);
                setStatus('ok', '✅ Valid JSON — Sending to server...');

                // إرسال إلى Laravel API
                const response = await fetch('/api/questions', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(obj)
                });

                const data = await response.json();

                if (response.ok) {
                    setStatus('ok', '✅ Sent successfully: ' + data.message);
                } else {
                    setStatus('bad', '❌ Server error: ' + (data.message || 'Validation failed'));
                }

            } catch (e) {
                setStatus('bad', '❌ Invalid JSON: ' + e.message);
            }
        }

        function loadExample() {
            input.value = JSON.stringify({
                questions: [{
                        title: "What does API stand for?",
                        choiceA: "Application Programming Interface",
                        choiceB: "Advanced Program Integration",
                        choiceC: "Applied Protocol Internet",
                        choiceD: "Automated Process Input",
                        answer: "A"
                    },
                    {
                        title: "Which HTTP method is typically used to create new data?",
                        choiceA: "GET",
                        choiceB: "POST",
                        choiceC: "DELETE",
                        choiceD: "PUT",
                        answer: "B"
                    },
                    {
                        title: "Which database is commonly used with Laravel?",
                        choiceA: "MySQL",
                        choiceB: "MongoDB",
                        choiceC: "Firebase",
                        choiceD: "Redis",
                        answer: "A"
                    }
                ]
            }, null, 2);
        }


        function clearAll() {
            input.value = '';
            outputEl.textContent = '';
            statusEl.style.display = 'none';
        }
    </script>
</body>

</html>
