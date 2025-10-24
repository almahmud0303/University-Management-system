<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
        return view('admin.notices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,academic,exam,fee,library,event',
            'priority' => 'required|in:low,medium,high,urgent',
            'target_role' => 'nullable|in:student,teacher,staff,admin,all',
            'publish_date' => 'required|date|after_or_equal:today',
            'expiry_date' => 'nullable|date|after:publish_date',
            'is_published' => 'boolean',
            'is_pinned' => 'boolean',
        ]);

        Notice::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'target_role' => $request->target_role ?? 'all',
            'publish_date' => $request->publish_date,
            'expiry_date' => $request->expiry_date,
            'is_published' => $request->has('is_published'),
            'is_pinned' => $request->has('is_pinned'),
        ]);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice created successfully.');
    }

    public function show(Notice $notice)
    {
        $notice->load('user');
        return view('admin.notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
    }

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:general,academic,exam,fee,library,event',
            'priority' => 'required|in:low,medium,high,urgent',
            'target_role' => 'nullable|in:student,teacher,staff,admin,all',
            'publish_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:publish_date',
            'is_published' => 'boolean',
            'is_pinned' => 'boolean',
        ]);

        $notice->update([
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'priority' => $request->priority,
            'target_role' => $request->target_role ?? 'all',
            'publish_date' => $request->publish_date,
            'expiry_date' => $request->expiry_date,
            'is_published' => $request->has('is_published'),
            'is_pinned' => $request->has('is_pinned'),
        ]);

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
        $notice->delete();
        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }

    public function publish(Notice $notice)
    {
        $notice->update(['is_published' => true]);
        return redirect()->back()
            ->with('success', 'Notice published successfully.');
    }
}