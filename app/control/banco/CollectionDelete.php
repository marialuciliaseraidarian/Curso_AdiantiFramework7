<?php

use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class CollectionDelete extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try
        {
            TTransaction::open('curso');

            TTransaction::dump();
            
            $criteria = new TCriteria;
            $criteria->add( new TFilter('situacao', '=', 'Y') );             
            $criteria->add( new TFilter('genero', '=', 'F') );
                               
            $repository = new TRepository('Cliente');
            
            $repository->delete( $criteria );                 
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}