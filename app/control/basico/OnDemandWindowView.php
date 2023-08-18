<?php
class OnDemandWindowView extends TPage
{
    public function __construct()
    {
        parent::__construct();

        $window = TWindow::create('título', 0.8, null);
        
        $html = new THtmlRenderer('app/resources/page.html');
        
        $replaces = [];
        $replaces['title']  = 'Título';
        $replaces['body']   = 'Conteúdo';
        $replaces['footer'] = 'Rodapé';
        
        $html->enableSection('main', $replaces);
        
        $window->add($html);
        $window->show();
    }
}
