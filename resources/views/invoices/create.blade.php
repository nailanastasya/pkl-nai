@extends('templates.default')

@php
    $preTitle = 'Pages/';
    $title = 'Create Invoice';
@endphp

@push('page-action')
    <a href="{{ route('invoice.index') }}" class="btn btn-secondary">
        <i class="bx bx-arrow-back me-1"></i> Back to Invoices
    </a>
@endpush

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Create New Invoice</h3>
                    </div>
                    <form action="{{ route('invoice.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nodin</label>
                                        <select name="nodin_id" class="form-select @error('nodin_id') is-invalid @enderror" required>
                                            <option value="">Select Nodin</option>
                                            @foreach ($nodins as $nodin)
                                                <option value="{{ $nodin->id }}" {{ old('nodin_id') == $nodin->id ? 'selected' : '' }}>
                                                    {{ $nodin->nodin - $nodin->subject ?? $nodin->number  }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('nodin_id') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        @error('customer_product_id') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label required">Invoice Subject</label>
                                <input type="text" name="invoice_subject" class="form-control @error('invoice_subject') is-invalid @enderror"
                                    placeholder="Enter invoice subject" value="{{ old('invoice_subject') }}" required>
                                @error('invoice_subject') 
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label required">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror" rows="3" name="description" placeholder="Enter invoice description" required>{{ old('description') }}</textarea>
                                @error('description') 
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
                                        @error('amount') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Date</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                            name="date" value="{{ old('date', date('Y-m-d')) }}" required>
                                        @error('date') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label class="form-label required">Due Date</label>
                                        <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                                            name="due_date" value="{{ old('due_date', date('Y-m-d', strtotime('+30 days'))) }}" required>
                                        @error('due_date') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                        @error('status') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Invoice File</label>
                                        <input type="file" class="form-control @error('file_path') is-invalid @enderror" 
                                            name="file_path" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" required>
                                        <small class="form-hint">PDF, Word, or Image files only (Max: 5MB)</small>
                                        @error('file_path') 
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-end">
                            <button type="reset" class="btn btn-secondary">
                                <i class="bx bx-reset me-1"></i> Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="bx bx-plus me-1"></i> Create Invoice
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection