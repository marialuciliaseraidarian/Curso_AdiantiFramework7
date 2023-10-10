<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridActionGroup;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class DatagridGrupoAcoes extends TPage
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
        $this->datagrid->enablePopover('Detalhes', '<b>ID</b> {id} <br> <b>Nome</b> {nome} <br> <b>Cidade</b> {cidade} <br> <b>Estado</b> {estado} <br> <b>País</b> {pais}');

        $col_id = new TDataGridColumn('id', 'Código', 'center', '10%');
        $col_nome = new TDataGridColumn('nome', 'Nome', 'left', '30%');
        $col_cidade = new TDataGridColumn('cidade', 'Cidade', 'left', '30%');
        $col_estado = new TDataGridColumn('estado', 'Estado', 'left', '30%');   

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_cidade);
        $this->datagrid->addColumn($col_estado);        

        $action1 = new TDataGridAction([ $this, 'onView' ], [ 'id' => '{id}', 'nome' => '{nome}' ]);
        $action2 = new TDataGridAction([ $this, 'onDelete' ], [ 'id' => '{id}', 'nome' => '{nome}' ]);
        $action3 = new TDataGridAction([ $this, 'onPrint' ], [ 'id' => '{id}', 'nome' => '{nome}' ]);

        $action1->setLabel('Visualiza');
        $action1->setImage('fa:search blue');

        $action2->setLabel('Exclui');
        $action2->setImage('fa:trash red');

        $action3->setLabel('Imprimi');
        $action3->setImage('fa:print green');

        $action_group = new TDataGridActionGroup('Ações', 'fa:th');
        $action_group->addHeader('Grupo 1:');
        $action_group->addSeparator();
        $action_group->addAction($action1);
        $action_group->addAction($action2);
        $action_group->addSeparator();
        $action_group->addHeader('Grupo 2:'); 
        $action_group->addSeparator();       
        $action_group->addAction($action3);   
        
        $this->datagrid->addActionGroup($action_group);

        $this->datagrid->createModel();       

        $panel = new TPanelGroup('Datagrid');
        $panel->add($this->datagrid);

        parent::add($panel);
    }

    public static function onView($param)
    {
        new TMessage('info', 'ID: ' . $param['id'] . ' - nome: ' . $param['nome'] );
    }

    public static function onDelete($param)
    {
        new TMessage('error', 'ID: ' . $param['id'] . ' - nome: ' . $param['nome'] );
    }

    public static function onPrint($param)
    {
        
    }

    public function onReload()
    {
        $this->datagrid->clear(); //garante que a datagrid esteja limpa antes de exibir os registros.

        $item = new stdclass;
        $item->id = 1;
        $item->nome = 'Aretha Franklin';
        $item->cidade = 'Memphis';
        $item->estado = 'Tenessee (US)';
        $item->pais = 'Estados Unidos';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 2;
        $item->nome = 'Eric Clapton';
        $item->cidade = 'Ripley';
        $item->estado = 'Surrey (UK)';
        $item->pais = 'Reino Unido';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 3;
        $item->nome = 'B.B. King';
        $item->cidade = 'Itta Bena';
        $item->estado = 'Mississipi (US)';
        $item->pais = 'Estados Unidos';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 4;
        $item->nome = 'Janis Joplin';
        $item->cidade = 'Port Arthur';
        $item->estado = 'Texas (US)';
        $item->pais = 'Estados Unidos';
        $this->datagrid->addItem($item);
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}