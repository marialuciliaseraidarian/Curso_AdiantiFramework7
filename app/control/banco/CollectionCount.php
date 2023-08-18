<?php

use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TExpression;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class CollectionCount extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try
        {
            TTransaction::open('curso');  
            
            //definindo um filtro:
            $criteria = new TCriteria;
            $criteria->add( new TFilter('situacao', '=', 'Y'), TExpression::OR_OPERATOR );             
            $criteria->add( new TFilter('genero', '=', 'F'), TExpression::OR_OPERATOR );
            
            //criando um repositório:
            $repository = new TRepository('Cliente');
            //especificando a função no repositório:
            $count = $repository->count( $criteria );

            echo "Total de Registros: " .$count;
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}