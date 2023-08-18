<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;

class TableView extends TPage
{
    public function __construct()
    {
        parent::__construct();

        $table = new TTable;
        //estiliza a tabela criada:
        $table->border = '1';
        $table->cellpadding = '4';
        $table->style = 'border-collapse: collapse; width: 100%';

        //método addRow adiciona linhas na tabela
       $row = $table->addRow();
       //em cima da linha adicionada, adicionamos células A e B 
       $row->addCell( 'A' ); 
       $row->addCell( 'B' ); 
       
       //criar título para a tabela (label a ser exibito, cor do label, tamanho do label)
       $title = new TLabel('Títulos', 'red', 18);

       $row = $table->addRow();
       $cell = $row->addCell( $title );
       $cell->colspan = 2; //a tabela que criamos tem duas células (colunas), aqui fazemos com que essa linha ocupe as duas células
       $cell->style = 'padding: 10px';

      //TEntry inseri campos de entrada de dados:
       $id = new TEntry('id');
       $nome = new TEntry('nome');
       $endereco = new TEntry('endereco');
       $fone = new TEntry('fone');
       $obs = new TEntry('obs');

       //Adiciona linhas para as entradas acima:
       //usando o método addRowSet('label', $campo) já criamos uma célula para o nome do campo e outra para a inserção do campo
       $table->addRowSet( new TLabel('Código'), $id );
       $table->addRowSet( new TLabel('Nome'), $nome );
       $table->addRowSet( new TLabel('Endereço'), $endereco );
       $table->addRowSet( new TLabel('Telefone'), $fone );
       $table->addRowSet( new TLabel('OBS'), $obs );
                
        parent::add( $table );
    }
}