<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Mail\VerifyEmailMail;
use App\Models\User;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class AuthController extends Controller
{
    use ApiResponse;

    /**
     * Handle user registration.
     */
    public function register(RegisterRequest $request)
    {
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'profile_picture' => $profilePicturePath,
            'role' => 'user',
            'email_verified_at' => null,
        ]);

        // create signed verification URL (valid 24 hours)
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify', // route name
            now()->addHours(24),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        // send email (synchronous) — untuk produksi pindahkan ke queue
        Mail::to($user->email)->send(new VerifyEmailMail($user, $verificationUrl));

        // return response (user created but not yet active)
        return $this->success(
            [
                'user' => $user,
                'note' => 'Akun dibuat. Silakan cek email Anda untuk verifikasi sebelum login.',
            ],
            'Registration successful. Verification email sent.',
            201
        );
    }

    // public function register(RegisterRequest $request)
    // {
    //     $profilePicturePath = null;
    //     if ($request->hasFile('profile_picture')) {
    //         $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
    //     }

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'profile_picture' => $profilePicturePath,
    //         'role' => 'user',
    //     ]);

    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return $this->success([
    //         'user' => $user,
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //     ], 'Registration successful.', 201);
    // }

    /**
     * Handle user login.
     */
    public function login(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return $this->error('Invalid credentials.', null, 401);
        }

        if (! $user->hasVerifiedEmail()) {
            return $this->error('Akun Anda belum diverifikasi. Silakan cek email untuk verifikasi.', null, 403);
        }

        // Revoke previous tokens and create new
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return $this->success([
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer',
        ], 'Login successful', 200);
    }

    // public function login(LoginRequest $request)
    // {
    //     $user = User::where('email', $request->email)->first();

    //     if (! $user || ! Hash::check($request->password, $user->password)) {
    //         return $this->error('Invalid credentials.', null, 401);
    //     }

    //     $user->tokens()->delete();
    //     $token = $user->createToken('auth_token')->plainTextToken;

    //     return $this->success([
    //         'user' => $user,
    //         'access_token' => $token,
    //         'token_type' => 'Bearer',
    //     ], 'Login successful.', 200);
    // }

    /**
     * Handle user logout.
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->success(null, 'Successfully logged out.', 200);
    }
}
