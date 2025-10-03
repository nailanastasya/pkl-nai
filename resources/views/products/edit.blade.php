@extends('templates.default')

@php
$title = "Edit Product Data";
@endphp

@section('content')

  <div class="card col-md-6">
    <div class="card-body">
        <form action="{{ route('product.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row ">
               <a href="{{ route('product.index') }}" class="btn btn-close"></a>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label">Nama Produk</label>
                        <input type="text" name="product_name" class="form-control @error('product_name') is-invalid @enderror"
                               placeholder="Masukkan Nama Produk" value="{{ old('product_name', $product->product_name) }}">
                        @error('product_name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Product Type</label>
                        <select name="product_type" class="form-control @error('product_type') is-invalid @enderror">
                            <option value="">-- Pilih Tipe Produk --</option>
                            @foreach ($types as $type)
                                <option value="{{ $type }}" {{ old('product_type', $product->product_type) == $type ? 'selected' : '' }}>
                                    {{ ucfirst($type) }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_type') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                       
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection