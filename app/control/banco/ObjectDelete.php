<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjectDelete extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            
            TTransaction::open('curso');
            TTransaction::dump();

           $produto = Produto::find( 25 );

            if($produto instanceof Produto)            
            {
                $produto->delete();
                echo 'Produto apagado com sucesso!';                
            }
            else
            {
                echo 'Produto não econtrado';
            }     

            /* $produto = new Produto;
            $produto->delete( 28 ); */

            TTransaction::close();

        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}