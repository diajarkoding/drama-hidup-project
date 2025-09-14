<?php

namespace App\Http\Controllers;

use App\Mail\VerifyEmailMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class VerificationController extends Controller
{
    public function verify(Request $request, $id, $hash)
    {
        // check signature & expiry already done by 'signed' middleware
        $user = User::findOrFail($id);

        // verify hash matches email (extra security)
        if (! hash_equals((string) $hash, sha1($user->email))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid verification link.',
                'errors' => null,
            ], 403);
        }

        if ($user->hasVerifiedEmail()) {
            // sudah terverifikasi
            return response()->json([
                'status' => 'success',
                'message' => 'Email already verified.',
            ], 200);
        }

        $user->markEmailAsVerified();

        // Jika ingin redirect ke front-end, lakukan redirect:
        // return redirect('https://your-frontend.example/verify-success');

        return response()->json([
            'status' => 'success',
            'message' => 'Email successfully verified. You can now login.',
        ], 200);
    }

    public function resend(Request $request)
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Email already verified.',
            ], 200);
        }

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addHours(24),
            [
                'id' => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        Mail::to($user->email)->send(new VerifyEmailMail($user, $verificationUrl));

        return response()->json([
            'status' => 'success',
            'message' => 'Verification email resent.',
        ], 200);
    }
}
