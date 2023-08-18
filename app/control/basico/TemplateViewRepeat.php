<?php
class TemplateViewRepeat extends TPage
{
    public function __construct()
    {
        parent::__construct();
    
        try
        {
            $html = new THtmlRenderer('app/resources/template-repeat.html');
            
            $replace = [];
            $replace[] = [ 'id' => 1, 'nome' => 'Peter', 'endereco' => 'Rua 1' ];
            $replace[] = [ 'id' => 2, 'nome' => 'Mary',  'endereco' => 'Rua 2' ];
            $replace[] = [ 'id' => 3, 'nome' => 'John',  'endereco' => 'Rua 3' ];
            
            $html->enableSection('main', []);
            $html->enableSection('details', $replace, true);
            
            parent::add($html);
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
}
