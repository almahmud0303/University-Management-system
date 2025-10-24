<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    /**
     * Display a listing of notices for staff.
     */
    public function index(Request $request)
    {
        $staff = auth()->user()->staff;
        
        $query = Notice::where(function($q) use ($staff) {
            $q->where('target_role', 'staff')
              ->orWhere('target_role', 'all');
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
        
        return view('staff.notices.index', compact('notices'));
    }
    
    /**
     * Display the specified notice.
     */
    public function show(Notice $notice)
    {
        $staff = auth()->user()->staff;
        
        // Check if notice is accessible to staff
        $isAccessible = $notice->is_published && (
            $notice->target_role === 'staff' ||
            $notice->target_role === 'all'
        );
        
        if (!$isAccessible) {
            abort(403, 'You do not have permission to view this notice.');
        }
        
        return view('staff.notices.show', compact('notice'));
    }
}