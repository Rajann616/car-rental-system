@extends('layouts.app')

@section('title', 'Upload ID Documents — AutoLux')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">ID Verification Documents</h1>
                <p class="text-muted mb-0">Upload your Driving License or Govt ID for instant verification.</p>
            </div>
            <div>
                <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-secondary btn-sm rounded-pill">
                    <i class="fas fa-arrow-left me-1"></i> Dashboard
                </a>
            </div>
        </div>

        <div class="row g-4">
            <!-- Left Column: Upload Form -->
            <div class="col-lg-5" data-aos="fade-right">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-file-upload me-2 text-primary"></i> Upload New Document</h5>
                    </div>
                    <div class="card-body-custom">
                        <form action="{{ route('customer.documents.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label fw-semibold">Document Type *</label>
                                <select name="type" class="form-select" required>
                                    <option value="Driving License">Driving License (DL)</option>
                                    <option value="Aadhaar Card">Aadhaar Card</option>
                                    <option value="PAN Card">PAN Card</option>
                                </select>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-semibold">Select File (JPG, PNG or PDF, max 5MB) *</label>
                                <input type="file" name="document_file" class="form-control" accept="image/*,.pdf" required>
                            </div>

                            <button type="submit" class="btn btn-primary rounded-pill w-100 fw-bold">
                                <i class="fas fa-upload me-2"></i> Submit for Verification
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Document List -->
            <div class="col-lg-7" data-aos="fade-left">
                <div class="dashboard-card">
                    <div class="card-header-custom">
                        <h5><i class="fas fa-folder-open me-2 text-primary"></i> Uploaded Document Status</h5>
                    </div>
                    <div class="card-body-custom">
                        @if($documents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-modern align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th>Document Type</th>
                                            <th>File Name</th>
                                            <th>Date Uploaded</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($documents as $doc)
                                            <tr>
                                                <td class="fw-bold">{{ $doc->type }}</td>
                                                <td class="small text-muted">{{ $doc->file_name }}</td>
                                                <td class="small">{{ $doc->created_at->format('d M Y') }}</td>
                                                <td>
                                                    <span class="badge-status {{ $doc->status_badge }}">
                                                        {{ $doc->status }}
                                                    </span>
                                                    @if($doc->rejection_reason)
                                                        <div class="small text-danger mt-1">{{ $doc->rejection_reason }}</div>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <p class="text-muted mb-0">No documents uploaded yet. Upload your Driving License to start booking.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
