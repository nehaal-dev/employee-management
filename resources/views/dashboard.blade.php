<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="container py-5">

        @if (session('success'))
            <div class="alert alert-success shadow-sm">{{ session('success') }}</div>
        @endif

        @if (auth()->user()->role->name === 'admin')
            {{-- ADMIN VIEW --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <h2 class="fw-bold mb-2">
                        Welcome back, <span class="text-primary">{{ auth()->user()->name }}</span> 👋
                    </h2>
                    <p class="text-muted fs-5 mb-4">You're logged in as <strong>Admin</strong></p>

                    <hr class="my-4">

                    <p class="text-secondary mb-4">Manage and review all employee profiles from one place.</p>

                    <a href="{{ route('admin.employees.index') }}" class="btn btn-primary btn-lg px-4">
                        View All Employees
                    </a>
                </div>
            </div>
        @else
            {{-- EMPLOYEE VIEW --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body p-5 text-center">
                    <h2 class="fw-bold mb-2">
                        Welcome, <span class="text-primary">{{ auth()->user()->name }}</span> 
                    </h2>
                    <p class="text-muted fs-5 mb-4">You're logged in as <strong>Employee</strong></p>

                    <hr class="my-4">

                    @if (auth()->user()->employeeProfile)
                        <p class="text-success mb-4"> Your profile is complete.</p>
                        <a href="{{ route('employees.show') }}" class="btn btn-primary btn-lg px-4 me-2">
                            View My Profile
                        </a>
                        <a href="{{ route('employees.edit') }}" class="btn btn-outline-secondary btn-lg px-4">
                            Edit Profile
                        </a>
                    @else
                        <p class="text-warning mb-4"> You haven't created your profile yet.</p>
                        <a href="{{ route('employees.create') }}" class="btn btn-success btn-lg px-4">
                            Create Profile
                        </a>
                    @endif
                </div>
            </div>
        @endif

    </div>
</x-app-layout>