@extends('templates.default')

@php
    $title = 'Create New Nodin';

@endphp
@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <div class="card">
                    {{-- <div class="card-header">
                        <h3 class="card-title">Create New Nodin</h3>
                        <div class="card-actions">
                            <a href="{{ route('nodin.index') }}" class="btn btn-secondary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-arrow-left" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l14 0"></path>
                                    <path d="M5 12l6 6"></path>
                                    <path d="M5 12l6 -6"></path>
                                </svg>
                                Back to List
                            </a>
                        </div>
                    </div> --}}
                    <div class="card-body">
                        <form action="{{ route('nodin.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nodin</label>
                                        <input type="text" class="form-control @error('nodin') is-invalid @enderror" 
                                               name="nodin" value="{{ old('nodin') }}" placeholder="NODIN/2023/001" required>
                                        @error('nodin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Date</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                               name="date" value="{{ old('date') }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Subject</label>
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                               name="subject" value="{{ old('subject') }}" required>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                        <div class="mb-3">
    <label class="form-label">PO Number</label>
    <select class="form-control @error('purchase_order_id') is-invalid @enderror" 
            name="purchase_order_id">
        <option value="">Select PO Number</option>
        @foreach($purchaseOrders as $po)
           <option value="{{ $po->id }}">{{ $po->purchase_order_number }}</option>
        @endforeach
    </select>
    @error('purchase_order_id')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
                            
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="mb-3">
                                <label class="form-label required">File</label>
                                <input type="file" class="form-control @error('file_path') is-invalid @enderror" name="file_path" value="{{ old('file_path') }}">
                                @error('file_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            
                           
                            
                            <div class="form-footer">
                                <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                                <a href="{{ route('nodin.index') }}" class="btn btn-sm btn-secondary ms-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


<style>
    .required:after {
        content: " *";
        color: red;
    }
</style>