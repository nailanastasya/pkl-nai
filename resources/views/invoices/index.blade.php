@extends('templates.default')

@php
    $preTitle = "Data Master";
    $title = "Invoice Management";
@endphp

@push('page-action')
    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
        <i class='bx bx-plus me-2'></i>Create New Invoice
    </button>
@endpush

@section('content')
<div class="page-body">
    <div class="container-xl">
        <!-- Stats Overview -->
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

    <!-- ✅ Tambahan card Archived -->
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


        <!-- Filters -->
        {{-- <div class="filter-card mb-4">
            <div class="row g-3">
                <div class="col-md-4">
                     <form action="{{route('invoice.search')}}" method="GET">
                    <div class="input-group">
                       
                        <span class="input-group-text bg-transparent"><i class='bx bx-search'></i></span>
                        <input type="text" class="form-control" name="keyword" value="{{request('keyword')}}" placeholder="Search invoices...">
 
                    </div>
                       </form>
                </div>
                <div class="col-md-2">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="unpaid">Unpaid</option>
                        <option value="overdue">Overdue</option>
                        <option value="partial">Partial</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control" id="dateFilter">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-outline-secondary w-100" id="resetFilters">
                        <i class='bx bx-reset me-1'></i>Reset Filters
                    </button>
                </div>
            </div>
        </div> --}}

        <!-- Invoice Table -->
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
                                        {{-- <div class="invoice-avatar bg-primary me-3">
                                            {{ ucfirst(substr($invoice->customer_product->product->product_name ?? $invoice->invoice_subject ?? 'I', 0, 1)  ) }}
                                        </div> --}}
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
                                        // $statusIcons = [
                                        //     'paid' => 'check-circle',
                                        //     'overdue' => 'error-circle',
                                        //     'partial' => 'time',
                                        //     'unpaid' => 'clock',
                                        // ];
                                        // $statusIcon = $statusIcons[$invoice->status] ?? 'clock';
                                    @endphp
                                    <span class="badge bg-{{ $statusColor }} p-2">
                                        {{-- <i class="bx bx-{{ $statusIcon }} me-1"></i> --}} {{ ucfirst($invoice->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="invoice-amount">Rp {{ number_format($invoice->amount) }}</div>
                                    @if($invoice->status == 'partial')
                                        <div class="text-muted small">Paid: Rp {{ number_format($invoice->amount * 0.5) }}</div>
                                    @endif
                                </td>
                               <td class="text-center">
    <a href="{{ route('invoice.show', $invoice->id) }}" class="action-btn btn-info" title="View Details">
        <i class='bx bx-show'></i>
    </a>
    <a href="#" class="action-btn btn-primary" title="Edit" data-bs-toggle="modal" data-bs-target="#editInvoiceModal">
        <i class='bx bx-edit'></i>
    </a>
    <form action="{{ route('invoice.destroy', $invoice->id) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="action-btn btn-danger border-0 bg-transparent p-0" 
                title="Delete" 
                onclick="return confirm('Are you sure you want to delete this invoice?')">
            <i class='bx bx-trash'></i>
        </button>
    </form>

    {{-- Tombol Arsip / Unarsip --}}
  @if(!$invoice->is_archived)
    <form action="{{ route('invoice.archive', $invoice->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PATCH')
        <button type="submit" class="action-btn border-0 bg-transparent p-0" 
                title="Arsipkan" 
                onclick="return confirm('Yakin mau arsipkan invoice ini?')">
          <i class='bx bx-archive text-warning'></i> 
        </button>
    </form>
@else
    <form action="{{ route('invoice.unarchive', $invoice->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PATCH')
        <button type="submit" class="action-btn border-0 bg-transparent p-0" 
                title="Kembalikan dari Arsip" 
                onclick="return confirm('Kembalikan invoice ini dari arsip?')">
            <i class='bx bx-archive text-success'></i>
        </button>
    </form>
@endif


    @if($invoice->file_path)
        <a href="https://drive.google.com/file/d/{{ $invoice->file_path }}/view" 
           class="action-btn btn-secondary" 
           title="Download File" 
           target="_blank">
            <i class='bx bx-download'></i>
        </a>
    @endif
</td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div class="empty-state">
                                        <i class='bx bx-receipt empty-icon'></i>
                                        <h3 class="mt-4">No invoices found</h3>
                                        <p class="text-muted">
                                            There are no invoices in the system yet.
                                        </p>
                                        <button class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#createInvoiceModal">
                                            <i class='bx bx-plus me-1'></i> Create your first invoice
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($invoices->count() > 0)
            <div class="card-footer bg-transparent">
                <div class="d-flex align-items-center">
                    <div class="text-muted">Showing <span>{{ $invoices->count() }}</span> invoices</div>
                    <ul class="pagination ms-auto mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class='bx bx-chevron-left'></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class='bx bx-chevron-right'></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Create Invoice Modal -->
<div class="modal fade" id="createInvoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('invoice.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Create New Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">Nodin</label>
                                <select name="nodin_id" class="form-select @error('nodin_id') is-invalid @enderror" required>
                                    <option value="">Select Nodin</option>
                                    @foreach ($nodins as $nodin)
                                        <option value="{{ $nodin->id }}" {{ old('nodin_id') == $nodin->id ? 'selected' : '' }}>
                                            {{ $nodin->nodin }} - {{ $nodin->subject ?? $nodin->number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nodin_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">Client Product</label>
                                <select name="customer_product_id" class="form-select @error('customer_product_id') is-invalid @enderror" required>
                                    <option value="">Select Client Product</option>
                                    @foreach ($customerProducts as $customerProduct)
                                        <option value="{{ $customerProduct->id }}" {{ old('customer_product_id') == $customerProduct->id ? 'selected' : '' }}>
                                            {{ $customerProduct->customer->company_name }} - {{ $customerProduct->product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_product_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Invoice Subject</label>
                        <input type="text" name="invoice_subject" class="form-control @error('invoice_subject') is-invalid @enderror"
                            placeholder="Enter invoice subject" value="{{ old('invoice_subject') }}" required>
                        @error('invoice_subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Enter invoice description" required>{{ old('description') }}</textarea>
                        @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                        name="amount" value="{{ old('amount') }}" step="0.01" placeholder="0.00" required>
                                </div>
                                @error('amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                    name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">Due Date</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                    name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                                @error('due_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                    <option value="">Select Status</option>
                                    @foreach ($statusOptions as $status)
                                        <option value="{{ $status }}" {{ old('status') == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                            <div class="col-lg-6">
                        <div class="mb-3">
                            <label class="form-label required">Invoice File (Google Drive)</label>
                            <select name="file_path" class="form-select @error('file_path') is-invalid @enderror" required>
                                <option value="">Pilih file dari Google Drive</option>
                                @foreach ($driveFiles as $file)
                                    <option value="{{ $file['id'] }}" {{ old('file_path') == $file['id'] ? 'selected' : '' }}>
                                        {{ $file['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Pilih file yang sudah ada di Google Drive
                            </small>
                            @error('file_path') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>
                    </div>



                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-plus me-1'></i>Create Invoice
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="editInvoiceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
     <form action="{{ route('invoice.update', $invoice->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Invoice</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">Nodin</label>
                                <select name="nodin_id" class="form-select @error('nodin_id') is-invalid @enderror" required>
                                    <option value="">Select Nodin</option>
                                    @foreach ($nodins as $nodin)
                                        <option value="{{ $nodin->id }}" {{ old('nodin_id', $invoice->nodin_id) == $nodin->id ? 'selected' : '' }}>
                                            {{ $nodin->nodin }} - {{ $nodin->subject ?? $nodin->number }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('nodin_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">Client Product</label>
                                <select name="customer_product_id" class="form-select @error('customer_product_id') is-invalid @enderror" required>
                                    <option value="">Select Client Product</option>
                                    @foreach ($customerProducts as $customerProduct)
                                        <option value="{{ $customerProduct->id }}" {{ old('customer_product_id', $invoice->customer_product_id) == $customerProduct->id ? 'selected' : '' }}>
                                            {{ $customerProduct->customer->company_name }} - {{ $customerProduct->product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('customer_product_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Invoice Subject</label>
                        <input type="text" name="invoice_subject" class="form-control @error('invoice_subject') is-invalid @enderror"
                            placeholder="Enter invoice subject" value="{{ old('invoice_subject', $invoice->invoice_subject) }}" required>
                        @error('invoice_subject') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label required">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Enter invoice description" required>{{ old('description', $invoice->description) }}</textarea>
                        @error('description') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">Amount</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" class="form-control @error('amount') is-invalid @enderror" 
                                        name="amount" value="{{ old('amount', $invoice->amount) }}" step="0.01" placeholder="0.00" required>
                                </div>
                                @error('amount') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                    name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                @error('date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <div class="col-lg-4">
                            <div class="mb-3">
                                <label class="form-label required">Due Date</label>
                                <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                    name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                                @error('due_date') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                    <option value="">Select Status</option>
                                    @foreach ($statusOptions as $status)
                                        <option value="{{ $status }}" {{ old('status', $invoice->status) == $status ? 'selected' : '' }}>
                                            {{ ucfirst($status) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            </div>
                        </div>
          <div class="col-lg-6">
    <div class="mb-3">
        <label class="form-label required">Invoice File (Google Drive)</label>
        <select name="file_path" class="form-select @error('file_path') is-invalid @enderror" required>
            <option value="">Pilih file dari Google Drive</option>
            @foreach ($driveFiles as $file)
                <option value="{{ $file['id'] }}" {{ old('file_path', $invoice->file_path) == $file['id'] ? 'selected' : '' }}>
                    {{ $file['name'] }}
                </option>
            @endforeach
        </select>
        <small class="form-text text-muted">
            Pilih file yang sudah ada di Google Drive
        </small>
        @error('file_path') <span class="invalid-feedback">{{ $message }}</span> @enderror

        @if($invoice->file_path)
            <p class="mt-2">File saat ini: 
                <a href="https://drive.google.com/file/d/{{ $invoice->file_path }}/view" target="_blank">Lihat File</a>
            </p>
        @endif
    </div>
</div>


                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">
                        <i class='bx bx-plus me-1'></i>Create Invoice
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection


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
    
    .filter-card {
        background-color: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 24px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
    }
    
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
    
    .invoice-avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        font-weight: 600;
        color: white;
    }
    
    .invoice-subject {
        font-weight: 600;
        color: #344767;
    }
    
    .invoice-nodin {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .client-name {
        font-weight: 500;
        color: #344767;
    }
    
    .client-contact {
        font-size: 0.85rem;
        color: #6c757d;
    }
    
    .invoice-date {
        font-size: 0.9rem;
        color: #6c757d;
    }
    
    .invoice-amount {
        font-weight: 600;
        color: #344767;
    }
    
    .action-btn {
        width: 32px;
        height: 32px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        margin: 0 3px;
    }
    
    .action-btn.btn-info {
        background-color: rgba(13, 202, 240, 0.1);
        color: #0dcaf0;
    }
    
    .action-btn.btn-primary {
        background-color: rgba(13, 110, 253, 0.1);
        color: #0d6efd;
    }
    
    .action-btn.btn-danger {
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
    }
    
    .action-btn.btn-secondary {
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
    }
    
    .empty-state {
        padding: 3rem 1rem;
        text-align: center;
        color: #6c757d;
    }
    
    .empty-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }
    
    .pagination .page-link {
        border-radius: 8px;
        margin: 0 3px;
        border: none;
        color: #344767;
    }
    
    .pagination .page-item.active .page-link {
        background-color: var(--primary);
    }
    
    .form-control, .form-select {
        border-radius: 8px;
        padding: 10px 15px;
        border: 1px solid #d2d6da;
    }
    
    .form-control:focus, .form-select:focus {
        box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.15);
        border-color: var(--primary);
    }
    
    .modal-content {
        border-radius: 12px;
        border: none;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
    }
    
    .modal-header {
        border-bottom: 1px solid #e9ecef;
        padding: 1.5rem;
    }
    
    .modal-footer {
        border-top: 1px solid #e9ecef;
        padding: 1.5rem;
    }
    
    .modal-body {
        padding: 1.5rem;
    }
</style>



<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Filter functionality
        const searchInput = document.getElementById('searchInput');
        const statusFilter = document.getElementById('statusFilter');
        const dateFilter = document.getElementById('dateFilter');
        const resetButton = document.getElementById('resetFilters');
        const invoicesTable = document.getElementById('invoicesTable');
        const rows = invoicesTable.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        function filterInvoices() {
            const searchText = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;
            const dateValue = dateFilter.value;
            
            for (let row of rows) {
                const rowText = row.textContent.toLowerCase();
                const statusBadge = row.querySelector('.badge');
                const dateCells = row.querySelectorAll('.invoice-date div');
                
                let statusMatch = !statusValue;
                let dateMatch = !dateValue;
                
                if (statusValue && statusBadge) {
                    statusMatch = statusBadge.textContent.toLowerCase().includes(statusValue);
                }
                
                if (dateValue && dateCells.length > 0) {
                    for (let cell of dateCells) {
                        if (cell.textContent.includes(dateValue)) {
                            dateMatch = true;
                            break;
                        }
                    }
                }
                
                row.style.display = (rowText.includes(searchText) && statusMatch && dateMatch) ? '' : 'none';
            }
        }
        
        // Event listeners
        searchInput?.addEventListener('keyup', filterInvoices);
        statusFilter?.addEventListener('change', filterInvoices);
        dateFilter?.addEventListener('change', filterInvoices);
        resetButton?.addEventListener('click', function() {
            searchInput.value = '';
            statusFilter.value = '';
            dateFilter.value = '';
            filterInvoices();
        });

        // Initialize tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    });
</script>
