<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjectUpdate extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            
            TTransaction::open('curso');
            TTransaction::dump();

            $produto = Produto::find( 41 );

            if($produto instanceof Produto)            
            {
                $produto->descricao = 'Gravador CD-R';
                $produto->estoque = 5;
                $produto->preco_venda = 15;
                $produto->store();
            }
            else
            {
                echo 'Produto não econtrado';
            }            

            TTransaction::close();

        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}