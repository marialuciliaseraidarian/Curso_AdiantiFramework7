<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Util\TTimeline;

class TimelineView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        //cria linha do tempo
        $timeline = new TTimeline;
        
        //
        $obj1 = (object) [ 'nome' => 'AAAAA', 'tipo' => 'ativo' ];
        $obj2 = (object) [ 'nome' => 'BBBBB', 'tipo' => 'inativo' ];
        $obj3 = (object) [ 'nome' => 'CCCCC', 'tipo' => 'ativo' ];
        $obj4 = (object) [ 'nome' => 'DDDDD', 'tipo' => 'inativo' ]; 
        
        //adiciona itens, podem ser trazidos do BD, no exemplo estamos fazendo manualmente.
        // parametros: id, novme do evento, titulo do evento, data e hora, ícone a ser usado, lado a linha em que ficará, objeto.
        $timeline->addItem( 1, 'Evento 1', 'Este é o evento {id} - {nome}', '2019-11-10 12:00:00', 'fa:arrow-left bg-green', 'left', $obj1);
        $timeline->addItem( 2, 'Evento 2', 'Este é o evento {id} - {nome}', '2019-11-10 14:00:00', 'fa:arrow-left bg-green', 'left', $obj2);
        $timeline->addItem( 3, 'Evento 3', 'Este é o evento {id} - {nome}', '2019-11-11 12:00:00', 'fa:arrow-right bg-blue', 'right', $obj3);
        $timeline->addItem( 4, 'Evento 4', 'Este é o evento {id} - {nome}', '2019-11-11 12:00:00', 'fa:arrow-right bg-blue', 'right', $obj4);
        
        $timeline->setUseBothSides();//habilita a função de usar os dois lados da timeline, na hora de adicionar o ítem colocamos de que lado queremos que ele esteja.
        $timeline->setTimeDisplayMask('dd/mm/yyyy');//máscara de exibição das datas
        $timeline->setFinalIcon('fa:flag-checkered bg-red');//ícone final da timeline
        
        //cria ações para os eventos, para isso precisa ter objetos 
        $action1 = new TAction([$this, 'onEdit'],   ['id' => '{id}', 'nome' => '{nome}']);
        $action2 = new TAction([$this, 'onDelete'], ['id' => '{id}', 'nome' => '{nome}']);
        
        //altera a classe do botão para uma classe bootstrap:
        //$action1->setProperty('btn-class', 'btn btn-primary');
        
        //condição para que seja exibido a ação de excluir
        $display_condition = function($object) {
            return ($object->tipo == 'ativo');
        };
        
        $timeline->addAction($action1, 'Editar',  'fa:edit blue');
        $timeline->addAction($action2, 'Excluir', 'fa:trash red', $display_condition);
        
        parent::add($timeline);
    }
    
    //ações fictícias, só para funcionar.
    public static function onEdit($param)
    {
        new TMessage('info', 'Ação onEdit: <br> <b> ID </b>: ' .$param['id'] . ' <b> Nome: </b> ' . $param['nome']);
    }
    
    public static function onDelete($param)
    {
        new TMessage('info', 'Ação onDelete: <br> <b> ID </b>: ' .$param['id'] . ' <b> Nome: </b> ' . $param['nome']);
    }    
}