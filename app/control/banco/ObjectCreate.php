<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Log\TLoggerTXT;
use Adianti\Widget\Dialog\TMessage;

class ObjectCreate extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            TTransaction::open('curso');           
            
            TTransaction::dump();//visualiza log com instrução sql

            Produto::create([
                'descricao' => 'Cabo HDMI',
                'estoque' => 50,
                'preco_venda' => 20,
                'unidade' => 'PC'
            ]);

            new TMessage('info', 'Produto gravado com sucesso!');

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}