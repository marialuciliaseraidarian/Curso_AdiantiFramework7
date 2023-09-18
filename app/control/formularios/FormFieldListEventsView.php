<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TToast;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TFieldList;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Form\THidden;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormFieldListEventsView extends TPage
{
    private $form;
    private $fieldlist;

    public function __construct()
    {
        parent::__construct();
        $this->form = new BootstrapFormBuilder('my_form');
        $this->form->setFormTitle(_t('Form field list'));

        $uniq = new THidden('uniq[]');

        $combo = new TCombo('combo[]');
        $combo->enableSearch();
        $combo->addItems(['1'=>'<b>One</b>', '2'=>'<b>Two</b>', '3'=>'<b>Three</b>','4'=>'<b>Four</b>', '5'=>'<b>Five</b>']);
        $combo->setSize('100%');

        $text = new TEntry('text[]');
        $text->setSize('100%');

        $number = new TEntry('number[]');
        $number->setNumericMask(2, ',', '.', true);
        $number->setSize('100%');
        $number->style='text-align: right';

        $date = new TDate('date[]');
        $date->setSize('100%');

        $this->fieldlist = new TFieldList;
        $this->fieldlist->generateAria();
        $this->fieldlist->width = '100%';
        $this->fieldlist->name = 'my_field_list';
        //primeiro parâmetro é o nome do campo, segundo é o conteúdo da linha, e terceiro é são as propriedades daquela linha.
        $this->fieldlist->addField('<b>Unniq</b>',  $uniq,   ['width'=>'0%', 'uniqid' => true]);
        $this->fieldlist->addField('<b>Combo</b>',  $combo,  ['width'=>'25%']);
        $this->fieldlist->addField('<b>Text</b>',   $text,   ['width'=>'25%']);
        $this->fieldlist->addField('<b>Number</b>', $number, ['width'=>'25%', 'sum' => true]);
        $this->fieldlist->addField('<b>Date</b>',   $date,   ['width'=>'25%']);

        $this->fieldlist->addButtonAction(new TAction( [$this, 'ShowRow'] ), 'fa:info-circle purple', 'Mostrar texto');

        //cria uma ação ao clicar no botão de remover
        $this->fieldlist->setRemoveAction( new TAction( [$this, 'ShowRow'] ));

        $this->fieldlist->enableSorting();
            
        $this->form->addField($combo);
        $this->form->addField($text);
        $this->form->addField($number);
        $this->form->addField($date);

        //adiciona o cabeçalho à fieldList
        $this->fieldlist->addHeader();
        //adiciona linhas em branco à fieldList
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addDetail( new stdClass );
        $this->fieldlist->addDetail( new stdClass );
       
        //adiciona ação de clonagem à fieldList
        $this->fieldlist->addCloneAction(new TAction( [$this, 'ShowRow'] ));

        //adiciona soma total à fieldList
        $this->fieldlist->setTotalUpdateAction(new TAction( [$this, 'onTotalUpdate'] ));

        //Adiciona lista de campos ao formulário
        $this->form->addContent( [$this->fieldlist] );

         //Ações de formulário
        $this->form->addAction('Save', new TAction([$this, 'onSave'], ['static'=>'1']), 'fa:save blue');
        $this->form->addAction('Clear', new TAction([$this, 'onClear']), 'fa:eraser red');
        $this->form->addAction('Fill', new TAction([$this, 'onFill']), 'fa:pencil-alt green');
        $this->form->addAction('Clear/Fill', new TAction([$this, 'onClearFill']), 'fas:pencil-alt orange');

        //Envolve o conteúdo da página usando a caixa vertical
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($this->form);
               
        parent::add( $vbox );
    }

    public static function ShowRow($param)
    {
        new TMessage('info', str_replace(',', '<br>', json_encode($param)));
    }

    public static function onClear($param)
    {
        TFieldList::clear('my_field_list');
        TFieldList::addRows('my_field_list', 4);
    }

    public static function onFill($param)
    {
        $data = new stdClass;
        $data->combo = [1, 2, 3, 4, 5];
        $data->text = ['Part. One', 'Part. Two', 'Part. Three', 'Part. Four', 'Part. Five'];
        $data->number = ['10,10', '20,20', '30,30', '40,40', '50,50'];
        $data->date = [ date('Y-m-d'),
                        date('Y-m-d', strtotime("+1 days")),
                        date('Y-m-d', strtotime("+2 days")),
                        date('Y-m-d', strtotime("+3 days")),
                        date('Y-m-d', strtotime("+4 days")), ];
        TForm::sendData('my_form', $data);
    }

    public static function onClearFill($param)
    {
        TFieldList::clear('my_field_list');
        TFieldList::addRows('my_field_list', 4);

        $data = new stdClass;
        $data->combo = [1, 2, 3, 4, 5];
        $data->text = ['Part. One', 'Part. Two', 'Part. Three', 'Part. Four', 'Part. Five'];
        $data->number = ['10,10', '20,20', '30,30', '40,40', '50,50'];
        $data->date = [ date('Y-m-d'),
                        date('Y-m-d', strtotime("+1 days")),
                        date('Y-m-d', strtotime("+2 days")),
                        date('Y-m-d', strtotime("+3 days")),
                        date('Y-m-d', strtotime("+4 days")), ];
        TForm::sendData('my_form', $data, false, true, 200); //200 ms de tempo limite após recriar linhas!
    }

    public static function onTotalUpdate($param)
    {
       /* echo '<pre>'; 
       var_dump($param);
       echo '</pre>'; */

       $grandtotal = 0;
       //if para verificar se veio alguma coisa preenchida
       if($param['list_data'])
       {
           foreach($param['list_data'] as $row)
           {
               //o str_replace vai mudar tudo o que está no primeiro vetor pelo que está no segundo vetor.
               //o floatval força que o valor seja passado para float antes de ser somado.
               $grandtotal += floatval(str_replace( ['.', ','], ['', '.'], $row['number']));
           }
       }

       //insere um toast informando os valores totais
       TToast::show('info', '<b>Total:</b> ' . number_format($grandtotal, 2, ',', '.'), 'bottom right');
    }

    public function onSave($param)
    {
        try {            
            $data = $this->fieldlist->getPostData();
            $this->form->validate();
            //Mostrar valores de formulário dentro de uma janela
            $win = TWindow::create('test', 0.6, 0.8);
            $win->add( '<pre>' .str_replace("\n", '<br>', print_r($data, true)). '</pre>' );
            $win->show();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }        
    }
}