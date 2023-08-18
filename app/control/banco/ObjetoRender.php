<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjetoRender extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            TTransaction::open('curso');
            
            $produto = new Produto( 3 ); //carrega o objeto 3

            print $produto->render('Produto {id} - {descricao} - preço R$ {preco_venda},00');
            //pode-se colocar a máscara que quiser como se fosse uma string.
            
            TTransaction::close();
            
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}