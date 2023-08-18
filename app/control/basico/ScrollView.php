<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TScroll;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Form\TEntry;

class ScrollView extends TPage
{
    public function __construct()
    {
        parent::__construct();

        //objeto para criação do scroll: TScroll
        $scroll = new TScroll;
        //para funcionar ele precisa de um tamanho:
        $scroll->setSize('100%', '300');

        //conteúdo que vamos colocar dentro do scroll:
        $table = new TTable; //cria tabela
        $scroll->add($table); //insere a tabela dentro do scroll

        //loop para repetição dos dados:
        for ($n=1; $n<=20; $n++)
        {
           $object = new TEntry('field' . $n);
           $table->addRowSet('Field' . $n, $object);
        }

        parent::add( $scroll ); //dentro da página adicionamos o objeto $scroll        
    }
}