<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class CollectionAggregation extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try
        {
          TTransaction::open('curso'); 
          TTransaction::dump();
                    
          //$total = Venda::sumBy('total');
          //$count = Venda::countDistinctBy('total');
          //$rows = Venda::groupBy('dt_venda, cliente_id')->sumBy('total');
          //$total = Venda::where('dt_venda', '>', '2015-03-14')->sumBy('total');
          //$total = Venda::where('dt_venda', '>', '2015-03-14')->countDistinctBy('id');
          //$rows = Venda::where('dt_venda', '>', '2015-03-12')->groupBy('dt_venda')->maxBy('total');
          //$total = Venda::where('dt_venda', '>', '2015-04-12')->where('dt_venda', '<', '2019-04-12')->sumBy('total');
          $rows = Venda::where('dt_venda', '>', '2015-04-12')
                        ->where('dt_venda', '<', '2019-04-12')
                        ->groupBy('cliente_id')
                        ->sumBy('total');

            foreach($rows as $row)
            {
                print 'Cliente: ' . $row->cliente_id . ' - Total: '. $row->total. '<br>';                
            }          

          TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}