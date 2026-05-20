<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'mahasiswa');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('nim', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('angkatan')) {
            $query->where('angkatan', $request->angkatan);
        }

        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        }

        $students = $query->latest()->paginate(15)->appends($request->query());
        $prodiList = User::getProdiList();
        $angkatanList = User::select('angkatan')->distinct()->orderBy('angkatan', 'desc')->pluck('angkatan');

        return view('admin.students.index', compact('students', 'prodiList', 'angkatanList'));
    }

    public function show(User $student)
    {
        $borrowings = Borrowing::with('item')->where('user_id', $student->id)->latest()->get();
        return view('admin.students.show', compact('student', 'borrowings'));
    }

    public function toggleSuspend(Request $request, User $student)
    {
        if ($student->role === 'admin') {
            return back()->with('error', 'Admin tidak bisa di-suspend.');
        }

        // Jika ingin Suspend (butuh alasan)
        if (!$student->is_suspended) {
            $request->validate([
                'suspend_reason' => 'required|string|max:255',
            ], [
                'suspend_reason.required' => 'Alasan suspend wajib diisi.'
            ]);

            $student->update([
                'is_suspended' => true,
                'suspend_reason' => $request->suspend_reason,
            ]);

            return back()->with('success', "Akun mahasiswa berhasil disuspend.");
        } 
        
        // Jika ingin Unsuspend (hapus alasan)
        else {
            $student->update([
                'is_suspended' => false,
                'suspend_reason' => null,
            ]);

            return back()->with('success', "Akun mahasiswa berhasil di-unsuspend.");
        }
    }

    public function resetPassword(Request $request, User $student)
    {
        $request->validate([
            'new_password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $student->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', "Password mahasiswa {$student->name} berhasil direset!");
    }
}