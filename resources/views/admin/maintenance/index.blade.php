@extends('layouts.app')

@section('title', 'Maintenance Records — Admin')

@section('content')
<section class="dashboard-section pb-5">
    <div class="container">
        <!-- Header -->
        <div class="dashboard-header d-flex align-items-center justify-content-between flex-wrap gap-3" data-aos="fade-down">
            <div>
                <h1 class="fw-bold mb-1">Vehicle Maintenance & Repairs</h1>
                <p class="text-muted mb-0">Track servicing logs, repair expenses, and toggle vehicle availability.</p>
            </div>
            <div>
                <button type="button" class="btn btn-primary rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#newMaintenanceModal">
                    <i class="fas fa-wrench me-2"></i> Schedule Maintenance
                </button>
            </div>
        </div>

        <div class="dashboard-card" data-aos="fade-up">
            <div class="card-header-custom">
                <h5><i class="fas fa-screwdriver-wrench me-2 text-primary"></i> Maintenance Logs</h5>
            </div>
            <div class="card-body-custom">
                <div class="table-responsive">
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
                                        <div class="fw-bold">{{ $rec->car->brand }} {{ $rec->car->model }}</div>
                                        <small class="text-muted">{{ $rec->car->registration_number }}</small>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ $rec->title }}</div>
                                        @if($rec->description)
                                            <small class="text-muted d-block">{{ $rec->description }}</small>
                                        @endif
                                    </td>
                                    <td>{{ $rec->scheduled_date->format('d M Y') }}</td>
                                    <td>{{ $rec->completed_date ? $rec->completed_date->format('d M Y') : '—' }}</td>
                                    <td class="fw-bold text-dark">₹{{ number_format($rec->cost, 2) }}</td>
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
                                            <span class="small text-muted"><i class="fas fa-check-circle text-success me-1"></i> Done</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">No maintenance records logged.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center mt-4">
                    {{ $records->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal: Schedule Maintenance -->
<div class="modal fade" id="newMaintenanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.maintenance.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title"><i class="fas fa-wrench me-2 text-primary"></i> Schedule Maintenance</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Vehicle *</label>
                        <select name="car_id" class="form-select" required>
                            @foreach($cars as $c)
                                <option value="{{ $c->id }}">{{ $c->brand }} {{ $c->model }} ({{ $c->registration_number }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Service Title *</label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Engine Oil Service, Brake Pad Replacement" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold">Scheduled Date *</label>
                            <input type="date" name="scheduled_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold">Estimated Cost (₹)</label>
                            <input type="number" name="cost" class="form-control" placeholder="0" step="0.01">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Service Description / Notes</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Details of servicing..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Schedule & Set Maintenance Status</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
