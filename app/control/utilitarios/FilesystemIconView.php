<?php
class FilesystemIconView extends TPage
{
    private $iconview;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->iconview = new TIconView;
        
        $dir = new DirectoryIterator( getcwd() );
        
        foreach ($dir as $fileinfo)
        {
            if (!$fileinfo->isDot())
            {
                $item = new stdClass;
                
                if ($fileinfo->isDir())
                {
                    $item->tipo = 'pasta';
                    $item->icone = 'far:folder blue fa-4x';
                }
                else
                {
                    $item->tipo = 'arquivo';
                    $item->icone = 'far:file orange fa-4x';
                }
                
                $item->caminho = $fileinfo->getPath();
                $item->nome    = $fileinfo->getFilename();
            }
            
            $this->iconview->addItem($item);
        }
        
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