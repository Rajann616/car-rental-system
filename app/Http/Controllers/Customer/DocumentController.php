<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    /**
     * Display listing of customer uploaded documents.
     */
    public function index()
    {
        $documents = auth()->user()->documents()->latest()->get();
        return view('customer.documents.index', compact('documents'));
    }

    /**
     * Store uploaded document (DL, Aadhaar, PAN).
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:Driving License,Aadhaar Card,PAN Card',
            'document_file' => 'required|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $file = $request->file('document_file');
        $fileName = $file->getClientOriginalName();
        $filePath = $file->store('documents/' . auth()->id(), 'public');

        $doc = Document::create([
            'user_id' => auth()->id(),
            'type' => $request->type,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'status' => 'Pending',
        ]);

        // Send In-App Notification to All Admins
        try {
            $admins = \App\Models\User::where('role', 'admin')->get();
            $customerName = auth()->user()->name;
            foreach ($admins as $admin) {
                $admin->notify(new \App\Notifications\AdminNotification(
                    'New Document Uploaded 📄',
                    "Customer {$customerName} uploaded {$request->type} for verification.",
                    route('admin.documents.index'),
                    'fa-id-card',
                    'text-warning'
                ));
            }
        } catch (\Exception $e) {
            \Log::warning('Admin document notification failed: ' . $e->getMessage());
        }

        return back()->with('success', "Your {$request->type} has been uploaded successfully for admin verification!");
    }
}
