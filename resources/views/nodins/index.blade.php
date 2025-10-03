@extends('templates.default')

@push('create')
    <a href="{{route('nodin.create')}}" class="btn btn-primary">
        <i class="bx bx-plus me-1"></i> Create New
    </a>
@endpush

@push('search')
 <form action="{{route('nodin.search')}}" method="GET" class="d-none d-md-block search-form w-100">
    <div class="input-group border-0 shadow-none">
        <span class="input-group-text bg-white border-0 shadow-none"><i class="bx bx-search"></i></span>
        <input type="text" name="keyword" value="{{request('keyword')}}" 
               class="form-control border-0 shadow-none" placeholder="Search nodins...">
    </div>
</form>
@endpush

@section('content')
    <div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-vcenter">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nomor</th>
                        <th>Subject</th>
                        <th>Date</th>
                        <th>PO Number</th>
                        {{-- <th>Status</th> --}}
                        <th class="text-center">File</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($nodins as $index => $nodin)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $nodin->nodin }}</td>
                            <td>{{ $nodin->subject }}</td>
                            <td>{{\Carbon\Carbon::parse($nodin->date)->format('d M Y') }}</td>
                            <td>  {{ $nodin->purchaseOrder?->purchase_order_number ?? '-' }}</td>
                                    {{-- <td>
                            @php
                                $statusColors = [
                                    'approved' => 'bg-success',
                                    'rejected' => 'bg-danger',
                                    'pending' => 'bg-warning',
                                ];
                                $dotColor = $statusColors[$nodin->status] ?? 'bg-secondary';
                            @endphp

                            <span class="badge me-1 {{ $dotColor }}"></span>
                            {{ ucfirst($nodin->status) }}

                          </td> --}}
                          <td class="text-center">
                            @if($nodin->file_path)
                            <i class='bx bx-file'></i> 
                              <a href="{{ asset('storage/' . $nodin->file_path) }}" class="btn btn-sm btn-outline-primary border" target="_blank" clas>Open</a>
                            @endif
                          </td>
                           <td class="text-center">
                                    <div class="btn-list flex-nowrap">
                                            <a href="{{ route('nodin.edit', $nodin->id) }}" class="btn btn-sm btn-outline-primary border" title="Edit">
                                           <i class="bx bx-pencil"></i>
                                        </a>
                                    
                                           <button type="button" class="btn btn-sm btn-outline-danger border" 
                                        data-bs-toggle="modal" 
                                          data-bs-target="#modal-danger-{{ $nodin->id }}"
                                        data-bs-tooltip="tooltip" data-bs-title="Delete Log">
                                    <i class="bx bx-trash"></i>
                                </button>
                                   
                                    </div>
                                </td>
                        </tr>

                         
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@foreach($nodins as $nodin)
<div class="modal modal-blur fade" id="modal-danger-{{ $nodin->id }}" tabindex="-1" role="dialog" aria-hidden="true">
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
                <div class="text-muted">Do you really want to remove {{ $nodin->nodin }}? This action cannot be undone.</div>
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
                            <form action="{{ route('nodin.destroy', $nodin->id) }}" method="POST">
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