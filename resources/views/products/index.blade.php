@extends('templates.default')

@push('create')
    <a href="{{route('product.create')}}" class="btn btn-primary me-2">

      <span class="icon-base bx bx-plus me-1"></span>Create New
        </a>
@endpush

@push('search')
 <form action="{{route('product.search')}}" method="GET" class="d-none d-md-block search-form w-100">
    <div class="input-group border-0 shadow-none">
        <span class="input-group-text bg-white border-0 shadow-none"><i class="bx bx-search"></i></span>
        <input type="text" name="keyword" value="{{request('keyword')}}" 
               class="form-control border-0 shadow-none" placeholder="Search Products ....">
    </div>
</form>
@endpush
@section('content')
<div class="card">
    <div class="card-body">
   <div class="table-responsive">
  <table class="table mb-0">
    <thead class="table-light">
      <tr>
        <th>Product</th>
        <th>Product Type</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
     @forelse ($products as $product)
          <tr>
        <td><i class="icon-base fab fa-angular text-danger me-4"></i> <span class="fw-medium">{{ucfirst($product->product_name)}}</span></td>
       
        <td>   <span class="badge bg-label-{{ $product->product_type === 'product' ? 'primary' : 'success' }}">
                       {{ ucfirst($product->product_type) }}
                    </span>
        </td>
        <td>
          <div class="dropdown">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="icon-base bx bx-dots-vertical-rounded"></i></button>
            <div class="dropdown-menu">
              <a class="dropdown-item" href="{{route('product.edit', $product->id)}}"><i class="icon-base bx bx-edit-alt me-1"></i>Edit</a>
          <form action="{{route('product.destroy', $product->id)}}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="dropdown-item"><i class="icon-base bx bx-trash me-1"></i>Delete</button>
          </form>
            </div>
          </div>
        </td>
      </tr>
     @empty
         <div class="col-12">
                            <div class="alert alert-dark text-center" role="alert" style="background-color: #e0e0e0">No Data Found</div>
                        </div>
     @endforelse
     
      
    </tbody>
  </table>
</div>
    </div>
</div>
    
@endsection