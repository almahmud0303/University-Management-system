<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookIssue;
use Illuminate\Http\Request;

class LibraryController extends Controller
{
    /**
     * Display the library dashboard.
     */
    public function index(Request $request)
    {
        $student = auth()->user()->student;
        
        // Get student's book issues
        $myBookIssues = BookIssue::where('student_id', $student->id)
            ->with(['book'])
            ->latest()
            ->get();
        
        // Get available books
        $query = Book::where('is_active', true)->where('available_copies', '>', 0);
        
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        
        // Apply category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        $availableBooks = $query->latest()->get();
        
        // Get statistics
        $activeBookIssues = $myBookIssues->where('status', 'issued');
        $returnedBooks = $myBookIssues->where('status', 'returned');
        $overdueBooks = $myBookIssues->where('status', 'overdue');
        $totalBooks = Book::where('is_active', true)->count();
        
        return view('student.library.index', compact(
            'myBookIssues', 
            'availableBooks', 
            'activeBookIssues', 
            'returnedBooks', 
            'overdueBooks', 
            'totalBooks'
        ));
    }
    
    /**
     * Display available books.
     */
    public function books(Request $request)
    {
        $query = Book::where('is_active', true)->where('available_copies', '>', 0);
        
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }
        
        // Apply category filter
        if ($request->has('category') && $request->category) {
            $query->where('category', $request->category);
        }
        
        $books = $query->latest()->paginate(12);
        
        $categories = Book::whereNotNull('category')->distinct()->pluck('category');
        
        return view('student.library.books', compact('books', 'categories'));
    }
    
    /**
     * Request a book.
     */
    public function requestBook(Book $book)
    {
        $student = auth()->user()->student;
        
        // Check if book is available
        if ($book->available_copies <= 0) {
            return back()->with('error', 'This book is not available for borrowing.');
        }
        
        // Check if student already has this book
        $existingIssue = BookIssue::where('student_id', $student->id)
            ->where('book_id', $book->id)
            ->whereIn('status', ['issued', 'requested'])
            ->first();
            
        if ($existingIssue) {
            return back()->with('error', 'You already have this book or have requested it.');
        }
        
        // Create book issue request
        BookIssue::create([
            'book_id' => $book->id,
            'student_id' => $student->id,
            'issue_date' => now(),
            'due_date' => now()->addDays(14), // 14 days loan period
            'status' => 'requested',
        ]);
        
        return back()->with('success', 'Book request submitted successfully.');
    }
    
    /**
     * Return a book.
     */
    public function returnBook(BookIssue $bookIssue)
    {
        $student = auth()->user()->student;
        
        // Check if the book issue belongs to the student
        if ($bookIssue->student_id !== $student->id) {
            abort(403, 'Unauthorized access to this book issue.');
        }
        
        // Check if book is currently issued
        if ($bookIssue->status !== 'issued') {
            return back()->with('error', 'This book is not currently issued.');
        }
        
        // Update book issue status
        $bookIssue->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);
        
        // Update book available copies
        $bookIssue->book->increment('available_copies');
        
        return back()->with('success', 'Book returned successfully.');
    }
}
