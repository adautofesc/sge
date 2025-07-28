<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CatracaController extends Controller
{
    public function sendData(){
        // https://dev.to/yasserelgammal/dive-into-laravel-sanctum-token-abilities-n8f
        // Implementation details would go here, such as fetching data from an external API
        // or database and updating the local records accordingly.

        $headers = getallheaders();


        if(!isset($headers['Authorization']) || $headers['Authorization'] !== 'cdEvWp6rqGCgisIZ2fzse2m20rgT6OyY1xy8SJxDva'){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $dados = [
    [
        "aluno_id" => 32132,
        "credencial" => 3914005,
        "horarios" => [
            ["13:00", "14:30"],
            ["16:00", "17:00"]
        ],
        "liberado" => true,
        "status" => "BOA AULA! FULANO",
        "admin" => false
    ],
    [
        "aluno_id" => 32133,
        "credencial" => 20859544,
        "horarios" => [
            ["13:00", "14:30"],
            ["16:00", "17:00"]
        ],
        "liberado" => true,
        "status" => "BOA AULA! CICLANO",
        "admin" => false
    ]
];

//return response()->json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return response()->json($dados, 200);
    }
}
