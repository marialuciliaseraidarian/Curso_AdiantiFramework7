<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class DatagridBusca extends TPage
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';        

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

        $this->datagrid->addAction( $action1, 'Visualiza', 'fa:search blue' );
        $this->datagrid->addAction( $action2, 'Exclui', 'fa:trash red' );

        $this->datagrid->createModel(); 
        
        //cria input de busca
        $input_busca = new TEntry('input_busca');
        $input_busca->placeholder = 'Busca';
        $input_busca->setSize('100%');

        //Faz funcionar a busco no - deve ser passado como parâmetro o nome do input e os campos que deseja que seja feito o filtro da busca
        $this->datagrid->enableSearch($input_busca, 'id, nome');

        $panel = new TPanelGroup('Datagrid');
        //insere o input de busca no header do panel
        $panel->addHeaderWidget($input_busca);
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