@extends('templates.default')

@php
    $title = 'Users';
    $preTitle = "Pages/"
@endphp
@push('create')
    <a href="{{route('user.create')}}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Create New
    </a>
@endpush

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
                                <th>NAME</th>
                                <th>EMAIL</th>
                                <th>ROLE</th>
                                <th>STATUS</th>
                                <th>LAST SEEN</th>
                                <th class="w-1 text-center">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($users as $user)
                                <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($user->photo_profile)
                                            <img src="{{ asset('storage/' . $user->photo_profile) }}" class="avatar avatar-sm me-2 rounded-circle" alt="{{ $user->name }}">
                                        @else
                                            <div class="avatar avatar-sm me-2 bg-blue-lt">
                                                {{ ucfirst(substr($user->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="font-weight-bold">{{ ucfirst($user->name) }}</div>
                                            <div class="text-muted">{{ ucfirst($user->position) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-muted">{{ $user->email }}</td>
                                
                                <td>
                                    <span class="badge rounded-pill bg-{{ 
                                        $user->role == 'admin' ? 'success' : 
                                        ($user->role == 'user' ? 'primary' : 
                                        ($user->role == 'staff' ? 'warning' : 'danger')) 
                                    }} text-capitalize">
                                        {{ $user->role ?? 'Guest' }}
                                    </span>
                                </td>
                                <td>
                                    @if(Cache::has('user-is-online-' . $user->id))
                                        <span class="text-success">Online</span>
                                    @else
                                        <span class="text-secondary">Offline</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $user->last_seen ? Carbon\Carbon::parse($user->last_seen)->diffForHumans() : 'Never' }}
                                </td>
                 
                                <td class="text-center">
                                    <div class="btn-list flex-nowrap">
                                      @can('update', $user)
                                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-sm btn-outline-primary border" title="Edit">
                                           <i class="bx bx-pencil"></i>
                                        </a>
                                      @endcan
                                        @can('delete', $user)
                                           <button type="button" class="btn btn-sm btn-outline-danger border" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modal-danger-{{ $user->id }}"
                                        data-bs-tooltip="tooltip" data-bs-title="Delete Log">
                                    <i class="bx bx-trash"></i>
                                </button>
                                        @endcan
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
            <div class="card-footer d-flex align-items-center">
                <p class="m-0 text-muted">Showing <span>{{ $users->firstItem() }}</span> to <span>{{ $users->lastItem() }}</span> of <span>{{ $users->total() }}</span> entries</p>
                <ul class="pagination m-0 ms-auto">
                    <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1" aria-disabled="{{ $users->onFirstPage() ? 'true' : 'false' }}">
                            Previous
                        </a>
                    </li>
                    @foreach(range(1, $users->lastPage()) as $i)
                    <li class="page-item {{ $users->currentPage() == $i ? 'active' : '' }}">
                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                    </li>
                    @endforeach
                    <li class="page-item {{ !$users->hasMorePages() ? 'disabled' : '' }}">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-disabled="{{ !$users->hasMorePages() ? 'true' : 'false' }}">
                            Next
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Modal for each user -->
@foreach($users as $user)
<div class="modal modal-blur fade" id="modal-danger-{{ $user->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                <div class="text-muted">Do you really want to remove {{ $user->name }}? This action cannot be undone.</div>
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
                            <form action="{{ route('user.destroy', $user->id) }}" method="POST">
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

