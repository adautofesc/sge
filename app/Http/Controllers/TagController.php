<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tag;
use App\TagLog;
use Auth;

class TagController extends Controller
{
    public function index($pessoa=null){
        if($pessoa){
            $pessoa = \App\Pessoa::find($pessoa);
            $tag = Tag::where('pessoa',$pessoa->id)->first();
            $logs = TagLog::where('pessoa',$pessoa->id)->paginate(100);
        }
        else{     
            $tag = null;
            $logs = TagLog::paginate(100);
        }
        //dd($tag);

        return view('tags.index')
            ->with('pessoa',$pessoa)
            ->with('tag',$tag)
            ->with('logs',$logs);

    }

    public function criar(Request $r){
   
        if($r->tag>0){
            $tag = Tag::where('tag',str_pad($r->tag,20,'0',STR_PAD_LEFT))->first();
            if($tag)
                return redirect()->back()->with(['warning'=>'Tag já cadastrada']);
            
            $tag = new Tag;
            $tag->pessoa = $r->pessoa;
            $tag->tag = str_pad($r->tag,20,'0',STR_PAD_LEFT);
            $tag->data = new \DateTime();
            $tag->responsavel = Auth::user()->pessoa;
            $tag->save();

            $log = new TagLog;
            $log->pessoa = $r->pessoa;
            $log->evento = 'cadastro_tag';
            $log->data = new \DateTime();
            $log->save();
            return redirect()->back()->with(['success'=>'Tag cadastrada']);
        }
        else
            return redirect()->back()->with(['danger'=>'Tag inválida']);

       

    }


    public function apagar($id,$pessoa){
        $tag = Tag::destroy($id);
        $log = new TagLog;
        $log->pessoa = $pessoa;
        $log->evento = 'exclusao_tag';
        $log->data = new \DateTime();
        $log->save();


        return response('ok',200);

    }

    public function tagAccess($tag,$key){
        //dd(md5($tag));
        if(md5($tag) !== $key)
            return response('negado: chave invalida',403);
        
        
        $tag = Tag::where('tag',$tag)->first();
        if(!$tag)
            return response('negado: tag invalida',403);
        
        
        $pendencia = \App\PessoaDadosAdministrativos::where('pessoa',$tag->pessoa)->where('dado','pendencia')->first();
        if($pendencia){
            TagLogController::registrar('acesso_piscina_negado',$tag->pessoa);
            return response('negado: pendente',403);
        }
        else{
            TagLogController::registrar('acesso_piscina_liberado',$tag->pessoa);
            return response ('liberado',200);
        }
            

        

    }
}
