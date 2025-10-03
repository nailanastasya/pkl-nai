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
                <form class="card" action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">  
                    @csrf
                    @method('PUT')
                    <div class="card-header">
                        <h4 class="card-title">Edit User</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Full Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           name="name" value="{{ old('name', $user->name) }}" placeholder="Enter full name" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Email Address</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $user->email) }}"
                                           name="email" placeholder="Enter email address" required>
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
                                    <input type="password" class="form-control @error('password') is-invalid @enderror disabled:" 
                                    value="{{ old('password', $user->password) }}"
                                           name="password" placeholder="Enter password" disabled>
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Confirm Password</label>
                                    <input type="password" class="form-control" 
                                           name="password_confirmation" value="{{ old('password_confirmation', $user->password) }}" placeholder="Confirm password" disabled>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Position</label>
                                    <input type="text" class="form-control @error('position') is-invalid @enderror" 
                                           name="position" value="{{ old('position', $user->position) }}" placeholder="Enter position" value="{{ old('position', $user->position) }}" required>
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label required">Role</label>
                                    <select class="form-select @error('role') is-invalid @enderror" name="role" value="{{ old('role', $user->role) }}" required>
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>

                                        <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Photo Profile</label>
                            <input type="file" class="form-control @error('photo_profile') is-invalid @enderror" value="{{ old('photo_profile', $user->photo_profile) }}"
                                   name="photo_profile" accept="image/jpeg,image/png,image/jpg,image/gif">
                            <small class="form-hint">Max file size: 2MB. Allowed formats: JPEG, PNG, JPG, GIF</small>
                            @error('photo_profile')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer text-end">
                        <a href="{{ route('user.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary ms-2">Update User</button>
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
