<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Wrapper\BootstrapFormBuilder;


class CidadeTraitForm extends TPage
{
    private $form;
    use Adianti\Base\AdiantiStandardFormTrait;  

    public function __construct()
    {
        parent::__construct();

        $this->setDatabase('curso');
        $this->setActiveRecord('Cidade');

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Cidade');
        $this->form->setClientValidation(true); //liga validações do navegador

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $estado = new TDBCombo('estado_id', 'curso', 'Estado', 'id', 'nome');
        $id->setEditable(FALSE); //não permiti a edição do id.

        $this->form->addFields( [new TLabel('Id', 'red')], [$id] );
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        $this->form->addFields( [new TLabel('Estado')], [$estado] );

        //validações
        $nome->addValidation('Nome', new TRequiredValidator);
        $estado->addValidation('Estado', new TRequiredValidator);

        //botão de salvar
        $this->form->addAction('Salvar', new TAction( [$this, 'onSave'] ), 'fa:save green');
        $this->form->addActionLink('Limpar Formulário', new TAction( [$this, 'onClear'] ), 'fa:eraser red');

        parent::add($this->form);
    }    
}