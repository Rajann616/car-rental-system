@extends('layouts.customer')

@section('title', 'ID Verification Documents — AutoLux')
@section('page_title', 'Documents')

@push('styles')
<style>
    /* Liquid Glass Aesthetic Theme */
    .dashboard-hero-card {
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.12) 0%, rgba(255, 255, 255, 0.03) 100%),
                    linear-gradient(125deg, #071322 0%, #0c2547 45%, #143b73 100%);
        backdrop-filter: blur(24px) saturate(190%);
        -webkit-backdrop-filter: blur(24px) saturate(190%);
        border: 1px solid rgba(255, 255, 255, 0.22);
        border-radius: 1.25rem;
        box-shadow: 0 20px 45px -15px rgba(3, 10, 22, 0.5), 
                    inset 0 1px 1px rgba(255, 255, 255, 0.4);
        position: relative;
        overflow: hidden;
    }
    
    .dashboard-hero-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, 
            rgba(255, 255, 255, 0) 0%, 
            rgba(255, 255, 255, 0.6) 30%, 
            rgba(255, 255, 255, 0.95) 50%, 
            rgba(255, 255, 255, 0.6) 70%, 
            rgba(255, 255, 255, 0) 100%);
        z-index: 4;
    }

    .hero-glow-1 {
        position: absolute; width: 280px; height: 280px;
        background: radial-gradient(circle, rgba(255, 122, 0, 0.35) 0%, rgba(245, 158, 11, 0.1) 60%, rgba(0,0,0,0) 80%);
        top: -80px; right: -50px; filter: blur(40px); border-radius: 50%;
        animation: liquidMorph 12s infinite ease-in-out alternate;
    }
    .hero-glow-2 {
        position: absolute; width: 240px; height: 240px;
        background: radial-gradient(circle, rgba(37, 99, 235, 0.4) 0%, rgba(56, 189, 248, 0.1) 60%, rgba(0,0,0,0) 80%);
        bottom: -60px; left: 20%; filter: blur(45px); border-radius: 50%;
        animation: liquidMorph 15s infinite ease-in-out alternate-reverse;
    }
    @keyframes liquidMorph {
        0% { transform: scale(1) translate(0, 0); }
        50% { transform: scale(1.15) translate(12px, -12px); }
        100% { transform: scale(0.9) translate(-8px, 8px); }
    }

    .liquid-glass-card {
        background: rgba(255, 255, 255, 0.96);
        backdrop-filter: blur(20px) saturate(180%);
        -webkit-backdrop-filter: blur(20px) saturate(180%);
        border: 1px solid rgba(226, 232, 240, 0.9);
        border-radius: 1.25rem;
        box-shadow: 0 10px 30px -10px rgba(15, 23, 42, 0.06);
        transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }

    .liquid-glass-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0; height: 3px;
        background: linear-gradient(90deg, #ff7a00, #2563eb);
        opacity: 0;
        transition: opacity 0.35s ease;
    }

    .liquid-glass-card:hover::before {
        opacity: 1;
    }

    .glass-badge-gold {
        background: rgba(245, 158, 11, 0.18);
        backdrop-filter: blur(12px);
        -webkit-backdrop-filter: blur(12px);
        color: #f59e0b;
        border: 1px solid rgba(245, 158, 11, 0.35);
    }

    .glass-badge-dark {
        background: rgba(15, 23, 42, 0.65);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        color: #ffffff;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Upload Dropzone */
    .liquid-dropzone {
        border: 2px dashed rgba(37, 99, 235, 0.35);
        background: linear-gradient(180deg, rgba(248, 250, 252, 0.9) 0%, rgba(239, 246, 255, 0.6) 100%);
        border-radius: 1rem;
        padding: 1.75rem 1.5rem;
        text-align: center;
        transition: all 0.3s ease;
        cursor: pointer;
        position: relative;
    }

    .liquid-dropzone:hover, .liquid-dropzone.dragover {
        border-color: #2563eb;
        background: linear-gradient(180deg, rgba(239, 246, 255, 0.95) 0%, rgba(219, 234, 254, 0.7) 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 20px -5px rgba(37, 99, 235, 0.18);
    }

    .dropzone-icon {
        width: 56px; height: 56px;
        background: linear-gradient(135deg, rgba(37, 99, 235, 0.15), rgba(37, 99, 235, 0.05));
        color: #2563eb;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 0.75rem;
        transition: transform 0.3s ease;
    }

    .liquid-dropzone:hover .dropzone-icon {
        transform: scale(1.1) rotate(6deg);
    }

    /* Status Glass Pills */
    .status-pill-approved {
        background: rgba(16, 185, 129, 0.12);
        color: #059669;
        border: 1px solid rgba(16, 185, 129, 0.3);
        padding: 0.35rem 0.85rem;
        border-radius: 50rem;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .status-pill-pending {
        background: rgba(245, 158, 11, 0.12);
        color: #d97706;
        border: 1px solid rgba(245, 158, 11, 0.3);
        padding: 0.35rem 0.85rem;
        border-radius: 50rem;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .status-pill-rejected {
        background: rgba(239, 68, 68, 0.12);
        color: #dc2626;
        border: 1px solid rgba(239, 68, 68, 0.3);
        padding: 0.35rem 0.85rem;
        border-radius: 50rem;
        font-weight: 600;
        font-size: 0.8rem;
        display: inline-flex;
        align-items: center;
        gap: 0.4rem;
    }

    .pulse-dot-green {
        width: 8px; height: 8px;
        background-color: #10b981;
        border-radius: 50%;
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
        animation: pulseGreen 1.8s infinite;
    }
    @keyframes pulseGreen {
        0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
        70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
        100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
    }

    .btn-liquid-primary {
        background: linear-gradient(135deg, #ff7a00, #ea580c);
        border: none;
        box-shadow: 0 4px 15px rgba(234, 88, 12, 0.35);
        color: #ffffff;
        transition: all 0.3s ease;
    }

    .btn-liquid-primary:hover {
        box-shadow: 0 8px 22px rgba(234, 88, 12, 0.5);
        transform: translateY(-2px);
        color: #ffffff;
    }

    .table-liquid th {
        background: #f8fafc;
        color: #64748b;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        border-bottom: 1px solid #e2e8f0;
        padding-top: 0.85rem;
        padding-bottom: 0.85rem;
    }

    .file-preview-card {
        background: #ffffff;
        border: 1px solid rgba(37, 99, 235, 0.25);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
        border-radius: 0.85rem;
    }

    .guide-item-card {
        background: rgba(248, 250, 252, 0.8);
        border: 1px solid rgba(226, 232, 240, 0.8);
        border-radius: 0.85rem;
        transition: all 0.25s ease;
    }

    .guide-item-card:hover {
        background: #ffffff;
        border-color: rgba(37, 99, 235, 0.3);
        box-shadow: 0 4px 14px rgba(15, 23, 42, 0.05);
    }
</style>
@endpush

@section('content')
<section class="dashboard-section pb-5">
    <div class="container-fluid px-0">
        
        <!-- Header Banner Card -->
        <div class="mb-4" data-aos="fade-down">
            <div class="p-3.5 p-md-4 rounded-4 text-white dashboard-hero-card shadow-sm">
                <div class="hero-glow-1"></div>
                <div class="hero-glow-2"></div>

                <div class="row align-items-center position-relative g-3" style="z-index: 2;">
                    <div class="col-lg-8">
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-2">
                            <span class="badge glass-badge-gold rounded-pill px-3 py-1.5 fs-7 fw-bold">
                                <i class="fas fa-shield-check me-1"></i> Identity Verification
                            </span>
                        </div>
                        <h1 class="fw-bold text-white font-display fs-3 mb-1">ID Verification & Documents</h1>
                        <p class="text-white-50 mb-0 max-w-2xl small">
                            Upload your Driving License or Govt ID for instant verification to unlock seamless booking for AutoLux self-drive vehicles.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                        <a href="{{ route('customer.dashboard') }}" class="btn btn-outline-light rounded-pill px-4 py-2 fw-medium shadow-xs">
                            <i class="fas fa-arrow-left me-2"></i> Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- TOP SECTION: Upload Form (Left) & Verification Guidelines (Right) -->
        <div class="row g-4 mb-4">
            
            <!-- Left Card: Upload Form -->
            <div class="col-lg-7" data-aos="fade-right">
                <div class="liquid-glass-card h-100">
                    <div class="p-3.5 px-4 border-bottom bg-white bg-opacity-50 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                                <i class="fas fa-cloud-arrow-up fs-6"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark fs-6">Upload Verification Document</h5>
                                <small class="text-muted fs-7">Submit your govt photo ID for approval</small>
                            </div>
                        </div>
                    </div>

                    <div class="p-4">
                        <form action="{{ route('customer.documents.store') }}" method="POST" enctype="multipart/form-data" id="documentUploadForm">
                            @csrf

                            <div class="row g-3">
                                <!-- Document Type Selection -->
                                <div class="col-md-5">
                                    <label class="form-label small fw-bold text-muted text-uppercase tracking-wider mb-2">Document Type *</label>
                                    <select name="type" class="form-select rounded-3 py-2.5 fw-medium border" required>
                                        <option value="Driving License">Driving License (DL)</option>
                                        <option value="Aadhaar Card">Aadhaar Card</option>
                                        <option value="PAN Card">PAN Card</option>
                                    </select>
                                    <div class="form-text fs-7 text-muted mt-2">
                                        <i class="fas fa-info-circle text-primary me-1"></i> Driving License is required for vehicle key handover.
                                    </div>
                                </div>

                                <!-- File Upload Dropzone -->
                                <div class="col-md-7">
                                    <label class="form-label small fw-bold text-muted text-uppercase tracking-wider mb-2">Upload File (Max 5MB) *</label>
                                    
                                    <div class="liquid-dropzone" id="dropzoneArea" onclick="document.getElementById('fileInput').click()">
                                        <input type="file" name="document_file" id="fileInput" class="d-none" accept="image/*,.pdf" required onchange="handleFileSelect(this)">
                                        
                                        <div id="dropzonePrompt">
                                            <div class="dropzone-icon">
                                                <i class="fas fa-file-circle-plus fs-4"></i>
                                            </div>
                                            <h6 class="fw-bold text-dark mb-1 fs-6">Click or Drag File Here</h6>
                                            <p class="small text-muted mb-0 fs-7">JPG, PNG, WEBP, PDF (Max 5MB)</p>
                                        </div>

                                        <!-- Selected File Preview -->
                                        <div id="filePreview" class="d-none">
                                            <div class="file-preview-card p-2.5 d-flex align-items-center justify-content-between">
                                                <div class="d-flex align-items-center gap-2.5">
                                                    <div id="fileTypeIcon" class="rounded-3 p-2 bg-primary bg-opacity-10 text-primary fs-5">
                                                        <i class="fas fa-file-image"></i>
                                                    </div>
                                                    <div class="text-start">
                                                        <div id="fileNameDisplay" class="fw-bold text-dark fs-7 text-truncate" style="max-width: 150px;">document.pdf</div>
                                                        <div id="fileSizeDisplay" class="text-muted fs-7">1.2 MB</div>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-sm btn-light text-danger rounded-circle p-1.5 border" onclick="clearFileSelection(event)">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 pt-2 border-top text-end">
                                <button type="submit" id="submitBtn" class="btn btn-liquid-primary rounded-pill px-4 py-2.5 fw-bold shadow-sm">
                                    <i class="fas fa-paper-plane me-2"></i> Submit for Verification
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Card: Guidelines & Verification Requirements -->
            <div class="col-lg-5" data-aos="fade-left">
                <div class="liquid-glass-card h-100 p-4">
                    <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-2 text-warning">
                            <i class="fas fa-shield-check fs-6"></i>
                        </div>
                        <div>
                            <h5 class="fw-bold mb-0 text-dark fs-6">Verification Requirements</h5>
                            <small class="text-muted fs-7">Guidelines for instant approval</small>
                        </div>
                    </div>

                    <div class="d-flex flex-column gap-2.5">
                        <div class="guide-item-card p-3 d-flex align-items-start gap-3">
                            <div class="text-success fs-5 mt-0.5"><i class="fas fa-circle-check"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0.5 fs-7">Clear & Unblurred Image</h6>
                                <p class="text-muted mb-0 fs-7">Ensure all text, ID number, and photo are clear and legible.</p>
                            </div>
                        </div>

                        <div class="guide-item-card p-3 d-flex align-items-start gap-3">
                            <div class="text-primary fs-5 mt-0.5"><i class="fas fa-id-badge"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0.5 fs-7">Valid Driver's License</h6>
                                <p class="text-muted mb-0 fs-7">License must be active and not expired at the time of pickup.</p>
                            </div>
                        </div>

                        <div class="guide-item-card p-3 d-flex align-items-start gap-3">
                            <div class="text-info fs-5 mt-0.5"><i class="fas fa-user-lock"></i></div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0.5 fs-7">Privacy & Data Security</h6>
                                <p class="text-muted mb-0 fs-7">Strictly used for driver verification and identity safety.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- BOTTOM SECTION: Full-Width Verification Status Log Table -->
        <div class="row g-4" data-aos="fade-up">
            <div class="col-12">
                <div class="liquid-glass-card">
                    <div class="p-3.5 px-4 border-bottom bg-white bg-opacity-50 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success">
                                <i class="fas fa-folder-check fs-6"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold mb-0 text-dark fs-6">Verification Status Log</h5>
                                <small class="text-muted fs-7">Real-time status of your submitted documents</small>
                            </div>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 py-1 fw-bold fs-7">
                            {{ $documents->count() }} Files Uploaded
                        </span>
                    </div>

                    <div class="p-0">
                        @if($documents->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-liquid align-middle mb-0">
                                    <thead>
                                        <tr>
                                            <th class="ps-4">Document Type</th>
                                            <th>File Name</th>
                                            <th>Uploaded Date</th>
                                            <th>Status</th>
                                            <th class="text-end pe-4">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($documents as $doc)
                                            @php
                                                $ext = strtolower(pathinfo($doc->file_path, PATHINFO_EXTENSION));
                                                $isImg = in_array($ext, ['jpg', 'jpeg', 'png', 'webp']);
                                            @endphp
                                            <tr>
                                                <td class="ps-4 fw-bold text-dark">
                                                    <div class="d-flex align-items-center gap-3">
                                                        @if($isImg)
                                                            <img src="{{ asset('storage/' . $doc->file_path) }}" alt="{{ $doc->type }}" class="rounded-3 border object-fit-cover shadow-xs" style="width: 42px; height: 42px;">
                                                        @else
                                                            <div class="rounded-3 bg-danger bg-opacity-10 text-danger d-flex align-items-center justify-content-center border" style="width: 42px; height: 42px;">
                                                                <i class="fas fa-file-pdf fs-5"></i>
                                                            </div>
                                                        @endif
                                                        <div>
                                                            <div class="fw-bold text-dark fs-7">{{ $doc->type }}</div>
                                                            <small class="text-muted fs-7">{{ strtoupper($ext) }} File</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td class="small text-muted">
                                                    <span class="d-inline-block text-truncate" style="max-width: 220px;" title="{{ $doc->file_name }}">
                                                        {{ $doc->file_name }}
                                                    </span>
                                                </td>
                                                <td class="small text-muted fs-7">
                                                    <i class="far fa-calendar me-1"></i>{{ $doc->created_at->format('d M Y, h:i A') }}
                                                </td>
                                                <td>
                                                    @if(strtolower($doc->status) === 'approved')
                                                        <span class="status-pill-approved">
                                                            <span class="pulse-dot-green"></span> Approved
                                                        </span>
                                                    @elseif(strtolower($doc->status) === 'rejected')
                                                        <span class="status-pill-rejected">
                                                            <i class="fas fa-circle-xmark"></i> Rejected
                                                        </span>
                                                        @if($doc->rejection_reason)
                                                            <div class="small text-danger mt-1 fs-7"><i class="fas fa-info-circle me-1"></i>{{ $doc->rejection_reason }}</div>
                                                        @endif
                                                    @else
                                                        <span class="status-pill-pending">
                                                            <i class="fas fa-spinner fa-spin me-1"></i> Review Pending
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-end pe-4">
                                                    <button type="button" 
                                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1.5 fw-semibold fs-7"
                                                            onclick="previewDocument('{{ asset('storage/' . $doc->file_path) }}', '{{ $doc->type }}', '{{ $doc->file_name }}')">
                                                        <i class="fas fa-eye me-1"></i> Preview
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 my-2">
                                <div class="mb-3">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle p-3.5" style="background: rgba(37, 99, 235, 0.08); color: #2563eb;">
                                        <i class="fas fa-id-card fs-2"></i>
                                    </div>
                                </div>
                                <h6 class="fw-bold text-dark mb-1 fs-6">No Documents Uploaded Yet</h6>
                                <p class="text-muted mx-auto mb-0 fs-7" style="max-width: 360px;">
                                    Upload your Driving License or Govt ID using the form above to complete your driver verification.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Liquid Glass In-Page Document Preview Lightbox Modal -->
<div class="modal fade" id="documentPreviewModal" tabindex="-1" aria-labelledby="documentPreviewModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header p-3 px-4 text-white border-0" style="background: linear-gradient(135deg, #061120 0%, #0a1f3c 50%, #11325d 100%);">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="rounded-circle p-2 bg-white bg-opacity-10 text-warning">
                        <i class="fas fa-file-lines fs-5"></i>
                    </div>
                    <div>
                        <h6 class="modal-title fw-bold text-white mb-0" id="documentModalTitle">Document Preview</h6>
                        <small class="text-white-50 fs-7" id="documentModalSubtitle">AutoLux ID Verification System</small>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-3 text-center bg-dark bg-opacity-10" style="min-height: 380px;">
                <div id="previewImageContainer" class="d-none">
                    <img id="modalPreviewImg" src="" alt="Document Preview" class="img-fluid rounded-3 shadow-sm max-h-500 object-fit-contain">
                </div>
                <div id="previewPdfContainer" class="d-none h-100">
                    <iframe id="modalPreviewPdf" src="" width="100%" height="450px" class="border-0 rounded-3"></iframe>
                </div>
            </div>
            <div class="modal-footer bg-light p-3 border-top justify-content-between">
                <a id="modalDownloadBtn" href="" target="_blank" class="btn btn-outline-secondary rounded-pill px-3 fs-7 fw-semibold">
                    <i class="fas fa-external-link-alt me-1"></i> Open in New Tab
                </a>
                <button type="button" class="btn btn-secondary rounded-pill px-4 fs-7" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function handleFileSelect(input) {
        if (input.files && input.files[0]) {
            const file = input.files[0];
            const fileName = file.name;
            const fileSize = (file.size / (1024 * 1024)).toFixed(2) + ' MB';
            const isPdf = file.type === 'application/pdf' || fileName.toLowerCase().endsWith('.pdf');

            document.getElementById('fileNameDisplay').textContent = fileName;
            document.getElementById('fileSizeDisplay').textContent = fileSize;
            
            const iconContainer = document.getElementById('fileTypeIcon');
            if (isPdf) {
                iconContainer.innerHTML = '<i class="fas fa-file-pdf text-danger"></i>';
            } else {
                iconContainer.innerHTML = '<i class="fas fa-file-image text-primary"></i>';
            }

            document.getElementById('dropzonePrompt').classList.add('d-none');
            document.getElementById('filePreview').classList.remove('d-none');
        }
    }

    function clearFileSelection(event) {
        event.stopPropagation();
        const fileInput = document.getElementById('fileInput');
        fileInput.value = '';
        document.getElementById('dropzonePrompt').classList.remove('d-none');
        document.getElementById('filePreview').classList.add('d-none');
    }

    // Drag and Drop Effects
    const dropzone = document.getElementById('dropzoneArea');
    ['dragenter', 'dragover'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropzone.classList.add('dragover');
        }, false);
    });
    ['dragleave', 'drop'].forEach(eventName => {
        dropzone.addEventListener(eventName, (e) => {
            e.preventDefault();
            dropzone.classList.remove('dragover');
        }, false);
    });
    dropzone.addEventListener('drop', (e) => {
        const dt = e.dataTransfer;
        const files = dt.files;
        if (files && files.length) {
            document.getElementById('fileInput').files = files;
            handleFileSelect(document.getElementById('fileInput'));
        }
    });

    // In-page Lightbox Document Modal Preview
    function previewDocument(fileUrl, docType, fileName) {
        document.getElementById('documentModalTitle').textContent = docType;
        document.getElementById('documentModalSubtitle').textContent = fileName;
        document.getElementById('modalDownloadBtn').setAttribute('href', fileUrl);

        const isPdf = fileUrl.toLowerCase().endsWith('.pdf');
        const imgContainer = document.getElementById('previewImageContainer');
        const pdfContainer = document.getElementById('previewPdfContainer');

        if (isPdf) {
            imgContainer.classList.add('d-none');
            pdfContainer.classList.remove('d-none');
            document.getElementById('modalPreviewPdf').src = fileUrl;
        } else {
            pdfContainer.classList.add('d-none');
            imgContainer.classList.remove('d-none');
            document.getElementById('modalPreviewImg').src = fileUrl;
        }

        const modal = new bootstrap.Modal(document.getElementById('documentPreviewModal'));
        modal.show();
    }

    // Form Submit Loading State
    document.getElementById('documentUploadForm').addEventListener('submit', function() {
        const btn = document.getElementById('submitBtn');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Uploading & Encrypting...';
    });
</script>
@endpush
@endsection
