@extends('templates.default')

@php
    $title = 'Add New User';
    $preTitle = 'Users/';
@endphp

@section('content')
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <div class="col-12">
                <form class="card" action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card-header">
                        <h4 class="card-title">Add New User</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name') }}" placeholder="Enter full name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                           name="email" value="{{ old('email') }}" placeholder="Enter email address" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Password</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           name="password" placeholder="Enter password" required>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Confirm Password</label>
                                    <input type="password" class="form-control" 
                                           name="password_confirmation" placeholder="Confirm password" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Position</label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                           name="position" value="{{ old('position') }}" placeholder="Enter position" required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Role</label>
                                    <select class="form-select @error('role') is-invalid @enderror" name="role" required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>

                                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Photo Profile</label>
                            <input type="file" class="form-control @error('photo_profile') is-invalid @enderror" 
                                   name="photo_profile" accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="form-hint">Max file size: 2MB. Allowed formats: JPEG, PNG, JPG, GIF</small>
                            @error('photo_profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-2">Create User</button>
                    </div>
                </form>
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
    .form-hint {
        font-size: 0.75rem;
        color: #6c757d;
        margin-top: 0.25rem;
    }
</style>
