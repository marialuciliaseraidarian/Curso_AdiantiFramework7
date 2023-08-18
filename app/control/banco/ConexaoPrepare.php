<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;

class ConexaoPrepare extends TPage
{
    public function __construct()
    {
        parent::__construct();

        try
        {
            TTransaction::open('curso');//abre a transação com o BD curso.
            
            $conn = TTransaction::get();
            $statement = $conn->prepare('SELECT id, nome FROM cliente WHERE id >= ? AND id <= ?');//chama o prepare e retorna um objeto
            /* A interrogação indica os dados que serão inseridos pelo usuário
            e o prepare separa esses dados do resto da instrução SQL evitando o SQL injection */

            $statement->execute( [3, 12] ); //executa a instrução inserida no prepare e injeta os valores dos campos ingógnitos (?)
            // $statement->execute( [$_GET['id'], $_GET['id']] );//usar para pegar dados inseridos pelo usuário
            //em cima do statement eu posso pegar o result através do métido fetchAll
            $result = $statement->fetchAll();//retorna o resultado da consulta

            foreach($result as $row)
            {
                print $row['id'] . '-' .
                      $row['nome'] . "<br>\n";
            }
            
            TTransaction::close();//fecha a transação
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}