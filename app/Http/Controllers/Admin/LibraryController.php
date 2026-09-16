<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\School;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    public function index(Request $request)
    {
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $booksQuery = LibraryBook::with('school');

        if ($schoolId) {
            $booksQuery->where('school_id', $schoolId);
        }

        $books = $booksQuery->latest()->get();

        return view('admin.library.index', compact('books', 'schoolId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'isbn' => 'required|string|max:50|unique:library_books,isbn',
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'publisher' => 'nullable|string|max:255',
            'stock' => 'required|integer|min:1',
            'category' => 'required|string|max:100',
            'ebook_file' => 'nullable|file|mimes:pdf|max:20480',
        ]);

        $schoolId = auth()->user()?->getEffectiveSchoolId();
        $targetSchoolId = $schoolId ?: ($request->school_id ?? School::first()?->id ?? 1);

        $validated['school_id'] = $targetSchoolId;
        $validated['available_stock'] = $validated['stock'];
        $validated['publisher'] = $request->publisher ?: 'Penerbit SIT Robbani Press';

        if ($request->hasFile('ebook_file')) {
            $path = $request->file('ebook_file')->store('library_ebooks', 'public');
            $validated['file_path'] = $path;
        }

        $book = LibraryBook::create($validated);

        try {
            AuditLog::create([
                'user_id' => auth()->id() ?? 1,
                'action' => 'INPUT BUKU PERPUS',
                'model_type' => 'LibraryBook',
                'model_id' => $book->id,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Throwable $e) {}

        return redirect()->back()->with('success', '✓ Buku Baru Perpustakaan Berhasil Ditambahkan ke Katalog!');
    }

    public function destroy($id)
    {
        $book = LibraryBook::findOrFail($id);
        $schoolId = auth()->user()?->getEffectiveSchoolId();
        if ($schoolId && $book->school_id != $schoolId) {
            return redirect()->back()->with('error', 'Akses ditolak: Anda tidak berwenang menghapus buku dari katalog unit ini.');
        }

        $book->delete();
        return redirect()->back()->with('success', '✓ Buku perpustakaan berhasil dihapus.');
    }
}
