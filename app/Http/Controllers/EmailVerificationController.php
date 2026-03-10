<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function notice()
    {
        return view('auth.verify-email');
    }

    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('properties.index')->with('status', 'Tu correo ya estaba verificado.');
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return redirect()->route('properties.index')->with('status', '¡Tu correo ha sido verificado correctamente!');
    }

    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('properties.index')->with('status', 'Tu correo ya está verificado.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('status', 'Te hemos enviado un nuevo enlace de verificación.');
    }
}
