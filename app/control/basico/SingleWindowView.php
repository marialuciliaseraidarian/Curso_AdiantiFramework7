<?php
class SingleWindowView extends TWindow
{
    public function __construct()
    {
        parent::__construct();
        parent::setTitle('Título da janela');
        parent::setSize(0.5, null);
        
        $html = new THtmlRenderer('app/resources/page.html');
        
        $replaces = [];
        $replaces['title']  = 'Título';
        $replaces['body']   = 'Conteúdo';
        $replaces['footer'] = 'Rodapé';
        
        $html->enableSection('main', $replaces);
        
        parent::add($html);
        
    }
}
