<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Validator\TEmailValidator;
use Adianti\Validator\TMaxLengthValidator;
use Adianti\Validator\TMaxValueValidator;
use Adianti\Validator\TMinLengthValidator;
use Adianti\Validator\TMinValueValidator;
use Adianti\Validator\TNumericValidator;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioValidacoes extends TPage
{
    private $form;

    public function __construct()
    {
       parent::__construct();

       $this->form = new BootstrapFormBuilder();
       $this->form->setFormTitle('Validações');
       $this->form->setClientValidation(true);

       $field1 = new TEntry('field1');
       $field2 = new TEntry('field2');
       $field3 = new TEntry('field3');
       $field4 = new TEntry('field4');
       $field5 = new TEntry('field5');
       $field6 = new TEntry('field6');
       $field7 = new TEntry('field7');

       $this->form->addFields( [new TLabel('Field 1')], [$field1] );
       $this->form->addFields( [new TLabel('Field 2')], [$field2] );
       $this->form->addFields( [new TLabel('Field 3')], [$field3] );
       $this->form->addFields( [new TLabel('Field 4')], [$field4] );
       $this->form->addFields( [new TLabel('Field 5')], [$field5] );
       $this->form->addFields( [new TLabel('Field 6')], [$field6] );
       $this->form->addFields( [new TLabel('Field 7')], [$field7] );

       $field1->addValidation('Field 1', new TMinLengthValidator, [3]);
       $field2->addValidation('Field 2', new TMaxLengthValidator, [20]);
       $field3->addValidation('Field 3', new TMinValueValidator, [1]);
       $field4->addValidation('Field 4', new TMaxValueValidator, [10]);
       $field5->addValidation('Field 5', new TRequiredValidator);
       $field6->addValidation('Field 6', new TRequiredValidator);
       $field6->addValidation('Field 6', new TEmailValidator);
       $field7->addValidation('Field 7', new TNumericValidator);


       $this->form->addAction( 'Enviar', new TAction([$this, 'onSend']), 'fa:save');
       
       parent::add($this->form);
    }

    public function onSend($param)
    {
        try {
            $data = $this->form->getData();

            $this->form->validate();

            $this->form->setData($data);
        
            echo '<pre>';
            var_dump($data);
            echo '</pre>';
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }        
    }
}