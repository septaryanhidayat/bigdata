<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PpdbRegistration;
use App\Services\GeminiAiService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiAiController extends Controller
{
    protected GeminiAiService $ai;

    public function __construct(GeminiAiService $ai)
    {
        $this->ai = $ai;
    }

    /**
     * Test live Gemini API connection status
     */
    public function testConnection()
    {
        $result = $this->ai->testConnection();
        return response()->json($result);
    }

    /**
     * FEATURE 1: Generate School News / Article Draft for CMS
     */
    public function generateArticle(Request $request)
    {
        $request->validate([
            'topic' => 'required|string|max:255',
            'category' => 'nullable|string|max:50',
            'tone' => 'nullable|string|max:50',
            'unit_scope' => 'nullable|string|max:50',
        ]);

        $topic = $request->input('topic');
        $category = $request->input('category', 'Berita');
        $tone = $request->input('tone', 'islami_inspiratif');
        $unitScope = $request->input('unit_scope', 'all');

        $result = $this->ai->writeArticleDraft($topic, $category, $tone, $unitScope);

        return response()->json($result);
    }

    /**
     * FEATURE 2: AI SPMB Smart Applicant Analyzer
     */
    public function analyzeSpmb(Request $request)
    {
        $regId = $request->input('id');
        $data = [];

        if ($regId) {
            $registration = PpdbRegistration::find($regId);
            if ($registration) {
                $details = $registration->details_json ?? [];
                $data = [
                    'nama_lengkap' => $registration->full_name,
                    'unit' => $registration->target_level,
                    'asal_sekolah' => $registration->previous_school ?? ($details['asal_sekolah'] ?? '-'),
                    'hobi' => $details['hobi'] ?? ($details['prestasi'] ?? 'Umum'),
                    'alasan_memilih' => $details['alasan_memilih'] ?? ($details['motivasi'] ?? 'Pendidikan Islam Berkarakter'),
                ];
            }
        }

        if (empty($data)) {
            $data = [
                'nama_lengkap' => $request->input('name', 'Calon Siswa'),
                'unit' => $request->input('unit', 'SDIT'),
                'asal_sekolah' => $request->input('previous_school', '-'),
                'hobi' => $request->input('talents', 'Umum'),
                'alasan_memilih' => $request->input('notes', 'Ingin mendalami ilmu agama & akademik unggul'),
            ];
        }

        $result = $this->ai->analyzeSpmbApplicant($data);

        // Optionally persist analysis into PpdbRegistration details_json
        if ($regId && isset($registration) && $result['success']) {
            $details = $registration->details_json ?? [];
            $details['ai_analysis'] = $result['data'];
            $registration->details_json = $details;
            $registration->save();
        }

        return response()->json($result);
    }

    /**
     * FEATURE 3: Generate CBT / LMS Quiz Questions
     */
    public function generateQuiz(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:100',
            'topic' => 'required|string|max:200',
            'grade' => 'nullable|string|max:50',
            'count' => 'nullable|integer|min:1|max:10',
            'difficulty' => 'nullable|string|max:50',
        ]);

        $subject = $request->input('subject');
        $topic = $request->input('topic');
        $grade = $request->input('grade', 'SMP');
        $count = (int) $request->input('count', 5);
        $difficulty = $request->input('difficulty', 'Sedang');

        $result = $this->ai->generateQuizQuestions($subject, $topic, $grade, $count, $difficulty);

        return response()->json($result);
    }

    /**
     * FEATURE 4A: WhatsApp Auto-Responder Live Simulator
     */
    public function whatsappSimulate(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $message = $request->input('message');
        $sender = $request->input('sender', '08123456789');

        $reply = $this->ai->autoReplyWhatsApp($message, $sender);

        return response()->json([
            'success' => true,
            'incoming_message' => $message,
            'ai_reply' => $reply,
        ]);
    }

    /**
     * FEATURE 4B: Public WhatsApp Webhook Endpoint (e.g. Fonnte / WABA / Custom)
     */
    public function whatsappWebhook(Request $request)
    {
        // Support Fonnte standard webhook format
        $sender = $request->input('sender') ?: $request->input('from');
        $message = $request->input('message') ?: $request->input('text');

        if (empty($message)) {
            return response()->json(['status' => false, 'message' => 'Pesan kosong'], 400);
        }

        $reply = $this->ai->autoReplyWhatsApp($message, $sender);

        // If Fonnte token is present in env, auto-reply directly via Fonnte API
        $fonnteToken = env('FONNTE_TOKEN');
        if (!empty($fonnteToken) && !empty($sender)) {
            try {
                Http::withHeaders([
                    'Authorization' => $fonnteToken,
                ])->timeout(8)->post('https://api.fonnte.com/send', [
                    'target' => $sender,
                    'message' => $reply,
                ]);
            } catch (\Throwable $e) {
                Log::warning('Gagal auto-reply Fonnte WA: ' . $e->getMessage());
            }
        }

        return response()->json([
            'status' => true,
            'sender' => $sender,
            'reply' => $reply,
        ]);
    }
}
