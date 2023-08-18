<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;

class NotebookView extends TPage
{
    public function __construct()
    {
        parent::__construct();

        $notebook = new TNotebook();
        
        //conteúdo que vamos inserir nas abas:
        $table1 = new TTable;
        $table2 = new TTable;

        //componente appendPage adiciona uma aba e recebe dois parêmetros: nome e conteúdo
        $notebook->appendPage('Dados Pessoais', $table1);
        $notebook->appendPage('Endereços', $table2);

        //objetinhos para colocar nas tabelas criadas acima:
        $field1 = new TEntry('Field1');
        $field2 = new TEntry('Field2');
        $field3 = new TEntry('Field3');
        $field4 = new TEntry('Field4');
        $field5 = new TEntry('Field5');
        $field6 = new TEntry('Field6');
        $field7 = new TEntry('Field7');
        $field8 = new TEntry('Field8');
       
        //adiciona linhas na tabela 1 e 2 usando método addRowSet que adiciona linhas e colunas ao mesmo tempo:
        $table1->addRowSet(new TLabel('Nome Completo'), $field1);
        $table1->addRowSet(new TLabel('Documento'), $field2);
        $table1->addRowSet(new TLabel('Email'), $field3);
        $table1->addRowSet(new TLabel('Telefone'), $field4);

        $table2->addRowSet(new TLabel('Endereço'), $field5);
        $table2->addRowSet(new TLabel('Cidade'), $field6);
        $table2->addRowSet(new TLabel('Estado'), $field7);
        $table2->addRowSet(new TLabel('Cep'), $field8);

        parent::add( $notebook ); //adiciona o objeto $notebook dentro da página
    }
}