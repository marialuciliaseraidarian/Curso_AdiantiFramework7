<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TInputDialog;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class DialogInputView extends TPage
{
    public function __construct()
    {
        parent::__construct();

        //cria um formulário com estilo bootstrap:
        $form = new BootstrapFormBuilder('input_form');

        $login = new TEntry('login');
        $pass = new TEntry('pass');

        //adiciona inputs no formulário, os parâmetros são em formato de array:
        $form->addFields([new TLabel('Login')], [$login]);
        $form->addFields([new TLabel('Senha')], [$pass]);

        $form->addAction('Confirma', new TAction([__CLASS__, 'onConfirm1']), 'fa:save green');

        //cria um diálogo de input e dentro dele inserimos o formulário e o título:
        new TInputDialog('título', $form);        
    }

    public static function onConfirm1($param)
    {
        new TMessage('info', 'Login: ' .$param['login'] . '<br />' . 'Senha: ' .$param['pass']);
        //new TMessage('info', json_encode($param));  
    }
}