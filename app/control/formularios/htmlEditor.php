<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\THtmlEditor;
use Adianti\Wrapper\BootstrapFormBuilder;

class htmlEditor extends TPage
{
    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('HTML Editor');
        $this->form->generateAria(); //esse método gera tags para facilitar software de leitura para deficientes visuais.

        $html = new THtmlEditor('conteudo_html');
        $html->setSize('100%', 200); //100% de largura e 200px de altura
        $html->setOption('placeholder', 'Insira aqui suas observaçoes...');
        
        $this->form->addFields( [$html] );

        $this->form->addAction('Enviar', new TAction( [$this, 'onSend']), 'far:check-circle green');

        parent::add($this->form);
    }

    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);

        new TMessage('info', $data->conteudo_html);
    }
}