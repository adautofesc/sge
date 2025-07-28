<?php

namespace App\Http\Controllers\Auth;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Auth;


class TokenController extends Controller
{
    public function gerarToken(Request $request){

        if(!Auth::user()) {
            return response()->json(['message' => 'Login não encontrado'], 200);
            //return redirect()->route('login');
        }
        
        $user = User::find(Auth::user()->id); // exemplo
        $token = $user->createToken('api-token', ['catraca'])->plainTextToken;
        return response()->json(['token' => $token], 200);



    }

    public function apagarToken(){

        if(!Auth::user()) {
            return redirect()->route('login');
        }

        $user = User::find(Auth::user()->id); // exemplo
        $user->tokens()->delete();
        return response()->json(['message' => 'Tokens apagado com sucesso'], 200);

    }


}