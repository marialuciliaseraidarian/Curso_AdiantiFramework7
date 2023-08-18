<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjetoEvaluate extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            TTransaction::open('curso');
            
            $produto = new Produto( 3 ); //carrega o objeto 3

            $total = $produto->evaluate('= {preco_venda} * {estoque}');
            print $produto->render('{descricao} * {preco_venda} = ' . $total);
            
            TTransaction::close();
            
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}