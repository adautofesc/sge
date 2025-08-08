<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\Inscricao;
use App\Turma;
use App\Boleto;
use App\Atestado;
use App\classes\Data;

class CatracaController extends Controller
{   
  
    public function sendData(){
        // https://dev.to/yasserelgammal/dive-into-laravel-sanctum-token-abilities-n8f
        // Implementation details would go here, such as fetching data from an external API
        // or database and updating the local records accordingly.

        $headers = getallheaders();
        if(!isset($headers['Token']) || $headers['Token'] !== env('HASH_API_CATRACA')){
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $dados = array();
/*
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
];*/

        // Tags
        $tags = Tag::join('pessoas', 'tags.pessoa', '=', 'pessoas.id')->get();
           
        foreach($tags as $tag){
            $liberado = false;
            $status = "";
            $horarios = array();

            $inscricoes = Inscricao::where('inscricoes.pessoa', $tag->pessoa)
                ->join('turmas', 'inscricoes.turma', '=', 'turmas.id')
                ->where('turmas.sala', 6) // Assuming 6 is the pool
                ->where('inscricoes.turma', '!=', null)
                ->where('inscricoes.status', 'regular')
                ->get();

            $horarios = array();
            foreach ($inscricoes as $inscricao) {
                // Adiciona diretamente ao array $horarios, sem criar subarrays
                $horarios[] = [
                    'hora' => $inscricao->hora_inicio,
                    'dias' => explode(',', $inscricao->dias_semana)
                ];
            }

            // Se precisar garantir que não haja arrays vazios/nulos:
            $horarios = array_values(array_filter($horarios));
            
                
            

            //verificar pagamento
            $boletos = Boleto::verificarDebitos($tag->pessoa);
            if($boletos->count() == 0)
                $liberado = True;                
            else
                $status = "PENDENTE DE PAGAMENTO";
                
            //verificar atestado
            $atestado = Atestado::verificarPessoa($tag->pessoa,6);
            

            if(!$atestado){
                $liberado = False;
                $status = "ATESTADO MÉDICO PENDENTE";
            }

            //verificar se é admin
            $acesso = \App\ControleAcessoRecurso::where('pessoa', $tag->pessoa)
                ->where('recurso', '31')
                ->first();
            if($acesso){
                $admin = true;
                $liberado = true;
                $status = "ACESSO ADMINISTRATIVO";
            }



            if(!array_search($tag->pessoa, array_column($dados, 'aluno_id'))){
                $dados[] = [
                    "aluno_id" => $tag->pessoa,
                    "credencial" => $tag->tag,
                    "horarios" => $horarios,
                    "liberado" => $liberado,
                    "status" => $status,
                    "admin" => isset($admin)? true : false,
                ];
            }
            


        }


        // Selecionar todas as turmas que são da piscina
        /*
        $turmas = Turma::where('sala',6)->whereIn('status',['lancada','iniciada'])->get();


        foreach($turmas as $turma){
            // Para cada turma, selecionar as inscrições
            $inscricoes = Inscricao::where('turma', $turma->id)->get();

            foreach($inscricoes as $inscricao){
                // Verificar se a pessoa já está no array de dados
                $alunoId = $inscricao->pessoa->id;
                if(!array_search($alunoId, array_column($dados, 'aluno_id'))){
                    $dados[] = [
                        "aluno_id" => $alunoId,
                        "credencial" => $inscricao->credencial,
                        "horarios" => [],
                        "liberado" => true,
                        "status" => "BOA AULA! " . $inscricao->pessoa->nome,
                        "admin" => false
                    ];
                }
                // Adicionar horário
                $dados[-1]['horarios'][] = [$turma->horario, $turma->dia_semana];
            }
        }
*/
        // selecionar todas as inscrições que são da piscina e adicionar a pessoas em um array caso ainda não esteja adicionado com o hotário de inicio da turma e dia da semana

        // para cada pessoa verifica se há pendencia de pagamento, se sim marcar flag de liberado como false e status como "PENDENTE DE PAGAMENTO"

        // para cada pessoa verificar se há pendencia de atestado, se sim marcar flag de liberado como false e status como "ATESTADO MÉDICO PENDENTE"

        
        // senão retornar como verdadero e retornar data de inicio da turma e dia da semana




//return response()->json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        return response()->json($dados, 200);
    }


    /**
     * Import attendance data from the post request catraca endpoint.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function importData(Request $request){
        // Provisory Authentication ******************************************************************
        // In a production environment, you would use a more secure method of authentication
        $headers = getallheaders();
        if(!isset($headers['Token']) || $headers['Token'] !== env('HASH_API_CATRACA')){
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        // *****************************************************************************************

        // Initialize an empty response array
        // This will hold the processed data or any errors encountered
        $response = array();

        
        $data = $request->json()->all();
        if(empty($data))
            return response()->json(['error' => 'No data provided'], 400);
        

        foreach($data as $registro){
            $aluno = $registro['aluno'];
            $dataHora = $registro['acesso'];
            try{
                $objetoDataHora = new \DateTime("@$dataHora");
            }
            catch(\Exception $e){
                $response[] = [
                    'acesso' => $registro['id_acesso'],
                    'status' => 'failed',
                    'message' => 'Invalid date format: ' . $dataHora
                ];
                continue;
            }
            // Pega a turma iniciada compatível com o horário (com a tolerância) e dia da semana
            
            $turma = \App\Turma::select('id')
                ->where('sala', 6)
                ->whereRaw('TIME(hora_inicio) BETWEEN ? AND ?', [
                                (clone $objetoDataHora)->modify('-'.env('TOLERANCIA_ATRASO').' minutes')->format('H:i:s'),
                                (clone $objetoDataHora)->modify('+'.env('TOLERANCIA_ATRASO').' minutes')->format('H:i:s')
                            ]
                        )
                ->where('dias_semana', 'like', '%'.Data::stringDiaSemana($objetoDataHora->format('d/m/Y')).'%') // N returns the day of the week (1 for Monday, 7 for Sunday)
                ->where('status', 'iniciada')
                ->first();

            if(is_null($turma)){
                $response[] = [
                    'acesso' => $registro['id_acesso'],
                    'status' => 'failed',
                    'message' => 'Nenhuma turma corresponde ao dia e horário '
                ];
                continue;
            }

            $inscrito = \App\Inscricao::where('pessoa', $aluno)
                ->where('turma', $turma->id)
                ->first();

            if(is_null($inscrito)){
                $response[] = [
                    'acesso' => $registro['id_acesso'],
                    'status' => 'failed',
                    'message' => 'Aluno não inscrito na turma'
                ];
                continue;
            }

            $aula = \App\Aula::where('turma', $turma->id)
                ->whereDate('data', $objetoDataHora->format('Y-m-d'))
                ->first();

            if(is_null($aula)){
                $response[] = [
                    'acesso' => $registro['id_acesso'],
                    'status' => 'failed',
                    'message' => 'Sem aula neste dia'
                ];
                continue;
            }
            else{

                if($aula->status == 'prevista'){
                    $aula->status = 'realizada';
                    $aula->save();
                }

                // If the presence record already exists, skip to the next iteration
                $presencaExistente = \App\Frequencia::where('aula', $aula->id)
                    ->where('aluno', $aluno)
                    ->first();  
                if($presencaExistente){
                    $response[] = [
                        'acesso' => $registro['id_acesso'],
                        'status' => 'failed',
                        'message' => 'Presença já registrada'
                    ];
                    continue;
                }
                else{
                    $presenca =  new \App\Frequencia();
                    $presenca->aula = $aula->id;
                    $presenca->aluno = $aluno;
                    try{
                        $presenca->save();
                    }
                    catch(\Illuminate\Database\QueryException $e){
                        $response[] = [
                            'acesso' => $registro['id_acesso'],
                            'status' => 'failed',
                            'message' => 'Erro ao registrar presença: ' . $e->getMessage()
                        ];
                        continue;
                    }
                    
                    $response[] = [
                        'acesso' => $registro['id_acesso'],
                        'status' => 'success',
                        'message' => 'Presença registrada'
                    ];

                }
                

            }
                
            /*dd([
                'dataHora' => $objetoDataHora->format('d/m/Y H:i:s'),
                'sql' => $turma->toSql(),
                'bindings' => $turma->getBindings(),
                'dados' => $turma->get()
            ]);*/

        }
        return response()->json($response, 200);
    }
}
