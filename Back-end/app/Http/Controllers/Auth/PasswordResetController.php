<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordResetController extends Controller
{
    public function showForm()
    {
        return view('auth.reset-password');
    }

    public function simpleReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed'
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->with('error', 'E-mail não encontrado.');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        Auth::logout(); // força logout caso o usuário estivesse logado

        return redirect()->route('login')->with('success', 'Senha redefinida com sucesso!');
    }
}
