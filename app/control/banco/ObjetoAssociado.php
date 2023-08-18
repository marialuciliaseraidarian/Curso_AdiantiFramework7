<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjetoAssociado extends TPage //ObjetoRelacionado
{
    public function __construct()
    {
        parent::__construct();

        try {
            TTransaction::open('curso');

            $cliente = new Cliente( 1 );

            echo $cliente->nome;
            echo '<br>';
            echo $cliente->cidade->nome;
            echo '<br>';
            echo $cliente->cidade->estado->nome;

            TTransaction::close();
            
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}