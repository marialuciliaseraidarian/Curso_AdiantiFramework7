<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TFieldList;
use Adianti\Wrapper\BootstrapFormBuilder;

class BootstrapFieldList extends TPage
{
    public function __construct()
    {
        parent::__construct();
        $this->form = new BootstrapFormBuilder('meu_form');
        $this->form->setFormTitle('Lista de campos');

        $combo = new TCombo('combo[]');//os [] no final do campo indica que é um campo vetorial
        $texto = new TEntry('texto[]');
        $numero = new TEntry('valor[]');
        $data = new TDate('dt_registro[]');

        $combo->enableSearch(); //faz com que ao datilografar vá aparecendo as opções
        $combo->addItems(['a' => 'Opção A', 'b' => 'Opção B']); //preenche algumas opções no combo
        $combo->setSize('100%');
        $texto->setSize('100%');
        $numero->setNumericMask(2, ',', '.', true);
        $numero->setSize('100%');
        $numero->style = 'text-align: right';
        $data->setSize('100%');

       /*  fieldlist => componente de lista de campos, fica ao redor dos campos que adiciona as funcionalidade
        de excluir, adicionar linhas */
        $fieldlist = new TFieldList;
        $fieldlist->width = '100%';
        
       /* O addField recebe 3 parâmetros, nome da coloca, o objeto que vai dentro da célula da linha,
       como terceiro parâmetro (opcional), posso incluir um vetor de propriedades daquela coluna.  */
       $fieldlist->addField('<b>Combo</b>', $combo, ['width' => '25%']);
       $fieldlist->addField('<b>Texto</b>', $texto, ['width' => '25%']);
       $fieldlist->addField('<b>Número</b>', $numero, ['width' => '25%']);
       $fieldlist->addField('<b>Data</b>', $data, ['width' => '25%']);

       //Para mover uma linha usamos o método enableSorting:
       $fieldlist->enableSorting();

       $fieldlist->addHeader();//adiciona o cabeçalho no fieldlist
       $fieldlist->addDetail( new stdClass ); //adiciona uma linha em branco no fieldlist
       $fieldlist->addCloneAction();//cria o botão de clonagem
    
       $this->form->addField($combo);
       $this->form->addField($numero);
       $this->form->addField($data);
       $this->form->addField($texto);

       //com o método addContent vamos inserir o fieldlist dentro do formulário (form):
        $this->form->addContent( [$fieldlist] );
        $this->form->addAction('Enviar', new TAction([$this, 'onSend']), 'fa:save' );

        
        parent::add( $this->form );
    }

    public static function onSend($param)
    {
        var_dump($param);
    }
}