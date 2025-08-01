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
        //dd($headers);


        if(!isset($headers['Token']) || $headers['Token'] !== 'cdEvWp6rqGCgisIZ2fzse2m20rgT6OyY1xy8SJxDva'){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $dados = [
    [
        "aluno_id" => 32132,
        "credencial" => 3914005,
        "horarios" => [
            ["13:00", 1],
            ["16:00", 3]
        ],
        "liberado" => true,
        "status" => "BOA AULA! FULANO",
        "admin" => false
    ],
    [
        "aluno_id" => 32133,
        "credencial" => 20859544,
        "horarios" => [
            ["13:00", 2],
            ["16:00", 5]
        ],
        "liberado" => true,
        "status" => "BOA AULA! CICLANO",
        "admin" => false
    ]
];

        // Selecionar todas as turmas que são da piscina
        // selecionar todas as inscrições que são da piscina e adicionar a pessoas em um array caso ainda não esteja adicionado com o hotário de inicio da turma e dia da semana

        // para cada pessoa verifica se há pendencia de pagamento, se sim marcar flag de liberado como false e status como "PENDENTE DE PAGAMENTO"

        // para cada pessoa verificar se há pendencia de atestado, se sim marcar flag de liberado como false e status como "ATESTADO MÉDICO PENDENTE"

        
        // senão retornar como verdadero e retornar data de inicio da turma e dia da semana


//return response()->json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return response()->json($dados, 200);
    }

    public function verificarAcessoPiscina()
    {
        // Selecionar turmas da piscina
        $turmasPiscina = DB::table('turmas')
            ->where('turmas.sala',  6)
            ->select('turmas.id', 'turmas.hora_inicio', 'turmas.dias_semana')
            ->get();

        // Selecionar inscrições da piscina
        $inscricoesPiscina = DB::table('inscricoes')
            ->join('turmas', 'inscricoes.turma', '=', 'turmas.id')
            ->join('pessoas', 'inscricoes.pessoa', '=', 'pessoas.id')
            ->where('turmas.sala', 6)
            ->select('pessoas.id as pessoa_id', 'pessoas.nome', 'turmas.hora_inicio', 'turmas.dias_semana')
            ->distinct()
            ->get();

        $pessoasProcessadas = [];

        foreach ($inscricoesPiscina as $inscricao) {
            $pessoaId = $inscricao->pessoa_id;
            
            // Verificar pendências de pagamento
            $pendenciaPagamento = DB::table('boletos')
                ->where('pessoa', $pessoaId)
                ->whereIn('status', ['gravado', 'emitido', 'divida'])
                ->exists();

            // Verificar pendências de atestado
            $pendenciaAtestado = DB::table('atestados')
                ->where('pessoa', $pessoaId)
                ->whereIn('status', ['analisando', 'recusado'])
                ->exists();

            // Preparar dados da pessoa
            $dadosPessoa = [
                'id' => $pessoaId,
                'nome' => $inscricao->nome,
                'horario_inicio' => $inscricao->hora_inicio,
                'dia_semana' => $this->converterDiaSemana($inscricao->dias_semana),
                'liberado' => !($pendenciaPagamento || $pendenciaAtestado),
                'status' => $this->definirStatus($pendenciaPagamento, $pendenciaAtestado)
            ];

            $pessoasProcessadas[] = $dadosPessoa;
        }

        return response()->json($pessoasProcessadas);
    }

    /**
     * Converte dias da semana para número
     */
    private function converterDiaSemana($diasSemana)
    {
        $mapeamentoDias = [
            'segunda' => 1,
            'terca' => 2,
            'quarta' => 3,
            'quinta' => 4,
            'sexta' => 5,
            'sabado' => 6,
            'domingo' => 7
        ];

        foreach ($mapeamentoDias as $dia => $numero) {
            if (stripos($diasSemana, $dia) !== false) {
                return $numero;
            }
        }

        return 0; // Dia não identificado
    }

    /**
     * Define o status com base nas pendências
     */
    private function definirStatus($pendenciaPagamento, $pendenciaAtestado)
    {
        if ($pendenciaPagamento) {
            return 'PENDENTE DE PAGAMENTO';
        }

        if ($pendenciaAtestado) {
            return 'ATESTADO MÉDICO PENDENTE';
        }

        return 'LIBERADO';
    }

    public function importarPresenca(Request $request){
        // This method would handle the import of attendance data.
        // It could involve parsing the request data and saving it to the database.

        $headers = getallheaders();
        if(!isset($headers['Token']) || $headers['Token'] !== 'cdEvWp6rqGCgisIZ2fzse2m20rgT6OyY1xy8SJxDva'){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Assuming the request contains JSON data
        $data = $request->json()->all();

        foreach($request->registro as $registro){
            
        }

        // Here you would typically process the data, e.g., save it to the database
        // For now, we'll just return the received data as a response
        return response()->json(['message' => 'Data imported successfully', 'data' => $data], 200);
    }
}
