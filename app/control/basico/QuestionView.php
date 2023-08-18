<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TQuestion;

class QuestionView extends TPage 
{
    public function __construct()
    {
        parent::__construct();

        $action1 = new TAction( [$this, 'onActionYes'] );
        $action1->setParameter('nome', 'ação1');
        $action2 = new TAction( [$this, 'onActionNo'] );
        $action2->setParameter('nome', 'ação2');

        new TQuestion('Você gostaria de executar esta operação?', $action1, $action2);        
    }

    public static function onActionYes($param)
    {
        new TMessage('info', 'Você escolheu SIM para a ' . $param['nome']);
    }

    public static function onActionNo($param)
    {
        new TMessage('error', 'Você escolheu NÃO para a ' . $param['nome']);
    }
}