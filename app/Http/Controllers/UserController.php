<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('name')->paginate(10);

        $data = [
            'title' => 'Manajemen User',
            'breadcrumbs' => [
                ['label' => 'Manajemen User', 'url' => route('users.index')],
            ],
            'users' => $users
        ];

        return view('admin.users.index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah User',
            'breadcrumbs' => [
                ['label' => 'Manajemen User', 'url' => route('users.index')],
                ['label' => 'Tambah User', 'url' => route('users.create')],
            ],
        ];

        return view('admin.users.create', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,dokter,perawat,registrasi',
            'phone' => 'nullable|string|max:15'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'phone' => $request->phone,
            'is_active' => true
        ]);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        $data = [
            'title' => 'Edit User',
            'breadcrumbs' => [
                ['label' => 'Manajemen User', 'url' => route('users.index')],
                ['label' => 'Edit User', 'url' => route('users.edit', $user->getKey())],
            ],
            'user' => $user
        ];

        return view('admin.users.edit', $data);
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->getKey(),
            'password' => 'nullable|min:6|confirmed',
            'role' => 'required|in:admin,dokter,perawat,registrasi',
            'phone' => 'nullable|string|max:15'
        ]);

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'phone' => $request->phone
        ];

        if ($request->password) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->getKey() === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }

    public function toggleStatus(User $user)
    {
        // Prevent admin from deactivating themselves
        if ($user->getKey() === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menonaktifkan akun sendiri.');
        }

        $user->update(['is_active' => !$user->is_active]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('users.index')->with('success', "User berhasil $status.");
    }

    public function logout(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}