@extends('templates.default')

@php
    $title = 'Tambah Produk';
    $preTitle = 'Manajemen Produk';
@endphp

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="mb-0">
                    <i class="bx bx-package me-1"></i>Tambah Produk Baru
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('product.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="product_name" 
                               class="form-control @error('product_name') is-invalid @enderror"
                               placeholder="Masukkan nama produk" 
                               value="{{ old('product_name') }}">
                        @error('product_name') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Jenis Produk</label>
                        <select name="product_type" 
                                class="form-select @error('product_type') is-invalid @enderror">
                            <option value="" selected>Pilih jenis produk</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ old('product_type') == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_type') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>

                    <div class="d-flex justify-content-between pt-2">
                        <a href="{{ route('product.index') }}" class="btn btn-light">
                            <i class="bx bx-arrow-back me-1"></i> Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bx bx-save me-1"></i> Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection