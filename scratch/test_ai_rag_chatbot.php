<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\AiKnowledgeBase;
use App\Services\AiRagEngine;
use App\Http\Controllers\SchoolWebsiteController;
use Illuminate\Http\Request;

echo "=== TESTING AI KNOWLEDGE RAG ENGINE & CHATBOT INTEGRATION ===\n\n";

// 1. Test Ingestion & Model
$count = AiKnowledgeBase::count();
assert($count >= 4, "Knowledge base should have seeded documents");
echo "✓ 1. Knowledge Base contains {$count} ingested documents!\n";

// 2. Test Document Retrieval (RAG)
$docs = AiKnowledgeBase::findRelevantKnowledge("berapa target hafalan tahfidz quran di sdit dan smait?");
assert(!empty($docs), "Should find relevant documents for Tahfidz query");
assert(str_contains(strtolower($docs[0]->title), 'tahfidz'), "Top document should be Tahfidz related");
echo "✓ 2. Semantic Document Retrieval successfully found: '{$docs[0]->title}'!\n";

// 3. Test AI RAG Engine Synthesizer
$answer = AiRagEngine::answer("Jelaskan alur pendaftaran dan syarat SPMB 2026");
assert(strlen($answer) > 50, "Answer should be informative and detailed");
echo "✓ 3. AiRagEngine generated structured response with document context!\n";

// 4. Test Chatbot POST /chat-ai Controller
$controller = app(SchoolWebsiteController::class);
$req = Request::create('/chat-ai', 'POST', ['message' => 'Bagaimana cara bayar tagihan SPP online?']);
$res = $controller->chatAi($req);
$json = json_decode($res->getContent(), true);

assert($json['status'] === 'success', "Response status must be success");
assert(str_contains($json['answer'], 'SPP') || str_contains($json['answer'], 'Virtual Account'), "Answer should address SPP payment");
echo "✓ 4. POST /chat-ai endpoint successfully returned AI answer!\n";

// 5. Test Homepage Digital Showcase contains AI Tab
$homeView = $controller->index();
$homeHtml = $homeView->render();
assert(str_contains($homeHtml, 'ai_assistant'), "Homepage must contain ai_assistant tab in digital showcase");
assert(str_contains($homeHtml, '23+ Modul'), "Homepage must display 23+ Modul");
assert(str_contains($homeHtml, 'Robbani Smart AI Assistant'), "Homepage showcase must present Robbani Smart AI Assistant");
echo "✓ 5. Main website digital showcase confirmed displaying Modul 23 AI Chatbot RAG!\n";

echo "\n=== ALL AI CHATBOT & KNOWLEDGE RAG TESTS PASSED 100%! ===\n";
