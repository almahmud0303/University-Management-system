<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\BookIssue;
use App\Models\Book;
use App\Models\Student;
use Illuminate\Http\Request;

class BookIssueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookIssues = BookIssue::with(['book', 'student.user'])
            ->latest()
            ->paginate(15);

        return view('staff.book-issues.index', compact('bookIssues'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::where('is_available', true)->get();
        $students = Student::with('user')->get();

        return view('staff.book-issues.create', compact('books', 'students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'book_id' => 'required|exists:books,id',
            'student_id' => 'required|exists:students,id',
            'issue_date' => 'required|date',
            'return_date' => 'required|date|after:issue_date',
        ]);

        $bookIssue = BookIssue::create([
            'book_id' => $request->book_id,
            'student_id' => $request->student_id,
            'issue_date' => $request->issue_date,
            'return_date' => $request->return_date,
            'status' => 'issued',
        ]);

        // Update book availability
        $book = Book::find($request->book_id);
        $book->update(['is_available' => false]);

        return redirect()->route('staff.book-issues.index')
            ->with('success', 'Book issued successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(BookIssue $bookIssue)
    {
        $bookIssue->load(['book', 'student.user']);
        return view('staff.book-issues.show', compact('bookIssue'));
    }

    /**
     * Approve a book issue request.
     */
    public function approve(BookIssue $bookIssue)
    {
        $bookIssue->update(['status' => 'approved']);
        
        return redirect()->back()
            ->with('success', 'Book issue approved successfully.');
    }

    /**
     * Reject a book issue request.
     */
    public function reject(BookIssue $bookIssue)
    {
        $bookIssue->update(['status' => 'rejected']);
        
        return redirect()->back()
            ->with('success', 'Book issue rejected.');
    }

    /**
     * Return a book.
     */
    public function return(BookIssue $bookIssue)
    {
        $bookIssue->update([
            'status' => 'returned',
            'return_date' => now(),
        ]);

        // Update book availability
        $book = $bookIssue->book;
        $book->update(['is_available' => true]);

        return redirect()->back()
            ->with('success', 'Book returned successfully.');
    }

    /**
     * Renew a book issue.
     */
    public function renew(BookIssue $bookIssue)
    {
        $newReturnDate = now()->addDays(30); // Extend by 30 days
        
        $bookIssue->update([
            'return_date' => $newReturnDate,
            'renewal_count' => ($bookIssue->renewal_count ?? 0) + 1,
        ]);

        return redirect()->back()
            ->with('success', 'Book renewed successfully.');
    }
}
