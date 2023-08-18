<?php
class TimelineView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $timeline = new TTimeline;
        
        $obj1 = (object) [ 'nome' => 'AAAAA', 'tipo' => 'ativo' ];
        $obj2 = (object) [ 'nome' => 'BBBBB', 'tipo' => 'inativo' ];
        $obj3 = (object) [ 'nome' => 'CCCCC', 'tipo' => 'ativo' ];
        $obj4 = (object) [ 'nome' => 'DDDDD', 'tipo' => 'inativo' ]; 
        
        $timeline->addItem( 1, 'Evento 1', 'Este é o evento {id} - {nome}', '2019-11-10 12:00:00', 'fa:arrow-left bg-green', 'left', $obj1);
        $timeline->addItem( 2, 'Evento 2', 'Este é o evento {id} - {nome}', '2019-11-10 14:00:00', 'fa:arrow-left bg-green', 'left', $obj2);
        $timeline->addItem( 3, 'Evento 3', 'Este é o evento {id} - {nome}', '2019-11-11 12:00:00', 'fa:arrow-right bg-blue', 'right', $obj3);
        $timeline->addItem( 4, 'Evento 4', 'Este é o evento {id} - {nome}', '2019-11-11 12:00:00', 'fa:arrow-right bg-blue', 'right', $obj4);
        
        $timeline->setUseBothSides();
        $timeline->setTimeDisplayMask('dd/mm/yyyy');
        $timeline->setFinalIcon('fa:flag-checkered bg-red');
        
        $action1 = new TAction([$this, 'onEdit'],   ['id' => '{id}', 'nome' => '{nome}']);
        $action2 = new TAction([$this, 'onDelete'], ['id' => '{id}', 'nome' => '{nome}']);
        
        //$action1->setProperty('btn-class', 'btn btn-primary');
        
        $display_condition = function($object) {
            return ($object->tipo == 'ativo');
        };
        
        $timeline->addAction($action1, 'Editar',  'fa:edit blue');
        $timeline->addAction($action2, 'Excluir', 'fa:trash red', $display_condition);
        
        parent::add($timeline);
    }
    
    public static function onEdit($param)
    {
        new TMessage('info', 'Ação onEdit: <br> <b> ID </b>: ' .$param['id'] . ' <b> Nome: </b> ' . $param['nome']);
    }
    
    public static function onDelete($param)
    {
        new TMessage('info', 'Ação onDelete: <br> <b> ID </b>: ' .$param['id'] . ' <b> Nome: </b> ' . $param['nome']);
    }
    
}