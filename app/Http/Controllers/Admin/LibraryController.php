<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\School;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = session('dashboard_school_id', 'all');
        $booksQuery = LibraryBook::with('school');

        if ($schoolId !== 'all') {
            $booksQuery->where('school_id', $schoolId);
        }

        $books = $booksQuery->latest()->get();

        if ($books->isEmpty()) {
            $samples = [
                ['title' => 'Tafsir Al-Azhar Lengkap 30 Juz', 'author' => 'Prof. Dr. Buya Hamka', 'isbn' => '978-602-001-01', 'category' => 'AGAMA_ISLAM', 'stock' => 15],
                ['title' => 'Siroh Nabawiyah & Sejarah Islam', 'author' => 'Syaikh Shafiyurrahman', 'isbn' => '978-602-002-02', 'category' => 'SEJARAH', 'stock' => 20],
                ['title' => 'Matematika KBM Kurikulum Merdeka SMPIT', 'author' => 'Tim Penulis SIT Robbani', 'isbn' => '978-602-003-03', 'category' => 'PELAJARAN', 'stock' => 50],
            ];

            foreach ($samples as $b) {
                $targetSchoolId = ($schoolId !== 'all') ? $schoolId : (School::first()?->id ?? 1);
                $isbn = $b['isbn'] . '-S' . $targetSchoolId;

                LibraryBook::firstOrCreate(
                    ['isbn' => $isbn],
                    [
                        'school_id' => $targetSchoolId,
                        'title' => $b['title'],
                        'author' => $b['author'],
                        'publisher' => 'Penerbit SIT Robbani Press',
                        'stock' => $b['stock'],
                        'available_stock' => $b['stock'],
                        'category' => $b['category'],
                    ]
                );
            }
            $books = $booksQuery->latest()->get();
        }

        return view('admin.library.index', compact('books', 'schoolId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|string|unique:library_books,isbn',
            'title' => 'required|string',
            'author' => 'required|string',
            'stock' => 'required|integer|min:1',
            'category' => 'required|string',
        ]);

        $schoolId = session('dashboard_school_id', 'all');
        $validated['school_id'] = ($schoolId !== 'all') ? $schoolId : School::first()?->id;
        $validated['available_stock'] = $validated['stock'];

        $book = LibraryBook::create($validated);

        try {
            \App\Models\AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'INPUT BUKU PERPUS',
                'model_type' => 'LibraryBook',
                'model_id' => $book->id,
                'ip_address' => request()->ip(),
            ]);
        } catch(\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Buku Baru Perpustakaan Berhasil Ditambahkan!');
    }
}
