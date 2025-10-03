@extends('templates.default')

@php
    $title = 'Purchase Orders';
    $preTitle = "Pages/ "
@endphp
{{-- @push('create')
    <a href="{{route('user.create')}}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Create New
    </a>
@endpush --}}

@push('search')
 <form action="{{route('user.search')}}" method="GET" class="d-none d-md-block search-form w-100">
    <div class="input-group border-0 shadow-none">
        <span class="input-group-text bg-white border-0 shadow-none"><i class="bx bx-search"></i></span>
        <input type="text" name="keyword" value="{{request('keyword')}}" 
               class="form-control border-0 shadow-none" placeholder="Search users...">
    </div>
</form>
@endpush
@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <div class="col-md-2 d-flex ">
                          {{-- <span class=""><i class='bx  bx-menu-filter'  ></i> </span>
                        
                      <select id="filter-tahun" class="form-control filter">
                      
                        <option value="">Filter</option>
                        
                      </select> --}}
                  </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter table-mobile-md card-table">
                        <thead>
                            <tr>
                                <th>Company Name</th>
                                <th>Product Name</th>
                                <th>Date</th>
                                <th>Po Number</th>
                                <th>File</th>
                                <th class="w-1 text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($purchaseOrders as $po)
                                <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div>
                                            <div class="text-muted">{{ ucfirst($po->customer->company_name) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">
                                     @forelse($po->customer->customerProducts as $cp)
                                        {{ ucfirst($cp->product->product_name) }}@if(!$loop->last), @endif
                                    @empty
                                        <span class="text-danger">No product</span>
                                    @endforelse
                                </td>
                                <td>
                                   {{ $po->date }}
                                </td>
                                     <td>{{ $po->purchase_order_number }}</td>
                                
                                <td>  
                                    <a href="{{ asset('storage/' . $po->file_path) }}" class="btn btn-sm btn-outline-primary" target="_blank">Purchase Order</a>
                                </td>
                                <td class="text-center">
                                    <div class="btn-list flex-nowrap">
                                      {{-- @can('update', $user)
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-outline-primary border" title="Edit">
                                           <i class="bx bx-pencil"></i>
                                        </a>
                                      @endcan --}}
                                   
                                        <button type="button" class="btn btn-sm btn-outline-danger border" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-danger-{{ $po->id }}"
                                        data-bs-tooltip="tooltip" data-bs-title="Delete Log">
                                    <i class="bx bx-trash"></i>
                                </button>
                                       
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr class="text-center">
                                <td colspan="8">No users found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Showing <span>{{ $purchaseOrders->firstItem() }}</span> to <span>{{ $purchaseOrders->lastItem() }}</span> of <span>{{ $purchaseOrders->total() }}</span> entries</p>
                <ul class="pagination m-0 ms-auto">
                    <li class="page-item {{ $purchaseOrders->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $purchaseOrders->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $purchaseOrders->onFirstPage() ? 'true' : 'false' }}">
                            Previous
                        </a>
                    </li>
                    @foreach(range(1, $purchaseOrders->lastPage()) as $i)
                    <li class="page-item {{ $purchaseOrders->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $purchaseOrders->url($i) }}">{{ $i }}</a>
                    </li>
                    @endforeach
                    <li class="page-item {{ !$purchaseOrders->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $purchaseOrders->nextPageUrl() }}" aria-disabled="{{ !$purchaseOrders->hasMorePages() ? 'true' : 'false' }}">
                            Next
                        </a>
                    </li>
                </ul>
            </div> --}}
        </div>
    </div>
</div>

<!-- Modal for each user -->
@foreach($purchaseOrders as $po)
<div class="modal modal-blur fade" id="modal-danger-{{ $po->id }}" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
               
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                    <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                <h3>Are you sure?</h3>
                <div class="text-muted">Do you really want to remove {{ $po->po_number }}? This action cannot be undone.</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button type="button" class="btn w-100" data-bs-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                        <div class="col">
                            <form action="{{ route('purchase-order.destroy', $po->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection