@extends('templates.default')

@php
    $preTitle = "Customers";
    $title = "Pending Approvals";
@endphp

@push('search')
 <form action="{{route('prospects.search')}}" method="GET" class="d-none d-md-block search-form w-100">
    <div class="input-group border-0 shadow-none">
        <span class="input-group-text bg-white border-0 shadow-none"><i class="bx bx-search"></i></span>
        <input type="text" name="keyword" value="{{request('keyword')}}" 
               class="form-control border-0 shadow-none" placeholder="Search customers...">
    </div>
</form>
@endpush

@push('create')
    <a href="{{route('customer.create')}}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Create New
    </a>
@endpush

@section('content')
<div class="page-body">
    <div class="container-xl">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h6 class="mb-0 text-muted">
                <i class="bx bx-time-five me-2"></i> Pending Approval Requests
            </h6>
            <span class="badge bg-warning rounded-pill">
                {{ $customers->where('status', 'pending')->count() }} pending
            </span>
        </div>

        @if($customers->where('status', 'pending')->count() > 0)
        <div class="row g-4">
            @foreach ($customers as $customer)
            @if($customer->status == 'pending')
            <div class="col-md-6 col-xl-4">
                <div class="card card-hover border-0 shadow-sm h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="d-flex align-items-center">
                                <!-- Profile Avatar -->
                                <div class="avatar-container me-3">
                                    @if($customer->photo && file_exists(public_path('storage/' . $customer->photo)))
                                        <img src="{{ asset('storage/' . $customer->photo) }}" alt="{{ $customer->company_name }}" class="avatar-img">
                                    @else
                                        <div class="avatar-initials">
                                            {{ substr($customer->company_name, 0, 1) }}
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h5 class="card-title mb-0">{{ $customer->company_name }}</h5>
                                    <small class="text-muted">Waiting for approval</small>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3 small text-muted">
                            <div class="d-flex align-items-center mb-2">
                                <i class="bx bx-envelope me-2"></i>
                                <span class="text-truncate">{{ $customer->company_email }}</span>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <i class="bx bx-phone me-2"></i>
                                <span>{{ $customer->company_phone }}</span>
                            </div>
                            <div class="d-flex align-items-center">
                                <i class="bx bx-map me-2"></i>
                                <span class="text-truncate">{{ $customer->billing_address }}</span>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between pt-3 border-top">
                            <a href="{{route('customer.show', $customer->id)}}" class="btn btn-sm btn-outline-secondary">
                                <i class="bx bx-show me-1"></i> View Details
                            </a>
                            <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#acceptModal{{ $customer->id }}">
                                <i class="bx bx-check me-1"></i> Process
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accept Modal -->
            <div class="modal fade" id="acceptModal{{ $customer->id }}" tabindex="-1" aria-hidden="true">
                <form action="{{route('customer.accept', $customer->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light">
                                <h5 class="modal-title">
                                    <i class="bx bx-check-circle text-primary me-2"></i>
                                    Process Approval - {{$customer->company_name}}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p class="text-muted mb-4">Please provide the purchase order information to complete the approval process.</p>
                                
                                <div class="mb-3">
                                    <label class="form-label">PO Number <span class="text-danger">*</span></label>
                                    <input type="text" name="purchase_order_number" class="form-control" placeholder="Enter PO Number" required>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label">PO Date <span class="text-danger">*</span></label>
                                        <input type="date" name="date" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">PO File <span class="text-danger">*</span></label>
                                        <input type="file" name="po_file" class="form-control" required>
                                        <div class="form-text">Max. 5MB</div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="bx bx-check me-1"></i> Submit & Approve
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <div class="text-center py-5">
            <div class="mb-4">
                <i class="bx bx-check-circle display-4 text-success"></i>
            </div>
            <h5 class="mb-2">All Clear!</h5>
            <p class="text-muted mb-4">There are no pending approval requests at this time.</p>
            <a href="{{ route('customer.index') }}" class="btn btn-outline-primary">
                <i class="bx bx-list-ul me-1"></i> View All Customers
            </a>
        </div>
        @endif

    </div>
</div>
@endsection

<style>
    .card-hover {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border-left: 4px solid #ffc107 !important;
    }
    .card-hover:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.08) !important;
    }
    .avatar-container {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f0f0f0;
        font-weight: 600;
        font-size: 18px;
        color: #555;
    }
    .avatar-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .avatar-initials {
        width: 100%;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        background: #e9ecef;
        color: #6c757d;
        font-size: 1.2rem;
        font-weight: 600;
    }
    .bx {
        vertical-align: middle;
    }
    .btn {
        display: inline-flex;
        align-items: center;
    }
</style>
