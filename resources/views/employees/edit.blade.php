<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Employee Profile
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="card shadow-sm">
            <div class="card-body">

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('employees.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')

                    <ul class="nav nav-tabs mb-4" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="basic-tab" data-bs-toggle="tab"
                                data-bs-target="#basic-info" type="button" role="tab">
                                1. Basic Information
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="education-tab" data-bs-toggle="tab" data-bs-target="#education"
                                type="button" role="tab">
                                2. Education & Documents
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="profileTabContent">

                        <div class="tab-pane fade show active" id="basic-info" role="tabpanel">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" name="name" class="form-control"
                                        value="{{ old('name', $employee->name) }}" required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" value="{{ $employee->email }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control"
                                        value="{{ old('phone_number', $employee->employeeProfile->phone_number) }}"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Date of Birth</label>
                                    <input type="date" name="date_of_birth" class="form-control"
                                        value="{{ old('date_of_birth', $employee->employeeProfile->date_of_birth) }}"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Gender</label>
                                    <select name="gender" class="form-select" required>
                                        <option value="">-- Select Gender --</option>
                                        <option value="male"
                                            {{ old('gender', $employee->employeeProfile->gender) == 'male' ? 'selected' : '' }}>
                                            Male</option>
                                        <option value="female"
                                            {{ old('gender', $employee->employeeProfile->gender) == 'female' ? 'selected' : '' }}>
                                            Female</option>
                                        <option value="other"
                                            {{ old('gender', $employee->employeeProfile->gender) == 'other' ? 'selected' : '' }}>
                                            Other</option>
                                    </select>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Profile Photo</label>
                                    <input type="file" name="profile_photo" class="form-control">
                                    @if ($employee->employeeProfile->profile_photo)
                                        <img src="{{ asset('storage/' . $employee->employeeProfile->profile_photo) }}"
                                            class="img-thumbnail mt-2"
                                            style="width: 80px; height: 80px; object-fit: cover;">
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address Line 1</label>
                                    <input type="text" name="address_line_1" class="form-control"
                                        value="{{ old('address_line_1', $employee->employeeProfile->address_line_1) }}"
                                        required>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Address Line 2</label>
                                    <input type="text" name="address_line_2" class="form-control"
                                        value="{{ old('address_line_2', $employee->employeeProfile->address_line_2) }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">City</label>
                                    <input type="text" name="city" class="form-control"
                                        value="{{ old('city', $employee->employeeProfile->city) }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">State</label>
                                    <input type="text" name="state" class="form-control"
                                        value="{{ old('state', $employee->employeeProfile->state) }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Pincode</label>
                                    <input type="text" name="pincode" class="form-control"
                                        value="{{ old('pincode', $employee->employeeProfile->pincode) }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label">Country</label>
                                    <input type="text" name="country" class="form-control"
                                        value="{{ old('country', $employee->employeeProfile->country) }}" required>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="button" class="btn btn-primary"
                                    onclick="document.getElementById('education-tab').click()">
                                    Next &rarr;
                                </button>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="education" role="tabpanel">

                            <div id="education-wrapper">
                                @forelse ($employee->educations as $education)
                                    <div class="education-entry border rounded p-3 mb-3">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Diploma / Certificate Name</label>
                                                <input type="text" name="certificate_name[]" class="form-control"
                                                    value="{{ $education->certificate_name }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Institute Name</label>
                                                <input type="text" name="institute_name[]" class="form-control"
                                                    value="{{ $education->institute_name }}">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Year of Completion</label>
                                                <input type="number" name="year_of_completion[]"
                                                    class="form-control" value="{{ $education->year_of_completion }}"
                                                    min="1950" max="{{ date('Y') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Upload File (leave empty to keep
                                                    existing)</label>
                                                <input type="file" name="document_file[]" class="form-control">
                                                <input type="hidden" name="old_document_file[]"
                                                    value="{{ $education->document_file }}">
                                                @if ($education->document_file)
                                                    <a href="{{ asset('storage/' . $education->document_file) }}"
                                                        target="_blank" class="d-block mt-1">
                                                        View current file
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button"
                                                    class="btn btn-outline-danger w-100 remove-entry">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="education-entry border rounded p-3 mb-3">
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Diploma / Certificate Name</label>
                                                <input type="text" name="certificate_name[]" class="form-control">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Institute Name</label>
                                                <input type="text" name="institute_name[]" class="form-control">
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Year of Completion</label>
                                                <input type="number" name="year_of_completion[]"
                                                    class="form-control" min="1950" max="{{ date('Y') }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label class="form-label">Upload File</label>
                                                <input type="file" name="document_file[]" class="form-control">
                                                <input type="hidden" name="old_document_file[]" value="">
                                            </div>
                                            <div class="col-md-2 d-flex align-items-end">
                                                <button type="button"
                                                    class="btn btn-outline-danger w-100 remove-entry">
                                                    Remove
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>

                            <button type="button" id="add-education" class="btn btn-outline-primary mb-3">
                                + Add Another Education
                            </button>

                            <div class="text-start mt-3">
                                <button type="button" class="btn btn-secondary"
                                    onclick="document.getElementById('basic-tab').click()">
                                    &larr; Back
                                </button>
                                <button type="submit" class="btn btn-success">
                                    Update Profile
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('education-wrapper');
            const addBtn = document.getElementById('add-education');

            addBtn.addEventListener('click', function() {
                const firstEntry = wrapper.querySelector('.education-entry');
                const newEntry = firstEntry.cloneNode(true);
                newEntry.querySelectorAll('input').forEach(input => input.value = '');
                newEntry.querySelectorAll('a').forEach(a => a.remove());
                wrapper.appendChild(newEntry);
            });

            wrapper.addEventListener('click', function(e) {
                if (e.target.classList.contains('remove-entry')) {
                    const entries = wrapper.querySelectorAll('.education-entry');
                    if (entries.length > 1) {
                        e.target.closest('.education-entry').remove();
                    } else {
                        alert('At least one education entry is required.');
                    }
                }
            });
        });
    </script>
</x-app-layout>
