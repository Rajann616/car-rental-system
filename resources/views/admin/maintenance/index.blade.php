@extends('layouts.admin')

@section('title', 'Vehicle Maintenance & Repairs — Admin')
@section('page_title', 'Maintenance Log')

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
                                <i class="fas fa-wrench me-1"></i> Fleet Servicing Log
                            </span>
                        </div>
                        <h1 class="fw-bold text-white font-display fs-3 mb-1">Vehicle Maintenance & Repairs</h1>
                        <p class="text-white-50 mb-0 max-w-2xl small">
                            Track servicing schedules, engine repair logs, cost expenses, and toggle vehicle availability status automatically.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end mt-2 mt-lg-0">
                        <button type="button" class="btn rounded-pill px-4 py-2 fw-bold text-white shadow-sm" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;" data-bs-toggle="modal" data-bs-target="#newMaintenanceModal">
                            <i class="fas fa-wrench me-1"></i> Schedule Maintenance
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Maintenance Logs Master Liquid Card -->
        <div class="liquid-card border-0 shadow-sm overflow-hidden" data-aos="fade-up">
            <div class="card-header-custom bg-white p-4 border-bottom d-flex align-items-center justify-content-between">
                <h5 class="fw-bold mb-0 text-dark">
                    <i class="fas fa-screwdriver-wrench me-2 text-primary"></i> Maintenance Logs ({{ $records->total() }})
                </h5>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
                    <i class="fas fa-arrow-left me-1"></i> Dashboard
                </a>
            </div>
            <div class="card-body-custom p-4">
                <!-- Desktop Table View -->
                <div class="desktop-table-container table-responsive">
                    <table class="table table-modern align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Vehicle</th>
                                <th>Service Task</th>
                                <th>Scheduled Date</th>
                                <th>Completed Date</th>
                                <th>Cost (₹)</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($records as $rec)
                                <tr>
                                    <td>
                                        <div class="fw-bold text-dark fs-6">{{ $rec->car->brand }} {{ $rec->car->model }}</div>
                                        <small class="text-muted">{{ $rec->car->registration_number }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark fs-6">{{ $rec->title }}</div>
                                        @if($rec->description)
                                            <small class="text-muted d-block">{{ $rec->description }}</small>
                                        @endif
                                    </td>
                                    <td class="small fw-semibold text-dark"><i class="fas fa-calendar-alt text-primary me-1"></i> {{ $rec->scheduled_date->format('d M Y') }}</td>
                                    <td class="small text-muted">{{ $rec->completed_date ? $rec->completed_date->format('d M Y') : '—' }}</td>
                                    <td class="fw-bold text-dark fs-6">₹{{ number_format($rec->cost, 2) }}</td>
                                    <td>
                                        <span class="badge-status {{ $rec->status_badge }}">
                                            {{ $rec->status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($rec->status !== 'Completed')
                                            <form action="{{ route('admin.maintenance.complete', $rec->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                                    <i class="fas fa-check me-1"></i> Mark Completed
                                                </button>
                                            </form>
                                        @else
                                            <span class="small text-success fw-semibold"><i class="fas fa-check-circle me-1"></i> Service Done</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-5 text-muted">No vehicle maintenance records logged yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Mobile Card Container (<= 767px) -->
                <div class="mobile-card-container">
                    @forelse($records as $rec)
                        <div class="card border rounded-4 shadow-sm p-3 mb-2 bg-white">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark fs-6">{{ $rec->car->brand }} {{ $rec->car->model }}</span>
                                <span class="badge-status {{ $rec->status_badge }}">{{ $rec->status }}</span>
                            </div>
                            <div class="small fw-semibold text-dark mb-1">{{ $rec->title }}</div>
                            <div class="small text-muted mb-2">
                                <div><i class="fas fa-calendar-alt text-primary me-1"></i> Scheduled: {{ $rec->scheduled_date->format('d M Y') }}</div>
                                @if($rec->completed_date)
                                    <div><i class="fas fa-check text-success me-1"></i> Done: {{ $rec->completed_date->format('d M Y') }}</div>
                                @endif
                            </div>
                            <div class="d-flex align-items-center justify-content-between pt-2 border-top">
                                <div class="fw-bold text-dark fs-6">₹{{ number_format($rec->cost, 2) }}</div>
                                @if($rec->status !== 'Completed')
                                    <form action="{{ route('admin.maintenance.complete', $rec->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                            Mark Completed
                                        </button>
                                    </form>
                                @else
                                    <span class="small text-success fw-semibold"><i class="fas fa-check-circle me-1"></i> Done</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-4 text-muted">No vehicle maintenance records logged yet.</div>
                    @endforelse
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $records->links() }}
                </div>
            </div>
    </div>
</div>

<!-- Modal: Schedule Maintenance -->
<div class="modal fade" id="newMaintenanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content rounded-4">
            <form action="{{ route('admin.maintenance.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fas fa-wrench me-2 text-primary"></i> Schedule Vehicle Maintenance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Select Vehicle *</label>
                        <select name="car_id" class="form-select border-2" required>
                            @foreach($cars as $c)
                                <option value="{{ $c->id }}">{{ $c->brand }} {{ $c->model }} ({{ $c->registration_number }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Service Title *</label>
                        <input type="text" name="title" class="form-control border-2" placeholder="e.g. Engine Oil Service, Brake Pad Replacement" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Scheduled Date *</label>
                            <input type="date" name="scheduled_date" class="form-control border-2" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Estimated Cost (₹)</label>
                            <input type="number" name="cost" class="form-control border-2" placeholder="0" step="0.01">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Service Description / Notes</label>
                        <textarea name="description" class="form-control border-2" rows="3" placeholder="Details of servicing..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light rounded-pill px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4" style="background: linear-gradient(135deg, #ff7a00, #ea580c); border: none;">Schedule & Toggle Maintenance</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
