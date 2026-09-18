<?php

namespace App\Http\Controllers;

use App\Models\BookLoan;
use App\Services\BookLoanPhotoStorage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookLoanController extends Controller
{
    public function __construct(private BookLoanPhotoStorage $photoStorage)
    {
    }

    public function index()
    {
        $bookLoans = BookLoan::where('user_id', Auth::id())
            ->whereNull('returned_at')
            ->orderByDesc('loaned_at')
            ->get();

        return view('book-loans-index', compact('bookLoans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'note' => 'nullable|string|max:1000',
            'photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        BookLoan::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'note' => $validated['note'] ?? null,
            'loan_photo_path' => $this->photoStorage->store($request->file('photo')),
            'loaned_at' => now(),
        ]);

        return redirect()->route('book-loans.index')
            ->with('success', 'Buch wurde erfolgreich als ausgeliehen vermerkt.');
    }

    public function returnBook(Request $request, BookLoan $bookLoan)
    {
        abort_if($bookLoan->user_id !== Auth::id(), 403);
        abort_if($bookLoan->isReturned(), 404);

        $validated = $request->validate([
            'return_photo' => 'required|image|mimes:jpeg,jpg,png,webp|max:10240',
        ]);

        $bookLoan->update([
            'return_photo_path' => $this->photoStorage->store($request->file('return_photo')),
            'returned_at' => now(),
        ]);

        return redirect()->route('book-loans.index')
            ->with('success', 'Buch wurde erfolgreich zurückgegeben.');
    }

    public function photo(BookLoan $bookLoan, string $type)
    {
        abort_if($bookLoan->user_id !== Auth::id(), 403);
        abort_unless(in_array($type, ['loan', 'return'], true), 404);

        $path = $type === 'loan' ? $bookLoan->loan_photo_path : $bookLoan->return_photo_path;

        abort_if(!$path || !Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }
}
