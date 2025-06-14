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
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Step 1: Validate inputs
        $request->validate([
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
                'unique:users,username',
                function ($attribute, $value, $fail) {
                    if (!preg_match('/^[a-zA-Z0-9-_]+$/', $value)) {
                        $fail("The $attribute can only contain letters, numbers, dashes, and underscores.");
                    }
                }
            ],
            'email' => ['required', 'string', 'email', 'lowercase', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:user,supplier,admin'],
            'kode_pendaftaran' => ['required', 'string'],
        ]);

        // Step 2: Validate registration code
        $kodeValid = match ($request->role) {
            'user' => env('KODE_PENDAFTARAN_USER'),
            'supplier' => env('KODE_PENDAFTARAN_SUPPLIER'),
            'admin' => env('KODE_PENDAFTARAN_ADMIN'),
            default => null,
        };

        if ($request->kode_pendaftaran !== $kodeValid) {
            return back()->withErrors([
                'kode_pendaftaran' => 'Kode pendaftaran salah untuk role yang dipilih!'
            ])->withInput();
        }

        // Step 3: Create the user
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        event(new Registered($user));
        Auth::login($user);

        return redirect()->route('barangs.index')->with('success', "Berhasil mendaftar sebagai {$user->role}!");
    }
}