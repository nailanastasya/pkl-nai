@extends('templates.default')

@php
    $preTitle = "Customers";
    $title = "Customer List";
@endphp

@push('search')
 <form action="{{route('customer.search')}}" method="GET" class="d-none d-md-block search-form w-100">
    <div class="input-group border-0 shadow-none">
        <span class="input-group-text bg-white border-0 shadow-none"><i class="bx bx-search"></i></span>
        <input type="text" name="keyword" value="{{request('keyword')}}" 
               class="form-control border-0 shadow-none" placeholder="Search customers...">
    </div>
</form>
@endpush



@section('content')
<div class="row g-3">
    @forelse ($customers as $customer)
    <div class="col-md-6 col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="card-title mb-0">
                        <i class="bx bx-building text-primary me-2"></i>
                        {{ $customer->company_name }}
                        @if($customer->status == 'pending')
                            <span class="badge bg-warning ms-2">Pending</span>
                        @endif
                    </h5>
                    <div class="dropdown">
                        <button class="btn btn-sm p-0" type="button" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('customer.show', $customer->id) }}">
                                <i class="bx bx-show me-1"></i> View</a></li>
                            <li><a class="dropdown-item" href="{{ route('customer.edit', $customer->id) }}">
                                <i class="bx bx-edit me-1"></i> Edit</a></li>
                            <li>
                                <form  action="{{ route('customer.destroy', $customer->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bx bx-trash me-1"></i> Delete
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mb-3 small">
                    <div><i class="bx bx-envelope text-muted me-2"></i>{{ $customer->company_email }}</div>
                    <div><i class="bx bx-phone text-muted me-2"></i>{{ $customer->company_phone }}</div>
                    <div><i class="bx bx-map text-muted me-2"></i>{{ Str::limit($customer->billing_address, 25) }}</div>
                </div>

                <div class="d-flex justify-content-between small text-muted border-top pt-2">
                    <span><i class="bx bx-id-card me-1"></i> {{ $customer->npwp }}</span>
                    <span><i class="bx bx-barcode me-1"></i> {{ $customer->nib }}</span>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-light text-center py-4">
            <i class="bx bx-info-circle fs-4 text-secondary"></i>
            <p class="mb-1">No customers found</p>
            <a href="{{ route('customer.create') }}" class="btn btn-sm btn-primary">
                <i class="bx bx-plus"></i> Add Customer
            </a>
        </div>
    </div>
    @endforelse
</div>

@if(method_exists($customers, 'links'))
<div class="mt-3">
    {{ $customers->links() }}
</div>
@endif
@endsection