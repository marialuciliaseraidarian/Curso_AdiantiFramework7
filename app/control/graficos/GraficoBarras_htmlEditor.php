<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Wrapper\BootstrapFormBuilder;

//usei para ver como vizualizar o conteúdo do html editor
class GraficoBarras extends TPage
{
    private $form;

    function __construct()
    {
        parent::__construct();
        // cria o formulário
        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle( _t('Html Editor') );
        // cria os elementos de input
        $html = new THtmlEditor('html_text');
        $html->setSize( '100%', 200);
        $html->setOption('placeholder', 'type here...');
        // adiciona os objetos ao formulário
        $this->form->addFields( [$html] );
        // cria uma ação
        $this->form->addAction('Show', new TAction(array($this, 'onShow')),
        'fa:check-circle-o green');
        parent::add($this->form);
    }
    
    public function onShow($param)
    {
        $data = $this->form->getData(); // obtém os dados
        $this->form->setData($data);
        new TMessage('info', $data->html_text); // exibe uma mensagem
    }
}