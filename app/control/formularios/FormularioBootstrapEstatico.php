<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TPassword;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioBootstrapEstatico extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Formulário Bootstrap Estático');

        $id = new TEntry('id');
        $descricao = new TEntry('descricao');
        $senha = new TPassword('senha');        
               
        $this->form->addFields( [new TLabel('ID')], [$id] );
        $this->form->addFields( [new TLabel('Descrição')], [$descricao] );
        $this->form->addFields( [new TLabel('Senha')], [$senha] );
        
        $this->form->addAction('Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');
       
        parent::add( $this->form );
    }

    public static function onSend($param)
    {
        //o método static não aceita usar o $this, para pegar os dados tem que usar o $param.
        echo '<pre>';
        var_dump($param);
        echo '</pre>';

        new TMessage('info', 'Dados salvos com sucesso!');
    }
}