@extends('layouts.app')

@section('title', 'Verify Customer Documents — Admin')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">Customer Verification Queue</h1>
                <p class="text-muted mb-0">Review Driving Licenses, Aadhaar cards and verify driver identity.</p>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header-custom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="mb-0"><i class="fas fa-id-card me-2 text-primary"></i> Verification Requests ({{ $documents->total() }})</h5>
                <form action="{{ route('admin.documents.index') }}" method="GET">
                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </form>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Customer</th>
                                <th>Doc Type</th>
                                <th>File</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                                <tr>
                                    <td>
                                        <div class="fw-bold">{{ $doc->user->name }}</div>
                                        <small class="text-muted">{{ $doc->user->email }} | {{ $doc->user->phone ?? 'No phone' }}</small>
                                    </td>
                                    <td class="fw-bold text-dark">{{ $doc->type }}</td>
                                    <td>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-info">
                                            <i class="fas fa-file-download me-1"></i> View Document
                                        </a>
                                    </td>
                                    <td class="small">{{ $doc->created_at->format('d M Y') }}</td>
                                    <td>
                                        <span class="badge-status {{ $doc->status_badge }}">
                                            {{ $doc->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($doc->status === 'Pending')
                                            <div class="d-flex gap-2">
                                                <form action="{{ route('admin.documents.approve', $doc->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">Approve</button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $doc->id }}">Reject</button>
                                            </div>

                                            <!-- Reject Reason Modal -->
                                            <div class="modal fade" id="rejectModal{{ $doc->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <form action="{{ route('admin.documents.reject', $doc->id) }}" method="POST">
                                                            @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Reject Document</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label class="form-label small fw-bold">Rejection Reason</label>
                                                                <textarea name="rejection_reason" class="form-control" rows="3" required placeholder="e.g. Blurred image, expired license..."></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger">Confirm Rejection</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="small text-muted">Verified by Admin</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">No document verification records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $documents->links() }}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
