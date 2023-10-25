<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Registry\TSession;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Util\TDropDown;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class ClienteList extends TPage
{
    private $datagrid;
    private $pageNavigation;

    use \Adianti\Base\AdiantiStandardListTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setDatabase('curso');
        $this->setActiveRecord('Cliente');        
        $this->setDefaultOrder('id', 'asc');
        $this->addFilterField('id', '=', 'id');
        $this->addFilterField('nome', 'like', 'nome');
        $this->addFilterField('endereco', 'like', 'endereco');        
        $this->addFilterField('genero', '=', 'genero');
        $this->addFilterField('(SELECT nome FROM cidade WHERE cidade.id = cidade_id)', 'like', 'cidade');
        $this->setOrderCommand('cidade->nome', '(SELECT nome FROM cidade WHERE cidade_id = cidade.id)');

        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width: 100%';

        $col_id = new TDataGridColumn('id', 'ID', 'left', '10%');
        $col_nome = new TDataGridColumn('nome', 'Nome', 'left', '30%');
        $col_endereco = new TDataGridColumn('endereco', 'Endereço', 'left', '30%');
        $col_cidade = new TDataGridColumn('{cidade->nome} - {cidade->estado->nome}', 'Cidade', 'left', '15%');
        $col_genero = new TDataGridColumn('genero', 'Gênero', 'left', '15%');

        $col_id->setAction(new TAction([$this, 'onReload']), ['order' => 'id']);
        $col_nome->setAction(new TAction([$this, 'onReload']), ['order' => 'nome']);
        $col_endereco->setAction(new TAction([$this, 'onReload']), ['order' => 'endereco']);
        $col_cidade->setAction(new TAction([$this, 'onReload']), ['order' => 'cidade->nome']);
        $col_genero->setAction(new TAction([$this, 'onReload']), ['order' => 'genero']);

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn( $col_nome);
        $this->datagrid->addColumn($col_endereco);
        $this->datagrid->addColumn($col_cidade);
        $this->datagrid->addColumn($col_genero);

        $col_genero->setTransformer(function($genero){return $genero == 'F' ? 'Feminino' : 'Masculino';});

        $actionEdit = new TDataGridAction(['ClienteForm', 'onEdit'], ['key' => '{id}', 'register_state' => 'false']);
        $actionDelete = new TDataGridAction([$this, 'onDelete'], ['key' => '{id}']);

        $this->datagrid->addAction($actionEdit, 'Editar', 'fa:edit blue');
        $this->datagrid->addAction($actionDelete, 'Excluir', 'fa:trash-alt red');

        $this->datagrid->createModel();

        $this->form = new TForm();
        $this->form->add($this->datagrid);

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $endereco = new TEntry('endereco');
        $cidade = new TEntry('cidade');
        $genero = new TCombo('genero');

        $genero->addItems(['M' => 'Masculino', 'F' => 'Feminino']);
        
        $id->exitOnEnter();
        $nome->exitOnEnter();
        $endereco->exitOnEnter();
        $cidade->exitOnEnter();

        $id->tabindex = -1;
        $nome->tabindex = -1;
        $endereco->tabindex = -1;
        $cidade->tabindex = -1;
        $genero->tabindex = -1;

        $id->setExitAction(new TAction([$this, 'onSearch'], ['static' => '1']));
        $nome->setExitAction(new TAction([$this, 'onSearch'], ['static' => '1']));
        $endereco->setExitAction(new TAction([$this, 'onSearch'], ['static' => '1']));
        $cidade->setExitAction(new TAction([$this, 'onSearch'], ['static' => '1']));
        $genero->setChangeAction(new TAction([$this, 'onSearch'], ['static' => '1']));

        //cria uma linha na datagrid
        $tr = new TElement('tr');
        //adiciona a linha no início da datagrid
        $this->datagrid->prependRow($tr);
        //adiciona conteúdo à linha criada de acordo com as colunas existentes.
        $tr->add(TElement::tag('td', ''));
        $tr->add(TElement::tag('td', ''));
        $tr->add(TElement::tag('td', $id));
        $tr->add(TElement::tag('td', $nome));
        $tr->add(TElement::tag('td', $endereco));
        $tr->add(TElement::tag('td', $cidade));
        $tr->add(TElement::tag('td', $genero));

        $this->form->addField($id);
        $this->form->addField($nome);
        $this->form->addField($endereco);
        $this->form->addField($cidade);
        $this->form->addField($genero);

        //armazena os dados inserido pelo usuário na sessão para que fique gravado no form
        $this->form->setData(TSession::getValue(__CLASS__.'_filter_data'));

        $dropdown = new TDropDown('Exportar', 'fa:list orange');
        $dropdown->setButtonClass('btn btn-default waves-effect dropdown-toggle');
        $dropdown->addAction('Salvar como CSV', new TAction([$this, 'onExportCSV'], ['register_state' => 'false', 'static' => '1']), 'fa:table fa-fw blue');
        $dropdown->addAction('Salvar como PDF', new TAction([$this, 'onExportPDF'], ['register_state' => 'false', 'static' => '1']), 'far:file-pdf fa-fw red');
        $dropdown->addAction('Salvar como XML', new TAction([$this, 'onExportXML'], ['register_state' => 'false', 'static' => '1']), 'fa:code fa-fw green');

        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));
        $this->pageNavigation->enableCounters(); 
        
        $panel = new TPanelGroup('Clientes');
        $panel->add($this->form);        
        $panel->addFooter($this->pageNavigation);
        $panel->addHeaderWidget($dropdown);
        $panel->addHeaderActionLink('Novo', new TAction(['ClienteForm', 'onClear'], ['register_state' => 'false']), 'fa:plus green');

        parent::add($panel);        
    }
}