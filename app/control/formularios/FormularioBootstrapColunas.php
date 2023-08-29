
<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioBootstrapColunas extends TPage
{
    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder('meu_form');
        $this->form->setFormTitle('Formulário Bootstrap Colunas');

        $this->form->appendPage('Colunas automáticas');//cria uma aba
        //cria 2 campos automaticos, label e imput para dado
        $this->form->addFields( [new TLabel('2 campos')], [new TEntry('campo')] );
         //cria 6 campos automaticos, label e imput para dado
         $this->form->addFields( [new TLabel('Label 1')],
                                 [new TEntry('Campo1')],
                                 [new TLabel('Label 2')],
                                 [new TEntry('campo2')],
                                 [new TLabel('Label 3')],
                                 [new TEntry('campo3')] );

        $this->form->addFields( [new TEntry('Campo4')],
                                [new TEntry('Campo5')],
                                [new TEntry('Campo6')],
                                [new TEntry('campo7')],
                                [new TEntry('Campo8')],
                                [new TEntry('campo9')] ); 
                                
        $this->form->appendPage('Colunas manuais');//cria uma aba                               
        $row = $this->form->addFields( [new TEntry('imput1')],
                                       [new TEntry('imput2')],
                                       [new TEntry('imput3')],
                                       [new TEntry('imput4')], );
        $row->layout = [ 'col-sm-2', 'col-sm-4', 'col-sm-3', 'col-sm-3' ]; 
        
        $row2 = $this->form->addFields( [new TLabel('Label A1')],
                                       [new TEntry('imputA1')],
                                       [new TLabel('Label A2')],
                                       [new TEntry('imputA2')], );
        $row2->layout = [ 'col-sm-2 control-label', 'col-sm-4', 'col-sm-2 control-label', 'col-sm-4' ];

        $this->form->addAction('Enviar', new TAction( [$this, 'onSend'] ), 'fa:save' );                                     
                                
        parent::add($this->form);
    }

    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);

        new TMessage( 'info', json_encode($data) );
    }
}