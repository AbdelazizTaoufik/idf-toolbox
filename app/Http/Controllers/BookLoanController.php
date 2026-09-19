<?php

namespace App\Http\Controllers;

use App\Models\BookLoan;
use App\Models\User;
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

    public function adminIndex(Request $request)
    {
        $query = BookLoan::with('user')->whereNull('returned_at');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $openLoans = $query->orderBy('loaned_at')->get();

        $userGroups = $openLoans->groupBy('user_id')
            ->map(fn ($loans) => [
                'user' => $loans->first()->user,
                'loans' => $loans,
            ])
            ->sortBy(fn ($group) => $group['loans']->min('loaned_at'))
            ->values();

        return view('admin.book-loans', compact('userGroups'));
    }

    public function adminHistory(Request $request)
    {
        $query = BookLoan::with('user')->whereNotNull('returned_at');

        if ($request->filled('user')) {
            $search = $request->input('user');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('loaned_from')) {
            $query->whereDate('loaned_at', '>=', $request->input('loaned_from'));
        }

        if ($request->filled('loaned_to')) {
            $query->whereDate('loaned_at', '<=', $request->input('loaned_to'));
        }

        if ($request->filled('returned_from')) {
            $query->whereDate('returned_at', '>=', $request->input('returned_from'));
        }

        if ($request->filled('returned_to')) {
            $query->whereDate('returned_at', '<=', $request->input('returned_to'));
        }

        $bookLoans = $query->orderByDesc('returned_at')->paginate(10)->withQueryString();
        $users = User::orderBy('name')->get();

        return view('admin.book-loans-history', compact('bookLoans', 'users'));
    }

    public function adminPhoto(BookLoan $bookLoan, string $type)
    {
        abort_unless(in_array($type, ['loan', 'return'], true), 404);

        $path = $type === 'loan' ? $bookLoan->loan_photo_path : $bookLoan->return_photo_path;

        abort_if(!$path || !Storage::disk('local')->exists($path), 404);

        return Storage::disk('local')->response($path);
    }
}
