<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'position' => 'required|string|max:255',
            'role' => 'required|string|in:admin,manager,staff,user',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo_profile')) {
            $photoPath = $request->file('photo_profile')->store('photo_profiles', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'position' => $validated['position'],
            'role' => $validated['role'],
            'photo_profile' => $photoPath,
            'last_seen' => now(),
        ]);

        return redirect()->route('user.index')
            ->with('success', 'User created successfully');
    }

    public function edit(User $user, $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|string|email|max:255|unique:users,email,' . $id,
            'password'      => 'nullable|string|min:8|confirmed',
            'position'      => 'required|string|max:255',
            'role'          => 'required|string|in:admin,manager,staff,user',
            'photo_profile' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = User::findOrFail($id);

        if ($request->hasFile('photo_profile')) {
            if ($user->photo_profile && Storage::disk('public')->exists($user->photo_profile)) {
                Storage::disk('public')->delete($user->photo_profile);
            }
            $user->photo_profile = $request->file('photo_profile')->store('photo_profiles', 'public');
        }

        $user->name     = $request->name;
        $user->email    = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->position = $request->position;
        $user->role     = $request->role;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully');
    }

    public function search(Request $request)
    {
        $keyword = $request->keyword;
        $users = User::where('name', 'like', "%{$request->keyword}%")
            ->orWhere('email', 'like', "%{$request->keyword}%")
            ->orWhere('position', 'like', "%{$request->keyword}%")
            ->orWhere('role', 'like', "%{$request->keyword}%")
            ->orderBy('last_seen', 'DESC')
            ->paginate(10)
            ->appends(['keyword' => $request->keyword]);

        return view('users.index', compact('users'));
    }

    public function changePassword()
    {
        return view('users.change-password');
    }

    // public function updatePassword(Request $request)
    // {
    //     $request->validate([
    //         'current_password' => 'required',
    //         'new_password' => 'required|string|min:8|confirmed|different:current_password',
    //     ]);

    //     $user = Auth::user();

    //     if (!Hash::check($request->current_password, $user->password)) {
    //         return back()->with('error', 'Current password is incorrect');
    //     }

    //     $user->password = Hash::make($request->new_password);
    //     $user->save();

    //     return back()->with('success', 'Password changed successfully');
    // }

    public function destroy($id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Check if user is trying to delete themselves
        if (Auth::id() === $user->id) {
            return redirect()->route('user.index')
                ->with('error', 'You cannot delete your own account.');
        }

        // Hapus photo profile jika ada
        if ($user->photo_profile) {
            Storage::disk('public')->delete($user->photo_profile);
        }

        // Clear user cache jika ada
        if (Cache::has('user-is-online-' . $user->id)) {
            Cache::forget('user-is-online-' . $user->id);
        }

        // Hapus user
        $user->delete();

        return redirect()->route('user.index')
            ->with('danger', 'User deleted successfully');
    }
}
