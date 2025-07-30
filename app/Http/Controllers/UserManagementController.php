<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    // Manajemen Siswa
    public function students(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        
        $students = Student::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('nim', 'like', '%' . $request->search . '%')
                        ->orWhere('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('major', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->semester, fn($q) => $q->where('semester', $request->semester))
            ->when($request->major, fn($q) => $q->where('major', $request->major))
            ->orderBy('nim')
            ->paginate($perPage);

        $semesters = Student::distinct()->pluck('semester')->sort();
        $majors = Student::distinct()->pluck('major')->sort();

        return view('admin.users.students.index', compact('students', 'semesters', 'majors'));
    }

    public function createStudent()
    {
        return view('admin.users.students.create');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:students,nim',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|min:8',
            'major' => 'required|string',
            'semester' => 'required|integer|min:1|max:14',
        ]);

        Student::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'major' => $request->major,
            'semester' => $request->semester,
        ]);

        return redirect()->route('admin.users.students.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.users.students.edit', compact('student'));
    }

    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $request->validate([
            'nim' => ['required', Rule::unique('students', 'nim')->ignore($id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('students', 'email')->ignore($id)],
            'password' => 'nullable|min:8',
            'major' => 'required|string',
            'semester' => 'required|integer|min:1|max:14',
        ]);

        $data = [
            'nim' => $request->nim,
            'name' => $request->name,
            'email' => $request->email,
            'major' => $request->major,
            'semester' => $request->semester,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $student->update($data);

        return redirect()->route('admin.users.students.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.users.students.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }

    // Manajemen Koordinator/Admin
    public function admins(Request $request)
    {
        $perPage = $request->get('per_page', 10);
        
        $admins = Admin::query()
            ->when($request->search, function ($q) use ($request) {
                $q->where(function ($sub) use ($request) {
                    $sub->where('username', 'like', '%' . $request->search . '%')
                        ->orWhere('name', 'like', '%' . $request->search . '%')
                        ->orWhere('email', 'like', '%' . $request->search . '%')
                        ->orWhere('role', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->role, fn($q) => $q->where('role', $request->role))
            ->orderBy('name')
            ->paginate($perPage);

        $roles = Admin::distinct()->pluck('role')->sort();

        return view('admin.users.admins.index', compact('admins', 'roles'));
    }

    public function createAdmin()
    {
        return view('admin.users.admins.create');
    }

    public function storeAdmin(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:admins,username',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,coordinator',
        ]);

        Admin::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.users.admins.index')
            ->with('success', 'Data admin/koordinator berhasil ditambahkan.');
    }

    public function editAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.users.admins.edit', compact('admin'));
    }

    public function updateAdmin(Request $request, $id)
    {
        $admin = Admin::findOrFail($id);

        $request->validate([
            'username' => ['required', Rule::unique('admins', 'username')->ignore($id)],
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('admins', 'email')->ignore($id)],
            'password' => 'nullable|min:8',
            'role' => 'required|in:admin,coordinator',
        ]);

        $data = [
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.users.admins.index')
            ->with('success', 'Data admin/koordinator berhasil diperbarui.');
    }

    public function deleteAdmin($id)
    {
        $admin = Admin::findOrFail($id);
        $admin->delete();

        return redirect()->route('admin.users.admins.index')
            ->with('success', 'Data admin/koordinator berhasil dihapus.');
    }
}