<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class DatagridFormatacao extends TPage
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
        $col_cache      = new TDataGridColumn('cache',      'Cache',      'right');  
        
        $col_cache->setDataProperty('Style', 'font-weight: bold');
        $col_cache->setTransformer( [ $this, 'formatCache' ] );
        $col_nascimento->setTransformer( [ $this, 'formatDate' ] );

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_nascimento);
        $this->datagrid->addColumn($col_cidade);
        $this->datagrid->addColumn($col_estado);
        $this->datagrid->addColumn($col_cache);

        $action1 = new TDataGridAction([ $this, 'onView' ], [ 'id' => '{id}', 'nome' => '{nome}' ]);
        $action2 = new TDataGridAction([ $this, 'onDelete' ], [ 'id' => '{id}', 'nome' => '{nome}' ]);        

        $this->datagrid->addAction( $action1, 'Visualiza', 'fa:search blue' );
        $this->datagrid->addAction( $action2, 'Exclui', 'fa:trash red' );

        $this->datagrid->createModel(); 
               
        $panel = new TPanelGroup('Datagrid');        
        $panel->add($this->datagrid);

        parent::add($panel);
    }

    public function formatCache($cache, $object, $row) //própria coluna formatada, a linha inteira na forma de um objeto, e a linha inteira na forma de objeto DOM a tr que é o elemento visual
    {
        $formatado = number_format($cache, 2, ',', '.');

        if ($cache > 1000000)
        {
            $row->style = 'background: #FFF9A7';

            return "<span style='color:green'> $formatado </span>";
        }
            else
            {
                return "<span style='color:blue'> $formatado </span>";
            }
    }

    public function formatDate($nacimento, $object, $row)
    {
        $date = new DateTime($object->nascimento);
        return $date->format('d/m/Y');
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
        $item->nascimento = '1942-03-25';
        $item->cidade = 'Memphis';
        $item->estado = 'Tenessee (US)';
        $item->pais = 'Estados Unidos';
        $item->cache = '1200000';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 2;
        $item->nome = 'Eric Clapton';
        $item->nascimento = '1945-03-30';
        $item->cidade = 'Ripley';
        $item->estado = 'Surrey (UK)';
        $item->pais = 'Reino Unido';
        $item->cache = '900000';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 3;
        $item->nome = 'B.B. King';
        $item->nascimento = '1925-09-16';
        $item->cidade = 'Itta Bena';
        $item->estado = 'Mississipi (US)';
        $item->pais = 'Estados Unidos';
        $item->cache = '1500000';
        $this->datagrid->addItem($item);

        $item = new stdclass;
        $item->id = 4;
        $item->nome = 'Janis Joplin';
        $item->nascimento = '1943-01-19';
        $item->cidade = 'Port Arthur';
        $item->estado = 'Texas (US)';
        $item->pais = 'Estados Unidos';
        $item->cache = '800000';
        $this->datagrid->addItem($item);        
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}