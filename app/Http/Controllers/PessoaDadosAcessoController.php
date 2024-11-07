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
                            'secretario',
                            'tecnico'
                            ];

        private const auxiliar_administrativo = [1,3,4,5,9,12,18,19];
        private const secretario = [1,3,4,5,9,18,19];
        private const prestador = [3,4,18];// recepcionista
        private const chefia = [23,24,];//chefe adm
        private const contador = [23,24,];
        private const coordenador = [1,3,4,5,19];//coord. programas
        private const diretor = [1,3,4,5,19];
        private const assistente = [1,3,4,5,19];
        private const presidente = [1,3,4,5,19];
        private const educador = [1,3,4,5,19];
        private const educador_pareria = [1,3,4,5,19];
        
    public function nivelarAcesso(){
        

    }
}
