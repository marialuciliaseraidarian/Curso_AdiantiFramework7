<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Form\TCheckGroup;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TMultiEntry;
use Adianti\Widget\Form\TMultiSearch;
use Adianti\Widget\Form\TRadioGroup;
use Adianti\Widget\Form\TSelect;
use Adianti\Widget\Form\TUniqueSearch;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioSelecoes extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Campos de Seleção');

        $opcoes = ['a' => 'Opção A', 'b' => 'Opção B', 'c' => 'Opção C'];

        $radio = new TRadioGroup('radio');        
        $radio->addItems($opcoes);       
        $radio->setLayout('horizontal'); 
        $radio->setValue('b'); //usa-se para já vir com o campo autopreenchido como sugestão.      

        $radioButton = new TRadioGroup('radioButton');
        $radioButton->addItems($opcoes);
        $radioButton->setLayout('horizontal');
        $radioButton->setUseButton();
        $radioButton->setValue('b'); 

        $check = new TCheckGroup('check');
        $check->addItems($opcoes);
        $check->setLayout('horizontal');
        $check->setValue(['a', 'c']); 

        $checkButton = new TCheckGroup('checkButton');
        $checkButton->addItems($opcoes);
        $checkButton->setLayout('horizontal');
        $checkButton->setUseButton();
        $checkButton->setValue(['a', 'c']);
        
        $combo = new TCombo('combo');
        $combo->addItems($opcoes);
        $combo->setValue('b'); 
        
        $comboSearch = new TCombo('comboSearch');
        $comboSearch->addItems($opcoes);
        $comboSearch->enableSearch();
        $comboSearch->setValue('b'); 

        $select = new TSelect('select');
        $select->addItems($opcoes);
        $select->setValue(['a', 'c']);

        $search = new TMultiSearch('search');
        $search->addItems($opcoes);
        $search->setMinLength(1);
        //min de caracteres a ser digitado p/iniciar a busca, por padrão é 3 para mudar tem que inserir o setMinLength. 
        $search->setValue(['a', 'c']);

        $unique = new TUniqueSearch('unique');
        $unique->addItems($opcoes);
        $unique->setMinLength(1);
        $unique->setValue(['b']);

        $multi = new TMultiEntry('multi');
        $multi->setMaxSize(3);
        $multi->setValue(['opção1', 'opção2']);

        $autocomp = new TEntry('autocomplete');
        $autocomp->setCompletion(['Maria', 'Pedro', 'João', 'Gustavo', 'Letícia']);

        $this->form->addFields( [new TLabel('Radio')], [$radio] );
        $this->form->addFields( [new TLabel('Radio tipo Botão')], [$radioButton] );
        $this->form->addFields( [new TLabel('Check')], [$check] );
        $this->form->addFields( [new TLabel('Check tipo Botão')], [$checkButton] );
        $this->form->addFields( [new TLabel('Combo simples')], [$combo] );
        $this->form->addFields( [new TLabel('Combo Search')], [$comboSearch] );
        $this->form->addFields( [new TLabel('Select')], [$select] );
        $this->form->addFields( [new TLabel('Busca múltipla')], [$search] );
        $this->form->addFields( [new TLabel('Busca única')], [$unique] );
        $this->form->addFields( [new TLabel('Entrada múltipla')], [$multi] );
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