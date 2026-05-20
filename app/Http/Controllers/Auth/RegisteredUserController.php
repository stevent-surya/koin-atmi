<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nim' => ['required', 'string', 'size:8', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'nim.size' => 'NIM harus terdiri dari 8 digit angka.',
            'nim.unique' => 'NIM ini sudah terdaftar dalam sistem.',
        ]);

        $nim = $request->nim;
        $angkatan = substr($nim, 0, 4);
        $prodiCode = substr($nim, 4, 1);
        $prodiList = User::getProdiList();
        $prodiName = $prodiList[$prodiCode] ?? 'Prodi Tidak Diketahui';

        $user = User::create([
            'name' => $request->name,
            'nim' => $nim,
            'angkatan' => $angkatan,
            'prodi' => $prodiName,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'coins' => 10,
            'role' => 'mahasiswa',
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}