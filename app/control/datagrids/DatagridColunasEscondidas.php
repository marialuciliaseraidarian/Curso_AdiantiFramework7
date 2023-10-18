<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class DatagridColunasEscondidas extends TPage
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';
                
        $col_id         = new TDataGridColumn('id',         'Código',     'center');
        $col_nome       = new TDataGridColumn('nome',       'Nome',       'left');
        $col_nascimento = new TDataGridColumn('nascimento', 'Nascimento', 'left');
        $col_cidade     = new TDataGridColumn('cidade',     'Cidade',     'left');
        $col_estado     = new TDataGridColumn('estado',     'Estado',     'left');
        $col_pais       = new TDataGridColumn('pais',       'País',       'left');
        $col_telefone   = new TDataGridColumn('telefone',   'Telefone',   'left');
        $col_email      = new TDataGridColumn('email',      'E-mail',     'left');
        
        $col_nascimento->enableAutoHide(500);
        $col_cidade->enableAutoHide(600);
        $col_estado->enableAutoHide(700);
        $col_pais->enableAutoHide(800);
        $col_telefone->enableAutoHide(900);
        $col_email->enableAutoHide(1000);

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_nascimento);
        $this->datagrid->addColumn($col_cidade);
        $this->datagrid->addColumn($col_estado);
        $this->datagrid->addColumn($col_pais);
        $this->datagrid->addColumn($col_telefone);
        $this->datagrid->addColumn($col_email);

        $action1 = new TDataGridAction([ $this, 'onView' ], [ 'id' => '{id}', 'nome' => '{nome}' ]);
        $action2 = new TDataGridAction([ $this, 'onDelete' ], [ 'id' => '{id}', 'nome' => '{nome}' ]);

        $this->datagrid->addAction( $action1, 'Visualiza', 'fa:search blue' );
        $this->datagrid->addAction( $action2, 'Exclui', 'fa:trash red' );
        
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
    
    public function onReload()
    {
        $this->datagrid->clear(); //garante que a datagrid esteja limpa antes de exibir os registros.

        $item = new stdclass;
        $item->id = 1;
        $item->nome = 'Aretha Franklin';
        $item->nascimento = '25/03/1942';
        $item->cidade = 'Memphis';
        $item->estado = 'Tenessee (US)';
        $item->pais = 'Estados Unidos';
        $item->telefone = '111 111 111 1111';
        $item->email = 'aretha@gmail.com';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 2;
        $item->nome = 'Eric Clapton';
        $item->nascimento = '25/03/1942';
        $item->cidade = 'Ripley';
        $item->estado = 'Surrey (UK)';
        $item->pais = 'Reino Unido';
        $item->telefone = '222 222 222 2222';
        $item->email = 'eric@gmail.com';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 3;
        $item->nome = 'B.B. King';
        $item->nascimento = '25/03/1942';
        $item->cidade = 'Itta Bena';
        $item->estado = 'Mississipi (US)';
        $item->pais = 'Estados Unidos';
        $item->telefone = '333 333 333 3333';
        $item->email = 'bbking@gmail.com';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 4;
        $item->nome = 'Janis Joplin';
        $item->nascimento = '25/03/1942';
        $item->cidade = 'Port Arthur';
        $item->estado = 'Texas (US)';
        $item->pais = 'Estados Unidos';
        $item->telefone = '444 444 444 4444';
        $item->email = 'janis@gmail.com';
        $this->datagrid->addItem($item);
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}