@extends('templates.default')

@php
    $preTitle = 'Invoice';
    $title = 'Details';
@endphp

@push('page-action')
    <div class="btn-list">
        <a href="{{ route('invoice.index') }}" class="btn btn-light border btn-sm">
            <i class="bx bx-arrow-back me-1"></i> Back
        </a>
        <a href="{{ route('invoice.edit', $invoice->id) }}" class="btn btn-primary btn-sm">
            <i class="bx bx-edit me-1"></i> Edit
        </a>
        <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm"
                onclick="return confirm('Are you sure you want to delete this invoice?')">
                <i class="bx bx-trash me-1"></i> Delete
            </button>
        </form>
        @if($invoice->file_path)
        <a href="{{ asset('storage/' . $invoice->file_path) }}" class="btn btn-outline-dark btn-sm" target="_blank">
            <i class="bx bx-download me-1"></i> Download Invoice
        </a>
        @endif
    </div>
@endpush

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Invoice Header -->
        <div class="invoice-header text-center mb-5">
            <h1 class="fw-bold text-dark">Invoice #{{ $invoice->id }}</h1>
            <p class="text-muted mb-1">{{ ucfirst($invoice->invoice_subject ?? 'No subject') }}</p>
            <span class="badge bg-{{ $invoice->status == 'paid' ? 'success' : ($invoice->status == 'overdue' ? 'danger' : ($invoice->status == 'partial' ? 'warning' : 'secondary')) }} px-3 py-2 fs-6 ">
                {{ ucfirst($invoice->status) }}
            </span>
        </div>

        <div class="row g-4">
            <!-- Left Column -->
            <div class="col-lg-8">
                <!-- Invoice Details Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-semibold text-dark mb-4">Invoice Details</h5>
                        <div class="row g-4">
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Issue Date</p>
                                <p class="fw-semibold">{{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Due Date</p>
                                <p class="fw-semibold">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                            </div>
                        </div>
                        <hr>
                        <p class="text-muted small mb-1">Description</p>
                        <p class="fw-semibold">{{ $invoice->description ?? 'No description provided' }}</p>

                        <p class="text-muted small mb-1 mt-3">NODIN Reference</p>
                        <p class="fw-semibold">{{ $invoice->nodin->nodin ?? 'N/A' }}</p>
                    </div>
                </div>

                <!-- Items Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-semibold text-dark mb-4">Invoice Items</h5>
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Product / Service</th>
                                        <th>Period</th>
                                        <th class="text-end">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="fw-semibold">{{ $invoice->customer_product->product->product_name ?? 'N/A' }}</span><br>
                                            <small class="text-muted">For {{ $invoice->customer_product->customer->company_name ?? 'N/A' }}</small>
                                        </td>
                                        <td>{{ ucfirst($invoice->customer_product->period ?? 'N/A') }}</td>
                                        <td class="text-end">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-end fw-bold">Total</td>
                                        <td class="text-end fw-bold">Rp {{ number_format($invoice->amount, 0, ',', '.') }}</td>
                                    </tr>
                                    @if($invoice->status == 'partial')
                                    <tr>
                                        <td colspan="2" class="text-end text-success">Paid (50%)</td>
                                        <td class="text-end text-success">
                                            Rp {{ number_format($invoice->amount * 0.5, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="text-end text-danger">Balance Due</td>
                                        <td class="text-end text-danger">
                                            Rp {{ number_format($invoice->amount * 0.5, 0, ',', '.') }}
                                        </td>
                                    </tr>
                                    @endif
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                @if($invoice->file_path)
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body d-flex align-items-center">
                        <i class="bx bx-file fs-2 text-primary me-3"></i>
                        <div class="flex-grow-1">
                            <p class="fw-semibold mb-0">Invoice Document</p>
                            <small class="text-muted">PDF File</small>
                        </div>
                        <a href="{{ asset('storage/' . $invoice->file_path) }}" target="_blank"
                            class="btn btn-sm btn-outline-primary">
                            <i class="bx bx-show me-1"></i> View
                        </a>
                    </div>
                </div>
                @endif

                <!-- Receipt Section -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-semibold text-dark mb-4">Receipt</h5>
                        @if($invoice->receipt)
                            <div class="d-flex align-items-center">
                                <i class="bx bx-receipt fs-2 text-success me-3"></i>
                                <div class="flex-grow-1">
                                    <p class="fw-semibold mb-0">Payment Receipt</p>
                                    <small class="text-muted">Uploaded on {{ \Carbon\Carbon::parse($invoice->receipt->date)->format('M d, Y') }}</small>
                                </div>
                                <a href="{{ asset('storage/' . $invoice->receipt->file_path) }}" target="_blank"
                                    class="btn btn-sm btn-outline-success">
                                    <i class="bx bx-show me-1"></i> View
                                </a>
                            </div>
                        @else
                            <form action="{{ route('receipt.store', $invoice->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                @csrf
                                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                <div class="mb-3">
                                    <label class="form-label">Upload Receipt (PDF)</label>
                                    <input type="file" name="file_path" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Payment Date</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="bx bx-upload me-1"></i> Upload Receipt
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column -->
            <div class="col-lg-4">
                <!-- Client Info -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h5 class="fw-semibold text-dark mb-4">Client</h5>
                        @if($invoice->customer_product && $invoice->customer_product->customer)
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle bg-primary text-white fw-bold d-flex align-items-center justify-content-center me-3" style="width:50px; height:50px;">
                                    {{ substr($invoice->customer_product->customer->company_name, 0, 1) }}
                                </div>
                                <div>
                                    <p class="fw-semibold mb-0">{{ $invoice->customer_product->customer->company_name }}</p>
                                    <small class="text-muted">{{ $invoice->customer_product->customer->contactPeople->first()->contact_name ?? 'No contact' }}</small>
                                </div>
                            </div>
                            <div class="text-muted small">
                                <p class="mb-1"><i class="bx bx-envelope me-1"></i> {{ $invoice->customer_product->customer->contactPeople->first()->contact_email ?? 'N/A' }}</p>
                                <p class="mb-1"><i class="bx bx-phone me-1"></i> {{ $invoice->customer_product->customer->contactPeople->first()->contact_phone ?? 'N/A' }}</p>
                                <p class="mb-0"><i class="bx bx-map me-1"></i> {{ ucfirst($invoice->customer_product->customer->billing_address ?? 'N/A') }}</p>
                            </div>
                        @else
                            <div class="text-center text-muted py-4">
                                <i class="bx bx-user-x fs-1 mb-2"></i>
                                <p>No client information available</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Timeline -->
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="fw-semibold text-dark mb-4">Timeline</h5>
                        <ul class="list-unstyled timeline">
                            <li class="mb-4">
                                <p class="text-muted small mb-1">{{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</p>
                                <p class="fw-semibold mb-0">Invoice Created</p>
                            </li>
                            @if($invoice->status == 'paid' || $invoice->status == 'partial')
                            <li class="mb-4">
                                <p class="text-muted small mb-1">{{ \Carbon\Carbon::parse($invoice->updated_at)->format('M d, Y') }}</p>
                                <p class="fw-semibold mb-0">Payment Received</p>
                                <small class="text-success">
                                    {{ $invoice->status == 'paid' ? 'Full payment' : 'Partial payment (50%)' }}
                                </small>
                            </li>
                            @endif
                            <li>
                                <p class="text-muted small mb-1">{{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</p>
                                <p class="fw-semibold mb-0">Due Date</p>
                                <small class="{{ \Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($invoice->due_date)) ? 'text-danger' : 'text-muted' }}">
                                    @if(\Carbon\Carbon::now()->gt(\Carbon\Carbon::parse($invoice->due_date)))
                                        Overdue by {{ \Carbon\Carbon::parse($invoice->due_date)->diffInDays() }} days
                                    @else
                                        Due in {{ \Carbon\Carbon::now()->diffInDays(\Carbon\Carbon::parse($invoice->due_date)) }} days
                                    @endif
                                </small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<style>
    .timeline li {
        position: relative;
        padding-left: 20px;
    }
    .timeline li::before {
        content: '';
        position: absolute;
        left: 0;
        top: 5px;
        width: 8px;
        height: 8px;
        background: #4361ee;
        border-radius: 50%;
    }
</style>
