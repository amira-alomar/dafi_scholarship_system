<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Scholarship;
use Illuminate\Http\Client\RequestException;

class ScholarshipMentorController extends Controller
{
    public function analyze(Request $request)
    {
        if ($request->isMethod('get')) {
            return view('candidate.mentorAi');
        }
        // 1. تأكد من وجود الـ API Key
        $apiKey = env('ROUTE_API_KEY'); // مفتاح OpenRouter
        if (! $apiKey) {
            Log::critical('Missing OpenRouter API key in .env');
            return view('candidate.aiResult', [
                'advice' => 'Configuration error: AI service is unavailable.'
            ]);
        }

        // 2. جهّز بيانات المستخدم
        $data = $request->only([ 'age', 'country', 'field', 'target']);

        // 3. جلب المنح المناسبة
        $matchingScholarships = Scholarship::with(['university', 'countries'])
            ->whereHas('countries', fn($q2) => $q2->where('country_name', $data['country']))
            ->orWhere('target_group', $data['target'])
            ->orWhere('description', 'like', '%' . $data['field'] . '%')
            ->limit(5)
            ->get();

        // 4. إعداد قائمة المنح للـ AI
        $scholarshipList = $matchingScholarships->map(
            fn($s) => "- **{$s->name}**  
  • Org: {$s->funding_organization}  
  • Uni: {$s->university->name} ({$s->university->location})  
  • Group: {$s->target_group}  
  • To: " . $s->countries->pluck('country_name')->join(', ') . "  
  • Desc: " . str_replace("\n", ' ', $s->description) . "\n"
        )->implode("\n");

        // 5. بناء الرسائل مع System + User
        $messages = [
            ['role' => 'system', 'content' => 'You are an expert scholarship mentor. Only recommend scholarships from the list provided. Do not invent or suggest anything outside the list. Respond concisely.'],
            ['role' => 'user', 'content' => "
User Profile:
- Age: {$data['age']}
- Country: {$data['country']}
- Field: {$data['field']}
- Degree: {$data['target']}


Scholarship Options (from the database):
$scholarshipList

Please:
1. Recommend only the best-fitting scholarships from the list above.
2. Highlight the user's strengths and potential concerns.
3. Give 2–3 practical tips for applying to those exact scholarships.
"]
        ];

        if ($matchingScholarships->isEmpty()) {
            $advice = 'Sorry, we couldn’t find any matching scholarships for your profile.';
            return view('candidate.mentorAi', ['advice' => $advice]);
        }


        try {
            // 6. إرسال الطلب لـ OpenRouter
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'HTTP-Referer' => 'https://yourwebsite.com', // غيّريه لرابطك أو GitHub
                'X-Title' => 'Scholarship Mentor',
            ])
                ->timeout(30)
                ->post('https://openrouter.ai/api/v1/chat/completions', [
                    'model'    => 'openai/gpt-3.5-turbo',
                    'messages' => $messages,
                ]);

            // 7. سجل الرد الخام
            Log::info('OpenRouter response status ' . $response->status(), [
                'body' => $response->body(),
            ]);

            // 8. ارمي استثناء على الأخطاء
            $response->throw();
            $body = $response->json();

            // 9. استخراج النص
            $advice = data_get($body, 'choices.0.message.content', null);
            if (! $advice) {
                Log::error('OpenRouter returned no content', $body);
                $advice = 'Sorry, no advice could be generated.';
            }
        } catch (RequestException $e) {
            // HTTP 4xx/5xx
            $res = $e->response;
            Log::error('OpenRouter HTTP Error', [
                'status' => $res?->status(),
                'body'   => $res?->body(),
            ]);
            $advice = 'Error: ' . $res?->body();
        } catch (\Exception $e) {
            // خطأ عام
            Log::error('Unexpected error in ScholarshipMentorController', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            $advice = 'An unexpected error occurred. Please try again later.';
        }
        if ($request->ajax()) {
            return response()->json(['advice' => $advice]);
        }
        return view('candidate.mentorAi', ['advice' => $advice]);
    }
}
