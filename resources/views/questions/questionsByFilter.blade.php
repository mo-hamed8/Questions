<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0" />
    <title>Worksheet • English Grammar</title>

    <link rel="stylesheet" href="https://unpkg.com/tailwindcss@2.2.19/dist/tailwind.min.css">

    <style>
        html { scroll-behavior: smooth; }
        .glass { backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); }
        .shadow-soft { box-shadow: 0 10px 30px rgba(0, 0, 0, .06); }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">

<header class="sticky top-0 z-40 border-b border-gray-200 bg-white bg-opacity-80 glass">
    <div class="mx-auto max-w-5xl px-4">
        <div class="flex h-14 items-center justify-between">
            <a href="#" class="flex items-center gap-2 font-semibold">
                <span class="rounded-md border border-gray-200 bg-white px-2 py-1 text-sm text-gray-800 shadow-sm">
                    English - Grammar .app
                </span>
                <span class="text-xs text-gray-500">Worksheet</span>
            </a>

            <button id="focusBtn"
                class="inline-flex items-center gap-2 rounded-lg border border-gray-200 bg-white px-3 py-1.5 text-sm text-gray-800 hover:bg-gray-50 shadow-sm">
                <span class="h-2 w-2 rounded-full bg-gray-300" id="focusDot"></span>
                Focus <span class="ml-1 text-xs text-gray-500">(F)</span>
            </button>
        </div>
    </div>
</header>

<main class="mx-auto max-w-5xl px-4 py-6">
    <div class="text-sm text-gray-600">
        <span id="answeredText">0 of 0 answered</span>
    </div>

    <div class="mt-4 rounded-xl border border-gray-200 bg-white p-4 shadow-soft">
        <div class="mb-2 flex items-center justify-between text-sm text-gray-700">
            <span id="progressLabel" class="font-medium">0% complete</span>
            <button id="resetBtn"
                class="rounded-md border border-gray-200 bg-white px-2 py-1 text-xs hover:bg-gray-50">
                Reset
            </button>
        </div>

        <div class="h-2 w-full rounded-full bg-gray-100 overflow-hidden">
            <div id="progressBar" class="h-2 rounded-full bg-blue-600" style="width:0%"></div>
        </div>

        <!-- ✅ الإضافة -->
        <div class="mt-3 flex items-center justify-between text-sm">
            <div>⏱ Time: <span id="timer">00:00</span></div>
            <div>
                ✅ Correct: <span id="correctCount">0</span> |
                ❌ Wrong: <span id="wrongCount">0</span>
            </div>
        </div>

        <div class="mt-3 text-xs">
            <span id="apiStatus" class="text-gray-500">API: idle</span>
        </div>
    </div>

    <section id="questions" class="mt-6 space-y-5"></section>
</main>

<script>
const API_BASE = "api";
const TOKEN = localStorage.getItem("token");
const categoriesParam = @json(request()->route('categories'));
let QUESTIONS = [];

const state = { answers: [] };

// ✅ إضافات
let timerStarted = false;
let startTime = null;
let timerInterval = null;

let correctCount = 0;
let wrongCount = 0;

const timerEl = document.getElementById("timer");
const correctEl = document.getElementById("correctCount");
const wrongEl = document.getElementById("wrongCount");

