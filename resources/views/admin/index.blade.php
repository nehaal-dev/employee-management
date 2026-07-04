<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            All Employees
        </h2>
    </x-slot>

    <div class="container py-4">

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                @if ($employees->isEmpty())
                    <p class="text-muted text-center mb-0">No employees found yet.</p>
                @else
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Photo</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>City</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($employees as $index => $employee)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if ($employee->employeeProfile && $employee->employeeProfile->profile_photo)
                                            <img src="{{ asset('storage/' . $employee->employeeProfile->profile_photo) }}"
                                                 class="rounded-circle" style="width: 45px; height: 45px; object-fit: cover;">
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>{{ $employee->name }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>{{ $employee->employeeProfile->phone_number ?? '-' }}</td>
                                    <td>{{ $employee->employeeProfile->city ?? '-' }}</td>
                                    <td>
                                        @if ($employee->employeeProfile)
                                            <a href="{{ route('admin.employees.show', $employee->id) }}" class="btn btn-sm btn-primary">
                                                View Profile
                                            </a>
                                        @else
                                            <span class="badge bg-warning text-dark">Profile Incomplete</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>

    </div>
</x-app-layout>