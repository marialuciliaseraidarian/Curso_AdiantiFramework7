<?php

use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;

class InformationView extends TPage 
{
    public function __construct()
    {
        parent::__construct();

        new TMessage('info', 'Mensagem');        
        new TMessage('info', 'Mensagem');        
    }
}