<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use App\Responsavel;
use PhpParser\Node\Stmt\TryCatch;

class ResponsavelsController extends Controller
{
    /*  
        Função que retorna a view de cadastro de responsavel.
    */
    protected function create() {
        return view('dashboard.responsavel.create');
    }
    /*
        Função que irá retorna os dados dos responsaveles cadastrados.
    */
    protected function show() {
        $respon = new Responsavel();
        $result = $respon->all();

        return view('dashboard.responsavel.show')
            ->with('respon', $result);
    }
    /*
        Função de recebimento dos dados do formulário (Request $request), e persistência desses dados na tabela Responsavel.
    */
    protected function store(Request $request, Responsavel $respon) {
        $respon = new Responsavel();
        /*
            Setando váriaveis
        */
        $respon->nome = $request->input('nome');
        $respon->cpf = $request->input('cpf');
        $respon->email = $request->input('email');
        $respon->contato_1 = $request->input('contato_1');
        $respon->contato_2 = $request->input('contato_2');

        /*
            Persistência de dados
        */
        Try {
            if($respon->save()) {
               
                flash('Responsavel cadastrado com sucesso!')->success();
                return redirect(route('responsavel.show'));
            }
        } catch(QueryException $ex) {
            flash('Não foi possível cadastrar Responsavel!')->error();
            return redirect(route('responsavel.show'));
        }            
    }
    /**
     * Método para buscar o Responsavel que deseja atualizar
     */
    protected function update($id) {
        /**
         * Consulta responsavel pelo ID
         */
        $result = Responsavel::find($id);
        
        return view('dashboard.responsavel.update')
            ->with('responsavel', $result);
    }
    /**
     * Método para atualizar Responsavel
     */
    protected function updateConf(Request $request, Responsavel $respon) {
        $respon = new Responsavel();
        $id = $request->input('id');
        $respon = Responsavel::find($id);
        $respon->nome = $request->input('nome');
        $respon->cpf = $request->input('cpf');
        $respon->email = $request->input('email');
        $respon->contato_1 = $request->input('contato_1');
        $respon->contato_2 = $request->input('contato_2');

        try {
            if($respon->save()) {
                flash('Responsavel atualizado com sucesso!')->success();
                return redirect(route('responsavel.show'));
            }
        } catch(QueryException $ex) {
            flash('Não foi possível atualizar Responsavel, tente novamente!')->error();
            return redirect(route('responsavel.show'));
        }
    }
    /**
     * Método para deletar Responsavel
     */
    protected function delete($id, Responsavel $respon) {
        $respon = new Responsavel();
        $respon = Responsavel::find($id);

        try {
            if($respon->delete()) {
                flash('Responsavel excluido com sucesso!')->success();
                return redirect(route('responsavel.show'));
            }
        } catch(QueryException $ex) {
            flash('Não foi possível excluir Responsavel, tente novamente!')->error();
            return redirect(route('responsavel.show'));
        }
    }
}