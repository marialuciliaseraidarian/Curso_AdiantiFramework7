<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Util\TIconView;

class IconView extends TPage
{
    private $iconview;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->iconview = new TIconView;
        
        $item = new stdClass;
        $item->tipo    = 'pasta';
        $item->caminho = '/pasta-a';
        $item->nome    = 'Pasta A';
        $item->icone   = 'far:folder blue fa-4x';
        $this->iconview->addItem($item);
        
        $item = new stdClass;
        $item->tipo    = 'pasta';
        $item->caminho = '/pasta-b';
        $item->nome    = 'Pasta B';
        $item->icone   = 'far:folder blue fa-4x';
        $this->iconview->addItem($item);
        
        $item = new stdClass;
        $item->tipo    = 'arquivo';
        $item->caminho = '/arquivo-a';
        $item->nome    = 'Arquivo A';
        $item->icone   = 'far:file orange fa-4x';
        $this->iconview->addItem($item);
        
        $item = new stdClass;
        $item->tipo    = 'arquivo';
        $item->caminho = '/arquivo-b';
        $item->nome    = 'Arquivo B';
        $item->icone   = 'far:file orange fa-4x';
        $this->iconview->addItem($item);
        
        $item = new stdClass;
        $item->tipo    = 'arquivo';
        $item->caminho = '/arquivo-c';
        $item->nome    = 'Arquivo C';
        $item->icone   = 'far:file orange fa-4x';
        $this->iconview->addItem($item);

        //Adiciona um popover com o nome        
        // $this->iconview->enablePopover('', '<b>Nome:</b> {nome}');
        
       //define os atributos, qual é o icone, qual é o label, etc.
        $this->iconview->setIconAttribute('icone');
        $this->iconview->setLabelAttribute('nome');
        $this->iconview->setInfoAttributes(['nome', 'caminho']);//passa os atributos selecionados para as ações
        
        //a display-condition mostra ou oculta uma ação de acordo com a condição inserida, neste caso só aparecerá a opção de excluir
        // para os arquivos, para as pastas não aparecerá
        $display_condition = function($object) {
            return ($object->tipo == 'arquivo');
        };
        
       //cria um menu com opções de ações, ela será visível se clicar com o botão direito em cima do ícone.
        $this->iconview->addContextMenuOption('Opções');
        $this->iconview->addContextMenuOption('');
        $this->iconview->addContextMenuOption('Abrir', new TAction([$this, 'onOpen']), 'far:folder-open blue');
        $this->iconview->addContextMenuOption('Renomear', new TAction([$this, 'onRename']), 'far:edit green');
        $this->iconview->addContextMenuOption('Excluir', new TAction([$this, 'onDelete']), 'fas:trash-alt red', $display_condition);
        
        parent::add( $this->iconview );
    }
    
    public static function onOpen($param)
    {
        new TMessage('info', '<b>Nome:</b>' . $param['nome'] . '<br> <b>Caminho:</b>:' . $param['caminho']);
    }
    
    public static function onRename($param)
    {
        new TMessage('info', '<b>Nome:</b>' . $param['nome'] . '<br> <b>Caminho:</b>:' . $param['caminho']);
    }
    
    public static function onDelete($param)
    {
        new TMessage('info', '<b>Nome:</b>' . $param['nome'] . '<br> <b>Caminho:</b>:' . $param['caminho']);
    }
}