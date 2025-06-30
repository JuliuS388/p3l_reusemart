<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Pembeli;
use App\Models\Penitip;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('pegawai.index');
                case 'owner':
                    return redirect()->route('request-donasi.index');
                case 'gudang':
                    return redirect()->route('barang.index');
                case 'cs':
                    return redirect()->route('tukarmerch.index');
                case 'pembeli':
                    $pembeli = Pembeli::with('alamat')->where('id_user', $user->id_user)->first();

                    if ($pembeli) {
                        session(['pembeli' => $pembeli]); 
                        return redirect()->route('home'); 
                    } else {
                        Auth::logout();
                        return redirect()->route('login.form')->with('error', 'Data pembeli tidak ditemukan.');
                    }
                case 'penitip':
                    $penitip = Penitip::where('id_user', $user->id_user)->first();

                    if ($penitip) {
                        session(['penitip' => $penitip]); 
                        return redirect()->route('penitip.penarikan-saldo.form');
                    } else {
                        Auth::logout();
                        return redirect()->route('login.form')->with('error', 'Data penitip tidak ditemukan.');
                    }
                default:
                    Auth::logout();
                    return redirect()->route('login.form')->with('error', 'Role tidak dikenali.');
            }
        }

        return back()->with('error', 'Email atau password salah.');
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
        ]);

        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('login.form')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    public function logout()
    {
        Auth::logout();
        session()->forget(['pembeli', 'penitip']); 
        return redirect()->route('login.form');
    }


    public function apiLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if (!$user || !\Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Email atau password salah',
            ], 401);
        }

        if ($user->role === 'pembeli' || $user->role === 'penitip') {
            if ($user->role === 'pembeli') {
                $pembeli = \App\Models\Pembeli::where('id_user', $user->id_user)->first();
                if (!$pembeli) {
                    return response()->json([
                        'message' => 'Data pembeli tidak ditemukan',
                    ], 404);
                }
                return response()->json([
                    'message' => 'Login berhasil',
                    'role' => $user->role,
                    'user' => [
                        'id_user' => $user->id_user,
                        'email' => $user->email,
                        'nama' => $pembeli->nama_pembeli,
                        'id_pembeli' => $pembeli->id_pembeli,
                    ],
                ]);
            } else {
                $penitip = Penitip::where('id_user', $user->id_user)->first();
                if (!$penitip) {
                    return response()->json([
                        'message' => 'Data penitip tidak ditemukan',
                    ], 404);
                }
                return response()->json([
                    'message' => 'Login berhasil',
                    'role' => $user->role,
                    'user' => [
                        'id_user' => $user->id_user,
                        'email' => $user->email,
                        'nama' => $penitip->nama_penitip,
                        'id_penitip' => $penitip->id_penitip,
                    ],
                ]);
            }
        }

        return response()->json([
            'message' => 'Role tidak diizinkan',
        ], 403);
    }
}