<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sala;
use App\Local;
use Hamcrest\Type\IsNumeric;

class SalaController extends Controller
{
    function sanitizeId($var){
        $var= htmlentities($var);
        if(!is_numeric($var))
            return redirect()->back()->withErrors(['ID inválido']);
    }

    public function listarPorLocal($id_local) {
        $this->sanitizeId($id_local);
        $salas = Sala::where('local',$id_local)->paginate(20);
        $local = Local::find($id_local);

  

        return view('admin.salas.lista',compact('salas'))->with('local',$local);
    }


    public function cadastrar($id_local){
        $this->sanitizeId($id_local);
        $local = Local::find($id_local);
        return view('admin.salas.cadastrar')->with('local',$local);
    }
}
