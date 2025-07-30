<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Student;
use App\Models\Admin;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showStudentLogin()
    {
        return view('auth.student-login');
    }

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function studentLogin(Request $request)
    {
        $request->validate([
            'nim' => 'required',
            'password' => 'required',
        ]);

        $student = Student::where('nim', $request->nim)->first();

        if ($student && Hash::check($request->password, $student->password)) {
            Auth::guard('student')->login($student);
            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'nim' => 'NIM atau password salah.',
        ]);
    }

    public function adminLogin(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            Auth::guard('admin')->login($admin);
            return redirect()->intended('/admin/dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::guard('student')->check()) {
            Auth::guard('student')->logout();
        } elseif (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
