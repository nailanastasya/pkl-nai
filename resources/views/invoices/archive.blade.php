@extends('templates.default')

@php
    $preTitle = "Data Master";
    $title = "Invoice Management";
@endphp

{{-- @push('page-action')
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
        <i class='bx bx-plus me-2'></i>Create New Invoice
    </button>
@endpush --}}

@section('content')
<div class="page-body">
    <div class="container-xl">

        {{-- ===================== STATS OVERVIEW ===================== --}}
        <div class="row mb-4">
            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card stats-card total h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted mb-1">Total Invoices</h6>
                                <h3 class="mb-0">{{ $invoices->count() }}</h3>
                            </div>
                            <div class="col-4 text-end">
                                <i class='bx bx-receipt stats-icon total'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card stats-card paid h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted mb-1">Paid</h6>
                                <h3 class="mb-0">{{ $invoices->where('status', 'paid')->count() }}</h3>
                            </div>
                            <div class="col-4 text-end">
                                <i class='bx bx-check-circle stats-icon paid'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card stats-card unpaid h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted mb-1">Unpaid</h6>
                                <h3 class="mb-0">{{ $invoices->where('status', 'unpaid')->count() }}</h3>
                            </div>
                            <div class="col-4 text-end">
                                <i class='bx bx-time stats-icon unpaid'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3 col-sm-6 mb-3">
                <div class="card stats-card overdue h-100">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="text-muted mb-1">Overdue</h6>
                                <h3 class="mb-0">{{ $invoices->where('status', 'overdue')->count() }}</h3>
                            </div>
                            <div class="col-4 text-end">
                                <i class='bx bx-error-circle stats-icon overdue'></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Archived --}}
            <div class="col-md-3 col-sm-6 mb-3">
                <a href="{{ route('invoice.archiveIndex') }}" class="text-decoration-none">
                    <div class="card stats-card archived h-100">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h6 class="text-muted mb-1">Archived</h6>
                                    <h3 class="mb-0">{{ $invoices->where('is_archived', true)->count() }}</h3>
                                </div>
                                <div class="col-4 text-end">
                                    <i class='bx bx-archive stats-icon text-warning'></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>


        {{-- ===================== TABLE ===================== --}}
        <div class="card">
            <div class="card-header bg-transparent py-3">
                <h5 class="mb-0">Invoice List</h5>
            </div>
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="invoicesTable">
                    <thead>
                        <tr>
                            <th class="ps-4">Invoice Info</th>
                            <th>Client</th>
                            <th>Dates</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Amount</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($invoices as $invoice)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="invoice-subject">{{ ucfirst($invoice->customer_product->product->product_name ?? $invoice->invoice_subject ?? 'Untitled Invoice') }}</div>
                                            <div class="invoice-nodin">NODIN: {{ $invoice->nodin->nodin ?? '-' }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="client-name">{{ $invoice->customer_product->customer->company_name ?? '-' }}</div>
                                    <div class="client-contact">{{ $invoice->customer_product->customer->contactPeople->first()->contact_name ?? 'No contact' }}</div>
                                </td>
                                <td>
                                    <div class="invoice-date">
                                        <div>Issued: {{ \Carbon\Carbon::parse($invoice->date)->format('M d, Y') }}</div>
                                        <div>Due: {{ \Carbon\Carbon::parse($invoice->due_date)->format('M d, Y') }}</div>
                                    </div>
                                </td>
                                <td>
                                    @php
                                        $statusColors = [
                                            'paid' => 'success',
                                            'overdue' => 'danger',
                                            'partial' => 'warning',
                                            'unpaid' => 'secondary',
                                        ];
                                        $statusColor = $statusColors[$invoice->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }} p-2">{{ ucfirst($invoice->status) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="invoice-amount">Rp {{ number_format($invoice->amount) }}</div>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('invoice.show', $invoice->id) }}" class="action-btn btn-info" title="View Details">
                                        <i class='bx bx-show'></i>
                                    </a>

                                    {{-- Tombol Arsip --}}
                                    @if(!$invoice->is_archived)
                                        <form action="{{ route('invoice.archive', $invoice->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn border-0 bg-transparent p-0 text-warning" 
                                                    title="Arsipkan" 
                                                    onclick="return confirm('Yakin mau arsipkan invoice ini?')">
                                                <i class='bx bx-archive'></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('invoice.unarchive', $invoice->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="action-btn border-0 bg-transparent p-0 text-success" 
                                                    title="Kembalikan dari Arsip" 
                                                    onclick="return confirm('Kembalikan invoice ini dari arsip?')">
                                                <i class='bx bx-archive-out'></i>
                                            </button>
                                        </form>
                                    @endif

                                    @if($invoice->file_path)
                                        <a href="https://drive.google.com/file/d/{{ $invoice->file_path }}/view" 
                                           class="action-btn btn-secondary" 
                                           title="Open File" 
                                           target="_blank">
                                            <i class='bx bx-download'></i>
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <div class="col-12">
                            <div class="alert alert-dark text-center" role="alert" style="background-color: #e0e0e0">No Data Found</div>
                        </div>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- ===================== CREATE MODAL ===================== --}}

@endsection


{{-- ===================== CSS STYLE ===================== --}}
<style>
:root {
    --primary: #4361ee;
    --secondary: #6c757d;
    --success: #198754;
    --warning: #ffc107;
    --danger: #dc3545;
    --light: #f8f9fa;
    --dark: #212529;
}

.stats-card {
    border-left: 4px solid;
    height: 100%;
}
.stats-card.total { border-left-color: var(--primary); }
.stats-card.paid { border-left-color: var(--success); }
.stats-card.unpaid { border-left-color: var(--warning); }
.stats-card.overdue { border-left-color: var(--danger); }

.stats-icon {
    font-size: 2.5rem;
    opacity: 0.8;
}
.stats-icon.total { color: var(--primary); }
.stats-icon.paid { color: var(--success); }
.stats-icon.unpaid { color: var(--warning); }
.stats-icon.overdue { color: var(--danger); }

.table th {
    font-weight: 600;
    border-top: none;
    border-bottom: 2px solid #e9ecef;
    padding: 15px 12px;
    background-color: #f8f9fa;
}
.table td {
    padding: 15px 12px;
    vertical-align: middle;
}
.badge {
    padding: 8px 12px;
    border-radius: 6px;
    font-weight: 500;
}
.invoice-subject { font-weight: 600; color: #344767; }
.invoice-nodin { font-size: 0.85rem; color: #6c757d; }
.client-name { font-weight: 500; color: #344767; }
.client-contact { font-size: 0.85rem; color: #6c757d; }
.invoice-date { font-size: 0.9rem; color: #6c757d; }
.invoice-amount { font-weight: 600; color: #344767; }

.action-btn {
    width: 32px;
    height: 32px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    border-radius: 8px;
    margin: 0 3px;
}
.action-btn.btn-info { background-color: rgba(13,202,240,0.1); color: #0dcaf0; }
.action-btn.btn-primary { background-color: rgba(13,110,253,0.1); color: #0d6efd; }
.action-btn.btn-danger { background-color: rgba(220,53,69,0.1); color: #dc3545; }
.action-btn.btn-secondary { background-color: rgba(108,117,125,0.1); color: #6c757d; }

.empty-state {
    text-align: center;
}
.empty-icon {
    font-size: 4rem;
    color: #dee2e6;
}
</style>
