<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Registry\TSession;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class CidadeTraitList extends TPage
{
    private $form;
    private $datagrid;
    private $pageNavigation;    

    use \Adianti\Base\AdiantiStandardListTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setDatabase('curso');
        $this->setActiveRecord('Cidade');
        $this->addFilterField('nome', 'like', 'nome');
        $this->setDefaultOrder('id', 'asc');
        $this->setOrderCommand('estado->nome', '(select nome from estado where estado_id = estado.id)');

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Listagem de Cidades');

        $nome = new TEntry('nome');
       
        $this->form->addFields( [new TLabel('Cidade')], [$nome] );
        $this->form->setData(TSession::getValue(__CLASS__.'_filter_data'));

        $this->form->addAction('Buscar', new TAction( [$this, 'onSearch'] ), 'fa:search blue');
        $this->form->addActionLink('Limpar', new TAction( [$this, 'clear']), 'fa:eraser red');
        $this->form->addActionLink('Cadastrar', new TAction( ['CidadeForm', 'onClear']), 'fa:plus-circle green');

        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';

        $col_id = new TDataGridColumn('id', 'Código', 'left', '10%');
        $col_nome = new TDataGridColumn('nome', 'Cidade', 'left', '60%');
        $col_estado = new TDataGridColumn('estado->nome', 'Estado', 'left', '30%');

        $col_id->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);
        $col_nome->setAction(new TAction([$this, 'onReload']), ['order' => 'nome']);
        $col_estado->setAction(new TAction([$this, 'onReload']), ['order' => 'estado->nome']);

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_nome);
        $this->datagrid->addColumn($col_estado);

        $actionEdit = new TDataGridAction( ['CidadeForm', 'onEdit'], ['key' => '{id}'] );
        $actionDelete = new TDataGridAction( [$this, 'onDelete'], ['key' => '{id}'] );

        $this->datagrid->addAction($actionEdit, 'Editar', 'fa:edit blue');
        $this->datagrid->addAction($actionDelete, 'Excluir', 'fa:trash-alt red');

        $this->datagrid->createModel();

        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        
        $panel = new TPanelGroup();
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);

        //cria caixa vertical para inserir os elementos na ordem que queremos mostrar em tela
        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add($this->form);
        $vbox->add($panel);

        parent::add($vbox);
    }
    
    public function clear()
    {
        $this->clearFilters();
        $this->onReload();
    }
}