function startTimer() {
    if (timerStarted) return;

    timerStarted = true;
    startTime = Date.now();

    timerInterval = setInterval(() => {
        const diff = Date.now() - startTime;
        const seconds = Math.floor(diff / 1000) % 60;
        const minutes = Math.floor(diff / 60000);

        timerEl.textContent =
            `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }, 1000);
}

async function loadQuestions() {
    try {
        const res = await fetch(`/api/questionByFilter/${categoriesParam}`);
        if (!res.ok) throw new Error("Failed to fetch questions");
        QUESTIONS = await res.json();
        state.answers = new Array(QUESTIONS.length).fill(null);
        render();
    } catch (e) {
        console.error(e);
    }
}

document.addEventListener("DOMContentLoaded", loadQuestions);

const elQ = document.getElementById("questions");
const answeredText = document.getElementById("answeredText");
const progressBar = document.getElementById("progressBar");
const progressLabel = document.getElementById("progressLabel");

function headers() {
    return { "Content-Type": "application/json", "Accept": "application/json" };
}

function updateProgress() {
    const answered = state.answers.filter(a => a !== null).length;
    const total = QUESTIONS.length;
    const pct = total ? Math.round((answered / total) * 100) : 0;
    answeredText.textContent = `${answered} of ${total} answered`;
    progressLabel.textContent = `${pct}% complete`;
    progressBar.style.width = `${pct}%`;
}

function setQuestionStatus(idx, status) {
    const card = document.querySelector(`[data-card="${idx}"]`);
    if (!card) return;
    card.classList.remove(
        "border-green-400", "bg-green-50",
        "border-red-400", "bg-red-50",
        "border-yellow-400", "bg-yellow-50"
    );
    if (status === "sending") card.classList.add("border-yellow-400", "bg-yellow-50");
    else if (status === "success") card.classList.add("border-blue-400", "bg-blue-50");
    else if (status === "error") card.classList.add("border-red-400", "bg-red-50");
}

function markUI(idx, pickedIdx) {
    const q = QUESTIONS[idx];
    const letters = ['A','B','C','D'];
    const pickedLetter = letters[pickedIdx];
    const isCorrect = pickedLetter === q.answer;

    const buttons = document.querySelectorAll(`[data-q="${idx}"]`);
    buttons.forEach(b => b.classList.remove("border-green-400","bg-green-50","border-red-400","bg-red-50"));

    const chosenBtn = document.querySelector(`[data-q="${idx}"][data-o="${pickedIdx}"]`);
    if (chosenBtn) chosenBtn.classList.add(isCorrect?"border-green-400":"border-red-400", isCorrect?"bg-green-50":"bg-red-50");

    const correctIdx = letters.indexOf(q.answer);
    const correctBtn = document.querySelector(`[data-q="${idx}"][data-o="${correctIdx}"]`);
    if (correctBtn) correctBtn.classList.add("border-green-400","bg-green-50");

    const msg = document.getElementById(`msg-${idx}`);
    if (msg) {
        msg.textContent = isCorrect ? `Correct ✅ (${q.answer})` : `Wrong ❌ (Correct: ${q.answer})`;
        msg.className = "mt-2 text-sm " + (isCorrect ? "text-green-600":"text-red-600");
    }

    const catDiv = document.getElementById(`categories-${idx}`);
    if (catDiv) {
        catDiv.textContent = `Categories: ${q.categories ? q.categories.map(c=>c.name).join(", ") : "N/A"}`;
    }

    return isCorrect;
}

async function sendAnswer(payload) {
    return fetch(`/${API_BASE}/answer`, { method:"POST", headers:headers(), body:JSON.stringify(payload) });
}

async function fetchExplanation(questionId) {
    try {
        const res = await fetch(`/api/getExplanation/${questionId}`);
        if (!res.ok) throw new Error("Failed");
        return await res.json();
    } catch (e) {
        console.error(e);
        return null;
    }
}

function render() {
    elQ.innerHTML = "";
    QUESTIONS.forEach((q,i)=>{
        const card = document.createElement("div");
        card.className = "rounded-xl border border-gray-200 bg-white p-4 shadow-soft transition";
        card.dataset.card = i;

        const title = document.createElement("div");
        title.className = "font-medium text-gray-900";
        title.textContent = `${i+1}. ${q.title}`;

        const opts = document.createElement("div");
        opts.className = "mt-3 grid gap-2";
        const options = [q.choiceA,q.choiceB,q.choiceC,q.choiceD];

        options.forEach((opt,j)=>{
            const btn = document.createElement("button");
            btn.type="button";
            btn.className="w-full rounded-lg border border-gray-200 px-3 py-2 text-left hover:bg-gray-50 transition";
            btn.dataset.q=i;
            btn.dataset.o=j;
            btn.textContent=`${String.fromCharCode(65+j)}) ${opt}`;

            btn.addEventListener("click", async ()=>{

                startTimer(); // ✅

                if (state.answers[i] !== null) return;

                const letters = ['A','B','C','D'];

                state.answers[i]=j;
                updateProgress();

                const isCorrect = markUI(i,j);

                // ✅ عداد
                if (isCorrect) correctCount++;
                else wrongCount++;

                correctEl.textContent = correctCount;
                wrongEl.textContent = wrongCount;

                // ✅ انتهاء
                const answered = state.answers.filter(a => a !== null).length;
                if (answered === QUESTIONS.length) {
                    clearInterval(timerInterval);
                    setTimeout(()=>{
                        alert(`🎉 Finished!\n\n⏱ Time: ${timerEl.textContent}\n✅ Correct: ${correctCount}\n❌ Wrong: ${wrongCount}`);
                    },300);
                }

                setQuestionStatus(i,"sending");

                try{
                    const res = await sendAnswer({question_id:q.id, choice:letters[j]});
                    if(!res.ok){ setQuestionStatus(i,"error"); return;}
                    setQuestionStatus(i,"success");
                }catch(e){ setQuestionStatus(i,"error"); console.error(e);}
            });

            opts.appendChild(btn);
        });

        const msg = document.createElement("div");
        msg.id=`msg-${i}`;
        msg.className="mt-2 text-sm text-gray-500";

        const catDiv = document.createElement("div");
        catDiv.id=`categories-${i}`;
        catDiv.className="mt-1 text-xs text-gray-500 italic";

        const explainBtn = document.createElement("button");
        explainBtn.type = "button";
        explainBtn.className = "mt-3 rounded-md bg-yellow-400 text-gray-900 px-3 py-2 text-sm font-medium hover:bg-yellow-500 shadow-sm transition";
        explainBtn.textContent = "Show Explanation";

        const explanationDiv = document.createElement("div");
        explanationDiv.className = "mt-2 text-sm text-gray-600";

        explainBtn.addEventListener("click", async ()=>{
            explanationDiv.innerHTML = "Loading...";
            const data = await fetchExplanation(q.id);

            if(!data){
                explanationDiv.textContent = "Error fetching explanation.";
                return;
            }

            explanationDiv.innerHTML = `
                <div class="mt-2 border-l-4 border-blue-400 bg-blue-50 p-3 rounded-md space-y-2">
                    <div><strong>Rule:</strong> ${data.rule_name}</div>
                    <div><strong>Explanation:</strong> ${data.detailed_explanation}</div>
                </div>
            `;
        });

        card.appendChild(title);
        card.appendChild(opts);
        card.appendChild(msg);
        card.appendChild(catDiv);
        card.appendChild(explainBtn);
        card.appendChild(explanationDiv);

        elQ.appendChild(card);
    });

    updateProgress();
}

// Reset
document.getElementById("resetBtn").addEventListener("click", () => {
    state.answers = new Array(QUESTIONS.length).fill(null);

    correctCount = 0;
    wrongCount = 0;

    correctEl.textContent = 0;
    wrongEl.textContent = 0;

    timerEl.textContent = "00:00";

    timerStarted = false;
    clearInterval(timerInterval);

    render();
});
</script>

</body>
</html>
