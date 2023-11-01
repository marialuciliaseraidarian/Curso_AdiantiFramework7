<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Registry\TSession;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Datagrid\TPageNavigation;
use Adianti\Widget\Dialog\TToast;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class ProdutoEditList extends TPage
{
    private $form;
    private $datagrid; 
    private $pageNavigation;

    use \Adianti\Base\AdiantiStandardListTrait;

    public function __construct()
    {
        parent::__construct();

        $this->setDatabase('curso');
        $this->setActiveRecord('Produto');
        $this->setDefaultOrder('id', 'asc');
        $this->addFilterField('descricao', 'like', 'descricao');

        //form de pesquisa
        $this->form = new BootstrapFormBuilder('form_busca_produto');
        $this->form->setFormTitle('Produtos');

        $descricao = new TEntry('descricao');
        $this->form->addFields([new TLabel('Descrição:')], [$descricao]);
        $this->form->addAction('Buscar', new TAction([$this, 'onSearch']), 'fa:search #DAA520');

        //mantem dados inseridos pelo usuário na sessão.
        $this->form->setData(TSession::getValue(__CLASS__ . '_filter_data'));

        //datagrid de produtos
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'width:100%';

        $col_id = new TDataGridColumn('id', 'Código', 'center');
        $col_descricao = new TDataGridColumn('descricao', 'Descrição', 'left');
        $col_unidade = new TDataGridColumn('unidade', 'Unidade', 'center');
        $col_estoque = new TDataGridColumn('estoque', 'Estoque', 'center');
        $col_preco = new TDataGridColumn('preco_venda', 'Preço','right' );

        $col_preco->setTransformer( function($preco, $object, $row){
            $widget = new TEntry('preco_venda_' . $object->id);
            $widget->setNumericMask(2, ',', '.', true);
            $widget->setValue($preco);
            $widget->setSize(120);
            $widget->setFormName('form_busca_produto');

            $widget->setExitAction(new TAction([$this, 'onSaveInline'], ['column' => 'preco_venda']));

            return $widget;
        });

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn( $col_descricao);
        $this->datagrid->addColumn($col_unidade);
        $this->datagrid->addColumn($col_estoque);
        $this->datagrid->addColumn($col_preco);

        $this->datagrid->createModel();

        $this->pageNavigation = new TPageNavigation;
        $this->pageNavigation->setAction(new TAction([$this, 'onReload']));

        $panel = new TPanelGroup();        
        $panel->add($this->datagrid);
        $panel->addFooter($this->pageNavigation);

        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add($this->form);
        $vbox->add($panel);

        parent::add($vbox);        
    }

    public static function onSaveInline($param)
    {
        $coluna = $param['column']; //nome da coluna (preco_venda)
        $nome = $param['_field_name']; //novo nome do preco_venda que inserimos acima que é o preco_venda + o id do produto
        $valor = $param['_field_value']; //novo valor inserido pelo usuário

        $partes = explode('_', $nome); //separa o nome do componente em várias partes, tomando como separador os underlines
        $id = end($partes); //pega a última parte da variável norme dividida e atribui à variável id

        try
        {
            TTransaction::open('curso');

            $produto = Produto::find( $id );
            if($produto)
            {
                $produto->$coluna = str_replace( ['.', ','], ['', '.'], $valor);
                $produto->store();
            }

            TTransaction::close();

            TToast::show('success', '<b>' . $produto->descricao . '</b> atualizado com sucesso!', 'bottom center', 'far:check-circle');
        }
        catch (Exception $e)
        {
            TToast::show('error', $e->getMessage(), 'bottom center', 'fa:exclamation-triangle');
        }
    }
}