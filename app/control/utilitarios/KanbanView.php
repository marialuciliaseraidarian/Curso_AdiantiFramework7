<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Util\TKanban;

class KanbanView extends TPage
{
    public function __construct()
    {
        parent::__construct();
        
        $kanban = new TKanban;
        
        //cria as colunas com para as fases
        $kanban->addStage( 1, 'Fase 1');
        $kanban->addStage( 2, 'Fase 2');
        $kanban->addStage( 3, 'Fase 3');
        
        //adiciona os cards dentro das fases
        $kanban->addItem( 101, 1, 'Item 1.1', 'Conteúdo 1.1', '#FF1818');
        $kanban->addItem( 102, 1, 'Item 1.2', 'Conteúdo 1.2', '#57D557');
        $kanban->addItem( 201, 2, 'Item 2.1', 'Conteúdo 2.1', '#FF1818');
        $kanban->addItem( 202, 2, 'Item 2.2', 'Conteúdo 2.2', '#57D557');
        $kanban->addItem( 301, 3, 'Item 3.1', 'Conteúdo 3.1', '#FF1818');
        $kanban->addItem( 302, 3, 'Item 3.2', 'Conteúdo 3.2', '#57D557');
        
        //adiciona ação às colunas das fases
        $kanban->addStageAction( 'Editar', new TAction([$this, 'onEditStage']), 'fa:edit fa-fw blue');
        $kanban->addStageAction( 'Excluir', new TAction([$this, 'onDeleteStage']), 'fas:trash-alt red fa-fw');
        
         //adiciona ação aos cards
        $kanban->addItemAction('Editar', new TAction([$this, 'onEditItem']), 'fa:edit blue');
        $kanban->addItemAction('Excluir', new TAction([$this, 'onDeleteItem']), 'fas:trash-alt red');
        
        //insere a ação para mover uma coluna de fase
        $kanban->setStageDropAction(new TAction([$this, 'onStageDrop']));
        //insere ação para mover os cards
        $kanban->setItemDropAction(new TAction([$this, 'onItemDrop']));
        
        parent::add( $kanban );
    }
    
    public static function onEditStage($param)
    {
        new TMessage('info', '<b>onEditStage</b> <br> ' . str_replace(',', '<br>', json_encode($param)));
    }
    
    public static function onDeleteStage($param)
    {
        new TMessage('info', '<b>onDeleteStage</b> <br> ' . str_replace(',', '<br>', json_encode($param)));
    }
    
    public static function onEditItem($param)
    {
        new TMessage('info', '<b>onEditItem</b> <br> ' . str_replace(',', '<br>', json_encode($param)));
    }
    
    public static function onDeleteItem($param)
    {
        new TMessage('info', '<b>onDeleteItem</b> <br> ' . str_replace(',', '<br>', json_encode($param)));
    }
    
    public static function onStageDrop($param)
    {
        new TMessage('info', '<b>onStageDrop</b> <br> ' . str_replace(',', '<br>', json_encode($param)));
    }
    
    public static function onItemDrop($param)
    {
        new TMessage('info', '<b>onItemDrop</b> <br> ' . str_replace(',', '<br>', json_encode($param)));
    }
}