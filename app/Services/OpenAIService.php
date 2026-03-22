<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\RequestException;

class OpenAIService
{
    protected string $url;
    protected string $key;
    protected string $model;
    protected string $timeout;
    protected string $max_output_tokens;

    public function __construct()
    {
        $this->url = config('services.openai.base_url');
        $this->key = config('services.openai.key');
        $this->model = config('services.openai.model');
        $this->timeout = config('services.openai.timeout');
        $this->max_output_tokens = config('services.openai.max_output_tokens');
    }

    public function chat(array $data): array
    {
        $systemPrompt = <<<PROMPT
You are an expert English grammar teacher and linguist.

You will be given:
- A multiple-choice grammar question
- The correct answer

Your task is to explain and justify the given answer with high accuracy.

Instructions:
- Use ONLY the given correct answer (do not change it).
- Determine the exact grammar rule.
- Classify the grammar topic.
- Provide a clear and logical reason.
- Give a detailed explanation in English.
- Provide a clear Arabic explanation.
- Generate relevant grammar tags.
- Assign a confidence score between 0 and 1.

Strict rules:
- Do NOT change the given answer.
- Return ONLY valid JSON.
- Do NOT include any extra text outside JSON.
- Be precise and educational.

JSON format:
{
  "rule_name": "",
  "grammar_topic": "",
  "tags": [],
  "reason": "",
  "detailed_explanation": "",
  "arabic_explanation": "",
  "confidence": 0.0
}
PROMPT;

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->key,
                'Content-Type'  => 'application/json',
            ])->timeout($this->timeout)->post($this->url, [
                "model" => $this->model,

                "input" => [
                    [
                        "role" => "system",
                        "content" => $systemPrompt
                    ],
                    [
                        "role" => "user",
                        "content" => json_encode($data, JSON_UNESCAPED_UNICODE)
                    ]
                ],

                "temperature" => 0.2,

                "max_output_tokens" =>(int) $this->max_output_tokens,


            ]);

            $result = $response->throw()->json();

            $text = $this->extractText($result);

            $decode = json_decode($text, true);

            if (!$this->validateOpenAIData($decode)) {
                return [
                    "error" => "Invalid JSON format from OpenAi.",
                    "raw"   => $text
                ];
            };

            return $decode ?? [
                "error" => "Invalid JSON from model",
                "raw"   => $text
            ];
        } catch (RequestException $e) {
            return [
                "error" => "Request failed",
                "details" => $e->response?->json()
            ];
        }
    }


    private function extractText(array $result): string
    {
        if (!empty($result['output'][0]['content'][0]['text'])) {
            return $result['output'][0]['content'][0]['text'];
        }

        if (!empty($result['output_text'])) {
            return $result['output_text'];
        }

        return '';
    }

    function validateOpenAIData(array $data): bool
    {
        $requiredKeys = [
            "rule_name" => 'string',
            "grammar_topic" => 'string',
            "tags" => 'array',
            "reason" => 'string',
            "detailed_explanation" => 'string',
            "arabic_explanation" => 'string',
            "confidence" => 'numeric'
        ];

        foreach ($requiredKeys as $key => $type) {
            if (!array_key_exists($key, $data)) {
                return false; // الحقل مفقود
            }

            if ($type === 'string' && !is_string($data[$key])) {
                return false; // النوع غير صحيح
            }

            if ($type === 'array' && !is_array($data[$key])) {
                return false;
            }

            if ($type === 'numeric' && !is_numeric($data[$key])) {
                return false;
            }
        }

        return true;
    }
}
