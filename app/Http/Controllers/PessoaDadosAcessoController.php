<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class PessoaDadosAcessoController extends Controller
{
    private const CARGOS = ['administrador',
                            'advogado',
                            'auxiliar_administrativo',
                            'aprendiz',
                            'assistente',
                            'chefia',
                            'contador',
                            'coordenador',
                            'desenvolvedor',
                            'diretor',
                            'educador',
                            'educador_parceria',
                            'estagiario',
                            'gestor',
                            'operacional',
                            'parceiro',
                            'presidente',
                            'prestador',
                            'tecnico'
                            ];

        private const auxiliar_administrativo = [1,3,4,19];
    public function nivelarAcesso(){
        

    }
}
