<?php
class TesteView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        try
        {
            TTransaction::open('curso');
            //TTransaction::setLogger(new TLoggerSTD);
            TTransaction::dump();
            echo '<pre>';
            
            var_dump(Venda::where('dt_venda', '>', '2015-04-12')->where('dt_venda', '<', '2019-04-12')->groupBy('cliente_id')->sumBy('total'));
            
            echo '</pre>';
             
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}