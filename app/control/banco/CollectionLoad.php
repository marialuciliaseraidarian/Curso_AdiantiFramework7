<?php

use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class CollectionLoad extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try
        {
            TTransaction::open('curso');  
            
            //definindo um filtro:
            $criteria = new TCriteria;
            $criteria->add( new TFilter('situacao', '=', 'Y') );             
            $criteria->add( new TFilter('genero', '=', 'F') );
            
            //criando um repositório:
            $repository = new TRepository('Cliente');
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