<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjectFind extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            
            TTransaction::open('curso');
            TTransaction::dump();

            $produto = Produto::find( 8 );

            if($produto instanceof Produto)            
            {
                echo '<br>';
                echo '<b>Descrição:</b> ' . $produto->descricao;
                echo '<br>';
                echo '<b>Estoque:</b> ' . $produto->estoque;
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