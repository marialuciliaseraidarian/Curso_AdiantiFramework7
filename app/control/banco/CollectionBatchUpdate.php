<?php

use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class CollectionBatchUpdate extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try
        {
            TTransaction::open('curso');

            //mostra em tela a operação que será feita:
            TTransaction::dump();
            
            $criteria = new TCriteria;
            $criteria->add( new TFilter('situacao', '=', 'Y') );             
            $criteria->add( new TFilter('genero', '=', 'F') );
                                  
            //vetor de valores:
            $valores = [];
            $valores['telefone'] = '555 6666 4444';

            $repository = new TRepository('Cliente');
            //o método update recebe como parâmetros valores a serem inserido e critérios de filtros
            $repository->update( $valores, $criteria );                 
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}