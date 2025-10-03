@extends('templates.default')

@php
    $title = 'History ';
    $preTitle = "Pages/"
@endphp


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
                    
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-vcenter table-mobile-md card-table">
                        <thead>
                            <tr>
                                <th class="text-center">Timestamps</th>
                                <th>User</th>
                                <th>Action</th>
                                <th>Description</th>
                                <th class=" text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logs as $log)
                            <tr>
                                <td class="text-center">{{ $log->created_at->format('d-m-Y H:i') }}</td>
                                <td class="text-muted">{{$log->user->name ?? 'Guest'}}</td>
                                
                                <td>
                                    <span class="badge rounded-pill bg-{{ 
                                        $log->action == 'created' ? 'success' : 
                                        ($log->action == 'updated' ? 'primary' : 
                                        ($log->action == 'deleted' ? 'danger' : 'warning')) 
                                    }} text-capitalize">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td>
                                    {{ $log->description }}
                                </td>
                 
                                
                                     <td class="text-center pe-4 ">
                            {{-- Manual authorization check untuk delete --}}
                            @if(Auth::user()->role === 'admin')
                            <div class="btn-group gap-2 r">
                                {{-- <button type="button" class="btn btn-sm btn-outline-primary border" 
                                        data-bs-toggle="tooltip" data-bs-title="View Details">
                                    <i class="bx bx-pencil"></i>
                                </button> --}}
                                <button type="button" class="btn btn-sm btn-outline-danger border" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-danger-{{ $log->id }}"
                                        data-bs-tooltip="tooltip" data-bs-title="Delete Log">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                            @else
                            <span class="text-muted small">No action</span>
                            @endif
                        </td>
                               
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Showing <span>{{ $logs->firstItem() }}</span> to <span>{{ $logs->lastItem() }}</span> of <span>{{ $logs->total() }}</span> entries</p>
                <ul class="pagination m-0 ms-auto">
                    <li class="page-item {{ $logs->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $logs->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $logs->onFirstPage() ? 'true' : 'false' }}">
                            Previous
                        </a>
                    </li>
                    @foreach(range(1, $logs->lastPage()) as $i)
                    <li class="page-item {{ $logs->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $logs->url($i) }}">{{ $i }}</a>
                    </li>
                    @endforeach
                    <li class="page-item {{ !$logs->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $logs->nextPageUrl() }}" aria-disabled="{{ !$logs->hasMorePages() ? 'true' : 'false' }}">
                            Next
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal for each user -->
@foreach($logs as $log)
<div class="modal modal-blur fade" id="modal-danger-{{ $log->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                <div class="text-muted">Do you really want to remove {{ $log->description }}? This action cannot be undone.</div>
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
                            <form action="{{ route('log.destroy', $log->id) }}" method="POST">
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