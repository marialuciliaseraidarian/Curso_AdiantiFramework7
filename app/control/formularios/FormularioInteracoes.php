<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioInteracoes extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder('meu_form');
        $this->form->setFormTitle('Interações');

        $input_a = new TEntry('input_a');
        $input_b = new TEntry('input_b');

        $combo_a = new TCombo('combo_a');
        $combo_b = new TCombo('combo_b');

        $input_a->setExitAction( new TAction( [$this, 'onExitAction'] ) );
        $combo_a->setChangeAction( new TAction( [$this, 'onChangeAction'] ) );


        $combo_a->addItems( [ 'a' => 'Opção A', 'b' => 'Opção B', 'c' => 'Opção C'] );
        
        $this->form->addFields( [new TLabel('Input A')], [$input_a] );
        $this->form->addFields( [new TLabel('Input B')], [$input_b] );
        $this->form->addFields( [new TLabel('Combo A')], [$combo_a] );
        $this->form->addFields( [new TLabel('Combo B')], [$combo_b] );

        parent::add($this->form);
    }

    public static function onExitAction($param)
    {
        $obj = new stdClass;
        $obj->input_b = 'Você digitou ' . $param['input_a'] . ' às ' . date('H:i:s');

        TForm::sendData('meu_form', $obj);

        new TMessage('info', 'Você digitou ' . $param['input_a'] . ' às ' . date('H:i:s'));
    }

    public static function onChangeAction($param)
    {
        $opcoes = [];
        $opcoes[1] = $param['combo_a'] . ' - ' . 'Um';
        $opcoes[2] = $param['combo_a'] . ' - ' . 'Dois';
        $opcoes[3] = $param['combo_a'] . ' - ' . 'Três';

        TCombo::reload('meu_form', 'combo_b', $opcoes);        
    }
}