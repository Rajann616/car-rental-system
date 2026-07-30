<?php

namespace App\Notifications;

use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DocumentStatusNotification extends Notification
{
    use Queueable;

    protected Document $document;

    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $isApproved = $this->document->status === 'Approved';
        
        return [
            'document_id' => $this->document->id,
            'title' => $isApproved ? 'Document Approved! ✅' : 'Document Verification Failed ❌',
            'message' => $isApproved 
                ? "Your {$this->document->type} has been verified and approved."
                : "Your {$this->document->type} was rejected. Reason: " . ($this->document->rejection_reason ?? 'Invalid document'),
            'icon' => $isApproved ? 'fa-check-circle' : 'fa-times-circle',
            'color' => $isApproved ? 'text-success' : 'text-danger',
            'action_url' => route('customer.documents.index'),
        ];
    }
}
