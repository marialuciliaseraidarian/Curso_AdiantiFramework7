<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Registry\TSession;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TQuestion;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class CidadeList extends TPage
{
    private $form;
    private $datagrid;
    private $pageNavigation;
    private $loaded;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Listagem de Cidades');

        $nome = new TEntry('nome');
        $nome->setValue(TSession::getValue('CidadeList_nome'));
        $this->form->addFields( [new TLabel('Cidade')], [$nome] );

        $this->form->addAction('Buscar', new TAction( [$this, 'onSearch'] ), 'fa:search blue');
        $this->form->addActionLink('Cadastrar', new TAction( ['CidadeForm', 'onClear']), 'fa:plus-circle green');

        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->width = '100%';

        $col_id = new TDataGridColumn('id', 'Código', 'left', '10%');
        $col_nome = new TDataGridColumn('nome', 'Cidade', 'left', '60%');
        $col_estado = new TDataGridColumn('estado->nome', 'Estado', 'left', '30%');

        $col_id->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);
        $col_nome->setAction(new TAction([$this, 'onReload']), ['order' => 'nome']);
        $col_estado->setAction(new TAction([$this, 'onReload']), ['order' => 'estado_id']);

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

    public function onSearch($param)
    {
       $data = $this->form->getData();

       if(isset($data->nome))
       {
        $filter = new TFilter('nome', 'like', "%{$data->nome}%");

        //guarda o filtro em uma variável de sessão.
        TSession::setValue('CidadeList_filter', $filter);
        TSession::setValue('CidadeList_nome', $data->nome);

        $this->form->setData($data);
       }

       $this->onReload([]);
    }

    public function onReload($param)
    {
       try
       {
        TTransaction::open('curso');

        $repository = new TRepository('Cidade');

        if (empty($param['order']))
        {
           $param['order'] = 'id'; 
           $param['direction'] = 'asc';
        }

        $limit = 3;

        $criteria = new TCriteria;
        $criteria->setProperty('limit', $limit);
        $criteria->setProperties($param);  
        
        if(TSession::getValue('CidadeList_filter'))
        {
            $criteria->add(TSession::getValue('CidadeList_filter'));
        }
        
        $cidades = $repository->load( $criteria );
        $this->datagrid->clear();

        if($cidades)
        {
            foreach ($cidades as $cidade)
            {
                $this->datagrid->addItem($cidade);
            }
        }
        
        //limpa algumas propriedades que impem a contagem total dos registros
        $criteria->resetProperties();
        //faz a contagem total dos registros retornados para depois pode configurar a paginação
        $count = $repository->count($criteria);

        //configura o na navegador de páginas
        $this->pageNavigation->setCount($count);
        $this->pageNavigation->setProperties($param);
        $this->pageNavigation->setLimit($limit);

        $this->loaded = true;
        TTransaction::close();
       }
       catch (Exception $e)
       {
        new TMessage('error', $e->getMessage());
        TTransaction::rollback();       
       } 
    }

    public static function onDelete($param)
    {
        $action = new TAction([__CLASS__, 'Delete']);
        $action->setParameters($param);
        new TQuestion('Tem certeza que deseja excluir esse registro?', $action);
    }
    
    public static function Delete($param)
    {
        try
        {
            TTransaction::open('curso');

            $key = $param['key'];

            $cidade = new Cidade;
            $cidade->delete($key);

            $pos_action = new TAction([__CLASS__, 'onReload']);
            new TMessage('info', 'Registro excluído com sucesso!', $pos_action);

            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();   
        }

    }
    
    function show()
    {
        if(!$this->loaded)
        {
            $this->onReload(func_get_arg(0));
        }
        parent::show();
    }
}