<?php

namespace App\Http\Controllers;

use App\Models\Education;
use App\Models\EmployeeProfile;
use Illuminate\Http\Request;
use App\Models\User;


class EmployeeProfileController extends Controller
{

    public function adminIndex()
    {
        $employees = User::whereHas('role', function ($query) {
            $query->where('name', 'employee');
        })->with('employeeProfile')->get();

        return view('admin.index', compact('employees'));
    }

    public function adminShow($id)
    {
        $employee = User::with('employeeProfile', 'educations')->findOrFail($id);

        return view('admin.show', compact('employee'));
    }


    public function create()
    {
        return view('employees.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            //'email' => 'required|email|max:150|unique:employees,email',
            'phone_number' => 'required|digits_between:10,15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'profile_photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:200',
            'pincode' => 'required|string|max:20',
            'country' => 'required|string|max:200',
            'certificate_name' => 'required|array',
            'certificate_name.*' => 'required|string|max:255',
            'institute_name' => 'required|array',
            'institute_name.*' => 'required|string|max:255',
            'year_of_completion' => 'required|array',
            'year_of_completion.*' => 'required|integer|min:1950|max:' . date('Y'),
            'document_file' => 'required|array',
            'document_file.*' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',

        ]);

        $imgpath = $request->file('profile_photo')->store('picture', 'public');


        // EmployeeProfile create
        EmployeeProfile::create([
            'user_id' => auth()->id(),
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'profile_photo' => $imgpath,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'country' => $request->country,
        ]);

        //Education entries  create using loop
        foreach ($request->certificate_name as $index => $certificateName) {
            $docpath = $request->file('document_file')[$index]->store('education_documents', 'public');

            Education::create([
                'user_id' => auth()->id(),
                'certificate_name' => $certificateName,
                'institute_name' => $request->institute_name[$index],
                'year_of_completion' => $request->year_of_completion[$index],
                'document_file' => $docpath,
            ]);
        }
    }

    public function show()
    {
        $employee = auth()->user()->load('employeeProfile', 'educations');
        return view('employees.show', compact('employee'));
    }

    public function edit()
    {
        $employee = auth()->user()->load('employeeProfile', 'educations');
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:200',
            'phone_number' => 'required|digits_between:10,15',
            'date_of_birth' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'address_line_1' => 'required|string|max:255',
            'address_line_2' => 'nullable|string|max:255',
            'city' => 'required|string|max:200',
            'state' => 'required|string|max:200',
            'pincode' => 'required|string|max:20',
            'country' => 'required|string|max:200',
            'certificate_name' => 'required|array',
            'certificate_name.*' => 'required|string|max:255',
            'institute_name' => 'required|array',
            'institute_name.*' => 'required|string|max:255',
            'year_of_completion' => 'required|array',
            'year_of_completion.*' => 'required|integer|min:1950|max:' . date('Y'),
            'document_file' => 'nullable|array',
            'document_file.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $employeeProfile = auth()->user()->employeeProfile;

        //  update photo when new file 
        $imgpath = $employeeProfile->profile_photo;
        if ($request->hasFile('profile_photo')) {
            $imgpath = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        $employeeProfile->update([
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'profile_photo' => $imgpath,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'country' => $request->country,
        ]);

        // Name update in users table 
        auth()->user()->update(['name' => $request->name]);

        // old education entries delete  , make new entry
        auth()->user()->educations()->delete();

        foreach ($request->certificate_name as $index => $certificateName) {

            if ($request->hasFile("document_file.$index")) {
                // Nayi file upload hui hai
                $docpath = $request->file('document_file')[$index]->store('education_documents', 'public');
            } else {
                // use old  file ka path   (hidden field)
                $docpath = $request->old_document_file[$index] ?? null;
            }

            Education::create([
                'user_id' => auth()->id(),
                'certificate_name' => $certificateName,
                'institute_name' => $request->institute_name[$index],
                'year_of_completion' => $request->year_of_completion[$index],
                'document_file' => $docpath,
            ]);
        }
        return redirect()->route('employees.show')->with('success', 'Profile updated successfully!');
    }

    public function destroy()
    {
        // filhaal zarurat nahi, "own profile create/edit/view" hi requirement hai, delete nahi
    }
}
