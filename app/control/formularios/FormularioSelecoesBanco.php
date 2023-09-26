<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBCheckGroup;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Widget\Wrapper\TDBEntry;
use Adianti\Widget\Wrapper\TDBMultiSearch;
use Adianti\Widget\Wrapper\TDBRadioGroup;
use Adianti\Widget\Wrapper\TDBSelect;
use Adianti\Widget\Wrapper\TDBUniqueSearch;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioSelecoesBanco extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Campos de Seleção');

        $radio = new TDBRadioGroup('radio', 'curso', 'Categoria', 'id', 'nome');
        $radioButton = new TDBRadioGroup('radioButton', 'curso', 'Categoria', 'id', '{id} - {nome}'); 
        $check = new TDBCheckGroup('check', 'curso', 'Categoria', 'id', 'nome');
        $checkButton = new TDBCheckGroup('checkButton', 'curso', 'Categoria', 'id', '{id} - {nome}');
        $combo = new TDBCombo('combo', 'curso', 'Categoria', 'id', 'nome');
        $comboSearch = new TDBCombo('comboSearch', 'curso', 'Categoria', 'id', 'nome');
        $select = new TDBSelect('select', 'curso', 'Categoria', 'id', 'nome');
        $search = new TDBMultiSearch('search', 'curso', 'Categoria', 'id', 'nome');
        $unique = new TDBUniqueSearch('unique', 'curso', 'Categoria', 'id', 'nome');
        $autocomp = new TDBEntry('autocomplete', 'curso', 'Categoria', 'nome');    
           
        $radio->setLayout('horizontal');          
        $radioButton->setLayout('horizontal');
        $check->setLayout('horizontal');
        $checkButton->setLayout('horizontal');
        $radioButton->setUseButton(); 
        $checkButton->setUseButton();  
        $comboSearch->enableSearch(); 
        $search->setMinLength(1);    
        $unique->setMinLength(1); 
        $unique->setMask('{nome} ({id})');

        $this->form->addFields( [new TLabel('Radio')], [$radio] );
        $this->form->addFields( [new TLabel('Radio tipo Botão')], [$radioButton] );
        $this->form->addFields( [new TLabel('Check')], [$check] );
        $this->form->addFields( [new TLabel('Check tipo Botão')], [$checkButton] );
        $this->form->addFields( [new TLabel('Combo simples')], [$combo] );
        $this->form->addFields( [new TLabel('Combo Search')], [$comboSearch] );
        $this->form->addFields( [new TLabel('Select')], [$select] );
        $this->form->addFields( [new TLabel('Busca múltipla')], [$search] );
        $this->form->addFields( [new TLabel('Busca única')], [$unique] );
        $this->form->addFields( [new TLabel('Auto complete')], [$autocomp] );

        $this->form->addAction('Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');

        parent::add($this->form);
    }

    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);
        echo '<pre>';
        print_r($data);        
        echo '</pre>';
    }
}