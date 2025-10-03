@extends('templates.default')

@php
    $title = 'Edit Customer';
    $preTitle = 'Customer Management';
@endphp

@section('content')
<div class="card">
    <div class="card-header">
        <h4 class="card-title mb-0">
            <i class="bx bx-edit me-2"></i>Edit Customer
        </h4>
    </div>
    <div class="card-body">
        <form action="{{ route('customer.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Left Column - Company Information -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-light-primary">
                            <h5 class="mb-0"><i class="bx bx-building me-2"></i>Company Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Company Name <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                    <input type="text" name="company_name" class="form-control @error('company_name') is-invalid @enderror" 
                                           placeholder="Enter company name" value="{{ old('company_name', $customer->company_name) }}" required>
                                </div>
                                @error('company_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Company Logo</label>
                                @if($customer->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/'.$customer->photo) }}" alt="Company Logo" class="img-thumbnail" width="100">
                                </div>
                                @endif
                                <div class="input-group">
                                    <input type="file" name="photo" class="form-control @error('photo') is-invalid @enderror">
                                </div>
                                <small class="text-muted">Upload company logo (max 2MB)</small>
                                @error('photo') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Company Email <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                        <input type="email" name="company_email" class="form-control @error('company_email') is-invalid @enderror" 
                                               placeholder="company@example.com" value="{{ old('company_email', $customer->company_email) }}" required>
                                    </div>
                                    @error('company_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Phone Number <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                        <input type="tel" name="company_phone" class="form-control @error('company_phone') is-invalid @enderror" 
                                               placeholder="0812-3456-7890" value="{{ old('company_phone', $customer->company_phone) }}" required>
                                    </div>
                                    @error('company_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Billing Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-map"></i></span>
                                    <textarea id="billing_address" name="billing_address" class="form-control @error('billing_address') is-invalid @enderror" 
                                              rows="2" placeholder="Complete billing address" required>{{ old('billing_address', $customer->billing_address) }}</textarea>
                                </div>
                                @error('billing_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="same_address_checkbox">
                                    <label class="form-check-label" for="same_address_checkbox">
                                        Operational address same as billing address
                                    </label>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Operational Address <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-map-alt"></i></span>
                                    <textarea id="operational_address" name="operational_address" class="form-control @error('operational_address') is-invalid @enderror" 
                                              rows="2" placeholder="Complete operational address" required>{{ old('operational_address', $customer->operational_address) }}</textarea>
                                </div>
                                @error('operational_address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NPWP Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                        <input type="text" name="npwp" id="npwp" class="form-control @error('npwp') is-invalid @enderror" 
                                               placeholder="12.345.678.9-012.345" value="{{ old('npwp', $customer->npwp) }}">
                                    </div>
                                    @error('npwp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">NIB Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-barcode"></i></span>
                                        <input type="text" name="nib" id="nib" class="form-control @error('nib') is-invalid @enderror" 
                                               placeholder="13-20 digit number" value="{{ old('nib', $customer->nib) }}" maxlength="20" pattern="\d{13,20}">
                                    </div>
                                    @error('nib') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Contact & Quotation -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header bg-light-info">
                            <h5 class="mb-0"><i class="bx bx-user-circle me-2"></i>Contact Person</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label">Contact Name <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-user"></i></span>
                                    <input type="text" name="contact_name" class="form-control @error('contact_name') is-invalid @enderror" 
                                           placeholder="Contact person name" value="{{ old('contact_name', $customer->contactPeople->first()->contact_name ?? '') }}" required>
                                </div>
                                @error('contact_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Email <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-envelope"></i></span>
                                        <input type="email" name="contact_email" class="form-control @error('contact_email') is-invalid @enderror" 
                                               placeholder="contact@example.com" value="{{ old('contact_email', $customer->contactPeople->first()->contact_email ?? '') }}" required>
                                    </div>
                                    @error('contact_email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Contact Phone <span class="text-danger">*</span></label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-mobile"></i></span>
                                        <input type="text" name="contact_phone" class="form-control @error('contact_phone') is-invalid @enderror" 
                                               placeholder="0812-3456-7890" value="{{ old('contact_phone', $customer->contactPeople->first()->contact_phone ?? '') }}" required>
                                    </div>
                                    @error('contact_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Position <span class="text-danger">*</span></label>
                                <div class="input-group input-group-merge">
                                    <span class="input-group-text"><i class="bx bx-briefcase"></i></span>
                                    <input type="text" name="contact_position" class="form-control @error('contact_position') is-invalid @enderror" 
                                           placeholder="Contact position" value="{{ old('contact_position', $customer->contactPeople->first()->contact_position ?? '') }}" required>
                                </div>
                                @error('contact_position') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4">
                        <div class="card-header bg-light-success">
                            <h5 class="mb-0"><i class="bx bx-file me-2"></i>Quotation Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Quotation Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-hash"></i></span>
                                        <input type="text" name="quotation_number" class="form-control @error('quotation_number') is-invalid @enderror" 
                                               placeholder="QUO/2023/001" value="{{ old('quotation_number', $customer->quotations->first()->quotation_number ?? '') }}">
                                    </div>
                                    @error('quotation_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Date</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror" 
                                               value="{{ old('date', $customer->quotations->first()->date ?? '') }}">
                                    </div>
                                    @error('date') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Quotation Document (Google Drive Link) <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bx bx-link"></i></span>
                                    <input type="url" 
                                        name="file_path" 
                                        id="driveLink"
                                        class="form-control @error('file_path') is-invalid @enderror"
                                        placeholder="https://drive.google.com/file/d/..."
                                        pattern="https:\/\/drive\.google\.com\/.*"
                                        value="{{ old('file_path', $customer->quotations->first()->file_path ?? '') }}"
                                        required>
                                    <button class="btn btn-outline-primary" type="button" id="previewDrive">
                                        <i class="bx bx-search-alt"></i> Preview
                                    </button>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <small class="text-muted">Paste shareable Google Drive link</small>
                                    <small id="linkHelp" class="text-muted"></small>
                                </div>
                                @error('file_path') 
                                    <div class="invalid-feedback d-block">{{ $message }}</div> 
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Product <span class="text-danger">*</span></label>
                                <select name="products[]" class="form-select select2" required>
                                    <option value="" disabled>Select product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                            @if($customer->customerProducts->contains('product_id', $product->id)) selected @endif>
                                            {{ $product->product_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subscription Period <span class="text-danger">*</span></label>
                                <select name="period" class="form-select" required>
                                    <option value="monthly" @if(old('period', $customer->period) == 'monthly') selected @endif>Monthly</option>
                                    <option value="yearly" @if(old('period', $customer->period) == 'yearly') selected @endif>Yearly</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-end mt-3">
                <a href="{{ route('customer.index') }}" class="btn btn-outline-secondary me-2">
                    <i class="bx bx-arrow-back me-1"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="bx bx-save me-1"></i> Update Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Same address checkbox functionality
        const checkbox = document.getElementById('same_address_checkbox');
        const billingInput = document.getElementById('billing_address');
        const operationalInput = document.getElementById('operational_address');

        // Initialize checkbox state if addresses match
        if (billingInput.value && billingInput.value === operationalInput.value) {
            checkbox.checked = true;
            operationalInput.readOnly = true;
        }

        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                operationalInput.value = billingInput.value;
                operationalInput.readOnly = true;
            } else {
                operationalInput.readOnly = false;
            }
        });

        billingInput.addEventListener('input', function () {
            if (checkbox.checked) {
                operationalInput.value = this.value;
            }
        });

        // Google Drive link validation
        const driveInput = document.getElementById('driveLink');
        const previewBtn = document.getElementById('previewDrive');
        const linkHelp = document.getElementById('linkHelp');

        if (driveInput.value.match(/https:\/\/drive\.google\.com\/.+/)) {
            driveInput.classList.add('is-valid');
            linkHelp.textContent = 'Valid Google Drive link';
            linkHelp.classList.add('text-success');
        }

        driveInput.addEventListener('input', function() {
            if(this.value.match(/https:\/\/drive\.google\.com\/.+/)) {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
                linkHelp.textContent = 'Valid Google Drive link';
                linkHelp.classList.remove('text-danger');
                linkHelp.classList.add('text-success');
            } else if(this.value.length > 0) {
                this.classList.add('is-invalid');
                linkHelp.textContent = 'Must be a Google Drive link';
                linkHelp.classList.add('text-danger');
            } else {
                this.classList.remove('is-valid');
                this.classList.remove('is-invalid');
                linkHelp.textContent = '';
            }
        });

        previewBtn.addEventListener('click', function() {
            if(driveInput.value && driveInput.checkValidity()) {
                window.open(driveInput.value, '_blank');
            }
        });

        // Initialize Select2 if available
        if (jQuery().select2) {
            $('.select2').select2({
                placeholder: 'Select product',
                allowClear: true
            });
        }
    });
</script>
@endpush