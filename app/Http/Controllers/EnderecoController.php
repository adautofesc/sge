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
}
