<?php

use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class CollectionLimit extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try
        {
            TTransaction::open('curso');  
            
            //definindo um filtro:
            $criteria = new TCriteria;

            //criando paginação:
            $criteria->setProperty('limit', 10);
            $criteria->setProperty('offset', 20);
            $criteria->setProperty('order', 'id');
                      
            //criando um repositório:
            $repository = new TRepository('cliente');
            //especificando a função no repositório:
            $objetos = $repository->load( $criteria );

            if ($objetos)
            {
                foreach ($objetos as $objeto)
                {
                    echo $objeto->id . ' - ' . $objeto->nome;
                    echo '<br>';
                }
            }            
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}