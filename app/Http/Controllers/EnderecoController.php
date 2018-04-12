<?php

namespace App\Http\Controllers;

use App\Endereco;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EnderecoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Enderecos  $enderecos
     * @return \Illuminate\Http\Response
     */
    public function show(Enderecos $enderecos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Enderecos  $enderecos
     * @return \Illuminate\Http\Response
     */
    public function edit(Enderecos $enderecos)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Enderecos  $enderecos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Enderecos $enderecos)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Enderecos  $enderecos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Enderecos $enderecos)
    {
        //
    }
    public static function getBairro($id){
        $bairro=DB::table('bairros_sanca')->find($id);
        if(count($bairro))
            return $bairro->nome;
        else
            return "Não definido";
    }
    public function importarBairros(){
        $col_enderecos=collect();
        $nomes_comuns=[ 
            'felicia'=>'138'

        ];


        $bairros=DB::table('bairros_sanca')->get();
        foreach($bairros as $bairro){
            $enderecos=Endereco::where('bairro_str','like','%'.$bairro->nome.'%')->where('bairro',0)->orWhere("bairro", null)->get();
            if(count($enderecos)>0){
                foreach ($enderecos as $endereco){   
                        $endereco->bairro=$bairro->id;
                        $endereco->save();
                }
            }

        }
        $enderecos=Endereco::where('bairro_str','like','%felicia%')->where('bairro',0)->orWhere("bairro", null)->get();
            if(count($enderecos)>0){
                foreach ($enderecos as $endereco){   
                        $endereco->bairro=138;
                        $endereco->save();
                        $col_enderecos->push($endereco);
                }
            }

        return $col_enderecos;
        /*
        $enderecos=Endereco::where('bairro',0)->orWhere("bairro", null)->limit(100)->get();
        foreach($enderecos as $end){
            $bairro_str=$end->bairro_str;
            $bairro_arr=explode(' ',$bairro_str);
            switch(count($bairro_arr)){
                case 0:
                    break;
                case 1:
                   $bairro_id=DB::table('bairros_sanca')->where('nome','like','%'.$bairro_arr[0].'%')->get();
                   break;
                case 2:
                    $bairro_id=DB::table('bairros_sanca')->where('nome','like','%'.$bairro_arr[1].'%')->get();
                    break;
                case 3;
                    $bairro_id=DB::table('bairros_sanca')->where('nome','like','%'.$bairro_arr[1].' '.$bairro_arr[2].'%')->get();
                    break;
                default :
                    break;

            }


            if (count($bairro_id)==1)
                $end->bairro=$bairro_id;

        }
        return $enderecos;
        */


    }
    public function buscarBairro($valor=''){
        return DB::table('bairros_sanca')->where('nome','like','%'.$valor.'%')->limit(20)->get();
    }
}
