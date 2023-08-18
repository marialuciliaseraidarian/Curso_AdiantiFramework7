<?php
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
        
        // $this->iconview->enablePopover('', '<b>Nome:</b> {nome}');
        
        $this->iconview->setIconAttribute('icone');
        $this->iconview->setLabelAttribute('nome');
        $this->iconview->setInfoAttributes(['nome', 'caminho']);
        
        $display_condition = function($object) {
            return ($object->tipo == 'arquivo');
        };
        
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