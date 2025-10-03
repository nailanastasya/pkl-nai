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
                    <div class="card-body">
                        <form action="{{ route('nodin.update', $nodin->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Nodin</label>
                                        <input type="text" class="form-control @error('nodin') is-invalid @enderror" 
                                               name="nodin" value="{{ old('nodin', $nodin->nodin) }}" placeholder="NODIN/2023/001" required>
                                        @error('nodin')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Date</label>
                                        <input type="date" class="form-control @error('date') is-invalid @enderror" 
                                               name="date" value="{{ old('date', $nodin->date) }}" required>
                                        @error('date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label required">Subject</label>
                                        <input type="text" class="form-control @error('subject') is-invalid @enderror" 
                                               name="subject" value="{{ old('subject', $nodin->subject) }}" required>
                                        @error('subject')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                  <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">PO Number</label>
                                        <select class="form-control @error('purchase_order_id') is-invalid @enderror" 
                                                name="purchase_order_id">
                                            <option value="">Select PO Number</option>
                                            @foreach($purchaseOrders as $po)
                                            <option value="{{ $po->id }}" {{ old('purchase_order_id', $nodin->purchase_order_id) == $po->id ? 'selected' : '' }}>{{ $po->purchase_order_number }}</option>
                                            @endforeach
                                        </select>
                                        @error('purchase_order_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>  
                            <div class="mb-3">
                                <label class="form-label required">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror" name="status" required>
                                    <option value="">Select Status</option>
                                    <option value="pending" {{ old('status', $nodin->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ old('status', $nodin->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="rejected" {{ old('status', $nodin->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                             <div class="mb-3">
                                <label class="form-label required">File</label>
                                <input type="file" class="form-control @error('file_path') is-invalid @enderror" name="file_path" value="{{ old('file_path', $nodin->file_path) }}">
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
