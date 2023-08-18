<?php
class SidePageView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        parent::setTargetContainer('adianti_right_panel');
        
        $html = new THtmlRenderer('app/resources/side.html');
        
        $replaces = [];
        $replaces['title']  = 'Título';
        $replaces['body']   = 'Conteúdo';
        $replaces['footer'] = 'Rodapé';
        
        $html->enableSection('main', $replaces);
        
        parent::add($html);
    }
    
    public static function onClose()
    {
        TScript::create('Template.closeRightPanel()');
    }
}