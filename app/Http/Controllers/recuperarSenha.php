<?php

namespace App\Http\Controllers;
use App\Mail\RecuperarSenha as recuperarSenhaEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;

use Illuminate\Http\Request;


class RecuperarSenha extends Controller
{
    //
    public function index(Request $request)
    {
       
        $email = $request->email;
        
        $user = User::where('email', $email)->first();
        if (!$user) {
            return back()->withErrors(['error'=>'Email não encontrado']);
        }
        // dd('ola');

        // Gerar senha temporária
        $novaSenha = Str::random(8); // gera uma senha aleatória de 8 caracteres
        
        $user->password = bcrypt($novaSenha);
        $user->save();

        // Enviar email
        Mail::to($user->email)->send(new recuperarSenhaEmail($novaSenha));

        return back()->with('success', 'Uma nova senha foi enviada para o seu email.');
    }
}
