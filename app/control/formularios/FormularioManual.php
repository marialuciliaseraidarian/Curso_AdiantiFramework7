<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Container\TNotebook;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TTable;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TButton;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Form\TLabel;

class FormularioManual extends TPage
{
    private $form;
    public function __construct()
    {
        parent::__construct();

        $this->form = new TForm('meu_form');//cria uma tag form

        $notebook = new TNotebook;
        $this->form->add($notebook);

        $table1 = new TTable;
        $table2 = new TTable;

        $table1->width = '100%';
        $table2->width = '100%';
        $table1->style = 'padding:10px';
        $table2->style = 'padding:10px';

        $notebook->appendPage('Página 1', $table1);
        $notebook->appendPage('Página 2', $table2);

        $nome = new TEntry('nome');
        $documento = new TEntry('documento');
        $telefone = new TEntry('telefone');
        $email = new TEntry('email');        
        $endereco = new TEntry('endereco');
        $num = new TEntry('num');
        $bairro = new TEntry('bairro');
        $cep = new TEntry('cep');
        $cidade = new TEntry('cidade');

        $table1->addRowSet( new TLabel('Nome'), $nome );
        $table1->addRowSet( new TLabel('Documento'), $documento );
        $table1->addRowSet( new TLabel('Telefone'), $telefone );
        $table1->addRowSet( new TLabel('Email'), $email );

        $table2->addRowSet( new TLabel('Endereço'), $endereco );
        $table2->addRowSet( new TLabel('Número'), $num );
        $table2->addRowSet( new TLabel('Bairro'), $bairro );
        $table2->addRowSet( new TLabel('CEP'), $cep );
        $table2->addRowSet( new TLabel('Cidade'), $cidade );

        $botao = new TButton('enviar');
        $botao->setAction( new TAction( [$this, 'onSend']), 'Enviar' );
        $botao->setImage('fa:save');

        $this->form->setFields( [ $nome, $documento, $telefone, $email, $endereco, $num, $bairro, $cep, $cidade, $botao ] );

        $panel = new TPanelGroup('Formulário Manual');           
        $panel->add($this->form); 
        $panel->addFooter($botao);       

        parent::add($panel);
    }

    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData( $data );//mantem dados na tela 
        new TMessage('info', str_replace(',', '<br>', json_encode($data)));//muda a vírgula por quebra de linha e mostra os dados em formato json
    }
}