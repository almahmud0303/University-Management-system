<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Display a listing of notices for teachers.
     */
    public function index(Request $request)
    {
        $teacher = auth()->user()->teacher;
        
        $query = Notice::where(function($q) use ($teacher) {
            $q->where('target_role', 'teacher')
              ->orWhere('target_role', 'all')
              ->orWhere('department_id', $teacher->department_id);
        })->where('is_published', true);
        
        // Apply search filter
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }
        
        // Apply priority filter
        if ($request->has('priority') && $request->priority) {
            $query->where('priority', $request->priority);
        }
        
        $notices = $query->latest()->paginate(10);
        
        return view('teacher.notices.index', compact('notices'));
    }
    
    /**
     * Display the specified notice.
     */
    public function show(Notice $notice)
    {
        $teacher = auth()->user()->teacher;
        
        // Check if notice is accessible to teacher
        $isAccessible = $notice->is_published && (
            $notice->target_role === 'teacher' ||
            $notice->target_role === 'all' ||
            $notice->department_id === $teacher->department_id
        );
        
        if (!$isAccessible) {
            abort(403, 'You do not have permission to view this notice.');
        }
        
        return view('teacher.notices.show', compact('notice'));
    }
}
