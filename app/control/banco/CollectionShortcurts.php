<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class CollectionShortcurts extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try {
            TTransaction::open('curso');
            
            /* //Retorna, sem filtros, todos os registros da classe Cliente da model da tabela cliente 
            $clientes = Cliente::all();
            echo '<pre>'; print_r($clientes); echo '</pre>'; */

            /* $count = Cliente::where('situacao', '=', 'Y')
                            ->where('genero', '=', 'F')
                            ->count();
            print_r($count); */

            /* $clientes = Cliente::where('situacao', '=', 'Y')
                               ->where('genero', '=', 'F')
                               ->load();
            echo '<pre>'; print_r($clientes); echo '</pre>'; */

           /*  $clientes = Cliente::where('situacao', '=', 'Y')
                               ->where('genero', '=', 'F')
                               ->orderBy('cidade_id')
                               ->load();
            echo '<pre>'; print_r($clientes); echo '</pre>'; */
            
            /* $clientes = Cliente::where('id', '>', 0)
                               ->take(10)
                               ->skip(20)
                               ->load();
            echo '<pre>'; print_r($clientes); echo '</pre>'; */

            /* //pega o primeiro objeto que passou pelo filtro:
            $cliente = Cliente::where('situacao', '=', 'Y')
                              ->where('genero', '=', 'F')
                              ->first();
            echo '<pre>'; print_r($cliente); echo '</pre>'; */

            /* Cliente::where('telefone', '=', '123123') //o where estabelece o filtro
                   ->set('telefone', '555 4444 8888') //o set estabelece os novos valores para a coluna telefone
                   ->update();//o update executa o comando a atualização dos dados inseridos no set
            new TMessage('info', 'Dados inseridos com sucesso!'); */

            /* Cliente::where('situacao', '=', 'N')
                   ->where('categoria_id', '>', '2')
                   ->delete();  */           

            /* //retorna um array plano com id e nome:
            $clientes = Cliente::getIndexedArray('id', 'nome');
            echo '<pre>'; print_r($clientes); echo '</pre>'; */

            $clientes = Cliente::orderBy('nome')
                               ->getIndexedArray('id', 'nome');
            echo '<pre>'; print_r($clientes); echo '</pre>';
 
            TTransaction::close();

        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}
