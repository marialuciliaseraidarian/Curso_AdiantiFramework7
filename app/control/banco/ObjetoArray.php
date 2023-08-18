<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjetoArray extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            TTransaction::open('curso');
            //pega um objeto TRecord e converte para array
            $produto = new Produto( 3 ); //carrega o objeto 3

            echo '<pre>';
            print_r( $produto->toArray() );
            echo '<pre>';

            //cria um vetor e alimenta o active record com base nele:
            //esse método é muito usado para gravar dados de entradas de formulários.
            //cria um vetor
            $dados = []; 
            $dados['descricao'] = 'Smart Watch';
            $dados['estoque'] = 2;
            $dados['preco_venda'] = 200;
            $dados['unidade'] = 'PC';
            //cria um objeto a partir do vetor
            $produto = new Produto;
            $produto->fromArray( $dados );//alimenta o objeto em memória
            $produto->store(); //grava o objeto na base de dados
            
            TTransaction::close();
            
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}