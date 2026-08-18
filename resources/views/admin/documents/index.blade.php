@extends('layouts.admin')

@section('title', 'Customer Verification Queue — Admin')
@section('page_title', 'ID Verifications')

@section('content')
<div class="container-fluid px-0">
        
        <!-- Header Banner Card -->
        <!-- Unified Liquid Glass Header Banner -->
        <div class="mb-4" data-aos="fade-down">
            <div class="liquid-glass-hero text-white">
                <div class="liquid-glow-orb-1"></div>
                <div class="liquid-glow-orb-2"></div>
                <div class="row align-items-center position-relative g-3" style="z-index: 2;">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <span class="badge liquid-badge-gold rounded-pill px-3 py-1 fs-7 fw-semibold">
                                <i class="fas fa-user-shield me-1"></i> ID Verification Stream
                            </span>
                        </div>
                        <h1 class="fw-bold text-white font-display fs-3 mb-1">Customer Verification Queue</h1>
                        <p class="text-white-50 mb-0 max-w-2xl small">
                            Review customer Driving Licenses, Aadhaar Cards, and PAN Cards to approve driver verification status.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-medium shadow-xs">
                            <i class="fas fa-arrow-left me-2"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Documents Queue Master Liquid Card -->
        <div class="liquid-card border-0 shadow-sm overflow-hidden" data-aos="fade-up">
            <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fas fa-id-card me-2 text-primary"></i> Verification Requests ({{ $documents->total() }})
                </h5>
                <form action="{{ route('admin.documents.index') }}" method="GET">
                    <select name="status" class="form-select form-select-sm border-2" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending Approval</option>
                        <option value="Approved" {{ request('status') == 'Approved' ? 'selected' : '' }}>Approved</option>
                        <option value="Rejected" {{ request('status') == 'Rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </form>
            </div>
            <div class="card-body-custom p-4">
                <!-- Desktop Table View -->
                <div class="desktop-table-container table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Customer Details</th>
                                <th>Doc Type</th>
                                <th>File Preview</th>
                                <th>Submitted Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($documents as $doc)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark fs-6">{{ $doc->user->name }}</div>
                                        <small class="text-muted">{{ $doc->user->email }} | {{ $doc->user->phone ?? 'No Phone' }}</small>
                                    </td>
                                    <td class="fw-bold text-dark">
                                        <i class="fas {{ $doc->type === 'Driving License' ? 'fa-id-card text-primary' : 'fa-file-lines text-secondary' }} me-1"></i>
                                        {{ $doc->type }}
                                    </td>
                                    <td>
                                        <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                            <i class="fas fa-eye me-1"></i> View Document
                                        </a>
                                    </td>
                                    <td class="small text-muted">{{ $doc->created_at->format('d M Y, h:i A') }}</td>
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
                                                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                        <i class="fas fa-check me-1"></i> Approve
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $doc->id }}">
                                                    Reject
                                                </button>
                                            </div>

                                            <!-- Reject Modal -->
                                            <div class="modal fade" id="rejectModal{{ $doc->id }}" tabindex="-1">
                                                <div class="modal-dialog">
                                                    <div class="modal-content rounded-4">
                                                        <form action="{{ route('admin.documents.reject', $doc->id) }}" method="POST">
                                                             @csrf
                                                            <div class="modal-header">
                                                                <h5 class="modal-title fw-bold">Reject Document</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <label class="form-label small fw-bold">Rejection Reason *</label>
                                                                <textarea name="rejection_reason" class="form-control border-2" rows="3" required placeholder="e.g. Blurred photo, expired license..."></textarea>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                                                                <button type="submit" class="btn btn-danger rounded-pill px-4">Confirm Rejection</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="small text-muted"><i class="fas fa-check-circle text-success me-1"></i> Verified</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">No document verification records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card Container (<= 767px) -->
                <div class="mobile-card-container">
                    @forelse($documents as $doc)
                        <div class="card border rounded-4 shadow-sm p-3 mb-2 bg-white">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark fs-6">{{ $doc->user->name }}</span>
                                <span class="badge-status {{ $doc->status_badge }}">{{ $doc->status }}</span>
                            </div>
                            <div class="small text-muted mb-2">
                                <div><i class="fas fa-envelope text-primary me-1"></i> {{ $doc->user->email }}</div>
                                <div><i class="fas fa-id-card text-primary me-1"></i> {{ $doc->type }} · {{ $doc->created_at->format('d M Y') }}</div>
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top gap-2 flex-wrap">
                                <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                                    <i class="fas fa-eye me-1"></i> View
                                </a>
                                @if($doc->status === 'Pending')
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.documents.approve', $doc->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                Approve
                                            </button>
                                        </form>
                                        <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#rejectModal{{ $doc->id }}">
                                            Reject
                                        </button>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No document verification records found.</div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $documents->links() }}
                </div>
            </div>
    </div>
</div>
@endsection
