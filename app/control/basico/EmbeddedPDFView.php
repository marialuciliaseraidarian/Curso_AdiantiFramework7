<?php
class EmbeddedPDFView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $object = new TElement('iframe');
        $object->src   = 'https://adiantiframework.com.br/resources/framework/adianti_framework.pdf';
        $object->type  = 'application/pdf';
        $object->style = "width: 100%; height:600px";
        
        parent::add($object);
    }
}
