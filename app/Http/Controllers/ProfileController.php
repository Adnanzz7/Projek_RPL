<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();
    
        if ($request->action === 'update_profile') {
            // Ganti spasi di username sebelum validasi
            $request->merge([
                'username' => str_replace(' ', '_', $request->input('username'))
            ]);

            $validatedData = $request->validate([
                'name' => [
                    'required', 
                    'string', 
                    'max:255',
                    function ($attribute, $value, $fail) {
                        $forbiddenWords = ['root', 'fuck', 'bitch', 'shit', 'god', 'owner'];
                        foreach ($forbiddenWords as $word) {
                            if (stripos($value, $word) !== false) {
                                $fail("The $attribute contains forbidden words like \"$word\".");
                                return;
                            }
                        }
                    }
                ],
                'username' => [
                    'required', 
                    'string', 
                    'max:255',
                    'regex:/^[a-zA-Z0-9-_]+$/',
                    'unique:users,username,' . $user->id
                ],
                'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'foto' => [
                    'nullable',
                    'image',
                    'mimes:jpeg,png,jpg,gif',
                    'max:4096',
                ],
                'birth_date' => ['nullable', 'date'],
                'about' => ['nullable', 'string', 'max:500'],
            ], [
                'username.unique' => 'Username sudah digunakan. Silakan pilih yang lain.',
                'email.unique' => 'Email sudah terdaftar. Silakan gunakan yang lain.',
            ]);
    
            // Cek apakah pengguna ingin kembali ke username sebelumnya
            if ($request->input('restore_username') && $previousUsername !== $request->input('username')) {
                // Pastikan username yang ingin dipulihkan tidak digunakan oleh orang lain
                $existingUser = User::where('username', $previousUsername)->first();
                if ($existingUser) {
                    // Kembalikan username ke yang lama
                    $validatedData['username'] = $previousUsername;
                } else {
                    return Redirect::route('profile.edit')->withErrors([
                        'username' => 'Username sebelumnya sudah digunakan oleh pengguna lain.'
                    ]);
                }
            }
    
            // Update data pengguna
            $user->update($validatedData);
    
            // Jika email diperbarui, set email_verified_at menjadi null
            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }
        }
    
        if ($request->action === 'update_password') {
            // Validasi untuk pembaruan password
            $validatedData = $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required', 'string', 'min:8', 'confirmed'],
            ]);
    
            // Cek password lama
            if (!Hash::check($validatedData['current_password'], $user->password)) {
                return Redirect::route('profile.edit')->withErrors([
                    'current_password' => 'Password lama salah.'
                ]);
            }
    
            // Update password
            $user->password = Hash::make($validatedData['new_password']);
            $user->save();
    
            return Redirect::route('profile.edit')->with('status', 'Password berhasil diperbarui.');
        }
    
        return Redirect::route('profile.edit')->withErrors(['action' => 'Aksi tidak valid.']);
    } 
    
    public function uploadFoto(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = auth()->user();

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $file = $request->file('foto');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('photos', $filename, 'public');

        $user->foto = $path;
        $user->save();

        return response()->json([
            'status' => 'success',
            'foto_url' => Storage::url($user->foto),
        ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display profile index with different views based on user role.
     */
    public function index()
    {
        $user = auth()->user();

        if (in_array($user->role, ['admin', 'supplier'])) {
            // For admin or seller, show list of barangs (items)
            $barangs = \App\Models\Barang::where('user_id', $user->id)->get();
            return view('profile.index', compact('user', 'barangs'));
        } else {
            // For normal user, show simple profile info
            return view('profile.index', compact('user'));
        }
    }

    /**
     * Display the specified user's profile.
     */
    public function show($id)
    {
        $user = \App\Models\User::with('barangs')->findOrFail($id);
        $authUserId = auth()->id();
        // Paginate barangs instead of loading all
        $barangs = $user->barangs()->paginate(9);
        return view('profile.show', compact('user', 'authUserId', 'barangs'));
    }
}
