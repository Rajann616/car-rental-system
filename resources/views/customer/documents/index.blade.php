@extends('layouts.app')

@section('title', 'ID Verification Documents — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        
        <!-- Header Banner Card -->
        <div class="mb-4" data-aos="fade-down">
            <div class="p-4 p-md-5 rounded-4 text-white shadow-lg position-relative overflow-hidden" 
                 style="background: linear-gradient(135deg, #0a1628 0%, #153663 50%, #1a4a8a 100%); border: 1px solid rgba(255,255,255,0.1);">
                <div class="row align-items-center position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <span class="badge bg-warning bg-opacity-25 text-warning border border-warning border-opacity-50 rounded-pill px-3 py-1 mb-2 small fw-bold">
                            <i class="fas fa-shield-alt me-1"></i> Secure Driver Verification
                        </span>
                        <h1 class="fw-bold text-white font-display fs-2 mb-2">ID Verification & Documents</h1>
                        <p class="text-white-50 mb-0 max-w-2xl">
                            Upload your Driving License or Govt ID for instant verification. Required to unlock key pickup for all AutoLux vehicles.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-light rounded-pill px-4 fw-medium">
                            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            
            <!-- Left Column: Upload Card -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                    <div class="card-header-custom bg-white p-4 border-bottom">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-file-upload me-2 text-primary"></i> Upload Verification Document
                        </h5>
                    </div>
                    <div class="card-body-custom p-4">
                        <form action="{{ route('customer.documents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Document Type Selector -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase mb-2">Document Type *</label>
                                <select name="type" class="form-select border-2 py-2" required>
                                    <option value="Driving License">Driving License (DL)</option>
                                    <option value="Aadhaar Card">Aadhaar Card</option>
                                    <option value="PAN Card">PAN Card</option>
                                </select>
                            </div>

                            <!-- File Upload Area -->
                            <div class="mb-4">
                                <label class="form-label small fw-bold text-muted text-uppercase mb-2">Upload File (Max 5MB) *</label>
                                <div class="p-4 border-2 border-dashed rounded-4 text-center bg-light position-relative">
                                    <i class="fas fa-cloud-arrow-up text-primary display-5 mb-2"></i>
                                    <h6 class="fw-bold text-dark mb-1">Choose Photo or PDF Document</h6>
                                    <p class="small text-muted mb-3">Accepted formats: JPG, PNG, WEBP, PDF</p>
                                    <input type="file" name="document_file" class="form-control" accept="image/*,.pdf" required>
                                </div>
                            </div>

                            <!-- Document Upload Instructions -->
                            <div class="p-3 bg-light rounded-3 mb-4 small text-muted">
                                <div class="fw-bold text-dark mb-1"><i class="fas fa-info-circle text-primary me-1"></i> Upload Checklist:</div>
                                <ul class="mb-0 ps-3">
                                    <li>Ensure document text and photo are clearly visible.</li>
                                    <li>License must be valid and unexpired.</li>
                                    <li>256-Bit encrypted & stored securely.</li>
                                </ul>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-pill w-100 py-3 fw-bold shadow-sm" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">
                                <i class="fas fa-paper-plane me-2"></i> Submit for Instant Verification
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Document Status Queue -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="dashboard-card border-0 shadow-sm rounded-4 bg-white overflow-hidden h-100">
                    <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                        <h5 class="fw-bold mb-0 text-dark">
                            <i class="fas fa-folder-open me-2 text-primary"></i> Verification Status Log
                        </h5>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">{{ $documents->count() }} Files</span>
                    </div>
                    <div class="card-body-custom p-4">
                        @if($documents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>File Name</th>
                                            <th>Uploaded</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($documents as $doc)
                                            <tr>
                                                <td class="fw-bold text-dark">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <i class="fas {{ $doc->type === 'Driving License' ? 'fa-id-card' : 'fa-file-lines' }} text-primary fs-5"></i>
                                                        {{ $doc->type }}
                                                    </div>
                                                </td>
                                                <td class="small text-muted" style="max-width: 140px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    {{ $doc->file_name }}
                                                </td>
                                                <td class="small text-muted">{{ $doc->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge-status {{ $doc->status_badge }}">
                                                        {{ $doc->status }}
                                                    </span>
                                                    @if($doc->rejection_reason)
                                                        <div class="small text-danger mt-1">{{ $doc->rejection_reason }}</div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ asset('storage/' . $doc->file_path) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                                        <i class="fas fa-eye me-1"></i> View
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-4" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                                        <i class="fas fa-id-card display-4"></i>
                                    </div>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">No Documents Uploaded Yet</h5>
                                <p class="text-muted mx-auto mb-0" style="max-width: 400px;">
                                    Upload your Driving License using the form on the left to complete your driver verification.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
