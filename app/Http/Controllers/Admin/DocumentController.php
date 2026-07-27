<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display document verification queue for admin.
     */
    public function index(Request $request)
    {
        $query = Document::with(['user', 'verifier']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $documents = $query->latest()->paginate(10)->withQueryString();

        return view('admin.documents.index', compact('documents'));
    }

    /**
     * Approve customer document.
     */
    public function approve($id)
    {
        $doc = Document::findOrFail($id);

        $doc->update([
            'status' => 'Approved',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'rejection_reason' => null,
        ]);

        return back()->with('success', "Document for {$doc->user->name} approved successfully.");
    }

    /**
     * Reject customer document with reason.
     */
    public function reject(Request $request, $id)
    {
        $doc = Document::findOrFail($id);

        $request->validate([
            'rejection_reason' => 'required|string|max:255',
        ]);

        $doc->update([
            'status' => 'Rejected',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        return back()->with('success', "Document rejected with reason.");
    }
}
