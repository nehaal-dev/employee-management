<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Employee Profile - {{ $employee->name }}
        </h2>
    </x-slot>

    <div class="container py-4">

        <a href="{{ route('admin.employees.index') }}" class="btn btn-outline-secondary btn-sm mb-3">
            &larr; Back to List
        </a>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white">
                <h5 class="mb-0">Basic Information</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 text-center mb-3">
                        @if ($employee->employeeProfile && $employee->employeeProfile->profile_photo)
                            <img src="{{ asset('storage/' . $employee->employeeProfile->profile_photo) }}"
                                 class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                        @endif
                    </div>
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6 mb-2"><strong>Name:</strong> {{ $employee->name }}</div>
                            <div class="col-md-6 mb-2"><strong>Email:</strong> {{ $employee->email }}</div>
                            @if ($employee->employeeProfile)
                                <div class="col-md-6 mb-2"><strong>Phone:</strong> {{ $employee->employeeProfile->phone_number }}</div>
                                <div class="col-md-6 mb-2"><strong>DOB:</strong> {{ $employee->employeeProfile->date_of_birth }}</div>
                                <div class="col-md-6 mb-2"><strong>Gender:</strong> {{ ucfirst($employee->employeeProfile->gender) }}</div>
                                <div class="col-md-6 mb-2"><strong>Address:</strong> {{ $employee->employeeProfile->address_line_1 }}, {{ $employee->employeeProfile->address_line_2 }}</div>
                                <div class="col-md-6 mb-2"><strong>City:</strong> {{ $employee->employeeProfile->city }}</div>
                                <div class="col-md-6 mb-2"><strong>State:</strong> {{ $employee->employeeProfile->state }}</div>
                                <div class="col-md-6 mb-2"><strong>Pincode:</strong> {{ $employee->employeeProfile->pincode }}</div>
                                <div class="col-md-6 mb-2"><strong>Country:</strong> {{ $employee->employeeProfile->country }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h5 class="mb-0">Education & Documents</h5>
            </div>
            <div class="card-body">
                @forelse ($employee->educations as $education)
                    <div class="border rounded p-3 mb-2">
                        <div class="row">
                            <div class="col-md-4"><strong>Certificate:</strong> {{ $education->certificate_name }}</div>
                            <div class="col-md-4"><strong>Institute:</strong> {{ $education->institute_name }}</div>
                            <div class="col-md-2"><strong>Year:</strong> {{ $education->year_of_completion }}</div>
                            <div class="col-md-2">
                                @if ($education->document_file)
                                    <a href="{{ asset('storage/' . $education->document_file) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        View File
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-muted mb-0">No education entries added.</p>
                @endforelse
            </div>
        </div>

    </div>
</x-app-layout>