<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    public function create(){
        return view('users.create');
    }

    public function store(Request $request){        
        try {
            $imagemPath = null;
            
            if ($request->hasFile('imagemPerfil')) {
                $imagemPath = $request->file('imagemPerfil')->store('users', 'public');
            }

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'senha' => Hash::make($request->senha), 
                'imagemPerfil' => $imagemPath,
            ]);

            return redirect()->route('user.create')->with('success', 'Usuário cadastrado com sucesso!');
        
        } catch (Exception $e) {
            return back()->withInput()->with('error', 'Usuário não cadastrado! Erro: ' . $e->getMessage());
        }
    }
}