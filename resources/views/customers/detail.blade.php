@extends('templates.default')

@section('content')
<div class="row">
    <!-- Customer Information Card -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="bx bx-building-house me-2"></i>
                    {{ $customer->company_name }}
                </h5>
                <div>
                    <a href="{{ route('customer.prospects') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bx bx-arrow-back me-1"></i> Back
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Company Email</label>
                            <div class="form-control-plaintext">{{ $customer->company_email }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Billing Address</label>
                            <div class="form-control-plaintext">{{ $customer->billing_address }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NPWP</label>
                            <div class="form-control-plaintext">{{ $customer->npwp }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Company Phone</label>
                            <div class="form-control-plaintext">{{ $customer->company_phone }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Operational Address</label>
                            <div class="form-control-plaintext">{{ $customer->operational_address }}</div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIB</label>
                            <div class="form-control-plaintext">{{ $customer->nib }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-user me-2"></i>Contact Persons</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customer->contactPeople as $cp)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-label-primary">
                                                {{ substr($cp->contact_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>{{ $cp->contact_name }}</div>
                                    </div>
                                </td>
                                <td><a href="mailto:{{ $cp->contact_email }}">{{ $cp->contact_email }}</a></td>
                                <td><a href="tel:{{ $cp->contact_phone }}">{{ $cp->contact_phone }}</a></td>
                                <td><span class="badge bg-label-primary">{{ $cp->contact_position }}</span></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="text-muted">No contact persons found</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscription Products Card -->
    <div class="col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0"><i class="bx bx-package me-2"></i>Subscription Products</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Date</th>
                                <th>Document</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($customer->customerProducts as $cpr)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-sm me-2">
                                            <span class="avatar-initial rounded-circle bg-label-success">
                                                {{ substr($cpr->product->product_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>{{ ucfirst($cpr->product->product_name) }}</div>
                                    </div>
                                </td>
                                @foreach ($customer->quotations as $quotation)
                                <td>{{ $quotation->date }}</td>
                                <td>
                                    <a href="{{ $quotation->file_path }}" class="btn btn-sm btn-outline-primary" target="_blank">
                                        <i class="bx bx-file me-1"></i> View SPH
                                    </a>
                                </td>
                                <td>
                                    <form action="{{ route('quotation.destroy', $quotation->id) }}" method="post" onsubmit="return confirm('Are you sure you want to delete this quotation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bx bx-trash me-1"></i> Delete
                                        </button>
                                    </form>
                                </td>
                                @endforeach
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center py-4">
                                    <div class="text-muted">No subscription products found</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="col-md-12">
        <div class="d-flex justify-content-between">
            <div>
                <a href="{{ route('customer.edit', $customer->id) }}" class="btn btn-warning btn-sm">
                 Edit Customer
                </a>
                 <form action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this invoice?')">
                 Delete
            </button>
        </form>
            </div>
             
            <div>
                @if ($customer->status === 'accepted')
                <form action="{{ route('customer.cancel', $customer->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel activation?')">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-danger">
                        <i class="bx bx-x me-1"></i> Cancel Activation
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection