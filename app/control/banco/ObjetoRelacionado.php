<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ObjetoRelacionado extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try
        {
           TTransaction::open('curso');
           TTransaction::dump();
            
           /* 
           //modo simples
           $contatos = Cliente::find(1)->hasMany('contato');
           //modo completo
           $contatos = Cliente::find(1)->hasMany('contato', 'cliente_id', 'id', 'tipo'); 
           //modo simples:
           $contatos = Cliente::find(1)->filterMany('contato')->where('tipo', '=', 'face')->load();
           //modo completo:
           $contatos = Cliente::find(1)->filterMany('contato', 'cliente_id', 'id', 'tipo')
                                       ->where('tipo', '=', 'face')
                                       ->load();*/
            
            $habilidades = Cliente::find(1)->belongsToMany('Habilidade', 'ClienteHabilidade', 'cliente_id', 'habilidade_id');

           echo '<pre>';
           var_dump($habilidades);
           echo '</pre>';           
           
           TTransaction::close();           
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}