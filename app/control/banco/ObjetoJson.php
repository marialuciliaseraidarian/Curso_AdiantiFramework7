<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjetoJson extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            TTransaction::open('curso');
            //pega um objeto TRecord e converte para Json com o toJson
            $produto = new Produto( 3 ); //carrega o objeto 3

            echo '<pre>';
            print_r( $produto->toJson() );
            echo '<pre>';
            
            TTransaction::close();
            
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}