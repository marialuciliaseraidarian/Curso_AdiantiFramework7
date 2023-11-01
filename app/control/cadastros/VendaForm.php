<?php

use Adianti\Control\TWindow;
use Adianti\Control\TAction;
use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Dialog\TToast;
use Adianti\Widget\Form\TButton;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TForm;
use Adianti\Widget\Form\THidden;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TText;
use Adianti\Widget\Wrapper\TDBUniqueSearch;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class VendaForm extends TWindow
{
    protected $form;     
    
    function __construct()
    {
        parent::__construct();
        parent::setSize(0.8, null);
        parent::removePadding();
        parent::removeTitleBar();
        parent::disableEscape();
                
        $this->form = new BootstrapFormBuilder('form_Venda');
        $this->form->setFormTitle('Venda');
        $this->form->setProperty('style', 'margin:0;border:0');
                
        $id          = new TEntry('id');
        $dt_venda    = new TDate('dt_venda');
        $cliente_id  = new TDBUniqueSearch('cliente_id', 'curso', 'Cliente', 'id', 'nome');
        $obs         = new TText('obs');
        
        // detalhes - cadastro produto
        $produto_detail_unqid       = new THidden('produto_detail_uniqid');
        $produto_detail_id          = new THidden('produto_detail_id');
        $produto_detail_produto_id  = new TDBUniqueSearch('produto_detail_produto_id', 'curso', 'Produto', 'id', 'descricao');
        $produto_detail_preco_venda = new TEntry('produto_detail_preco_venda');
        $produto_detail_quantidade  = new TEntry('produto_detail_quantidade');
        $produto_detail_desconto    = new TEntry('produto_detail_desconto');       
        
        // ajustar propriedades dos campos
        $id->setEditable(false);
        $cliente_id->setSize('100%');
        $cliente_id->setMinLength(1);
        $dt_venda->setSize('100%');
        $obs->setSize('100%', 80);
        $dt_venda->setMask('dd/mm/yyyy');
        $dt_venda->setDatabaseMask('yyyy-mm-dd');
        $produto_detail_produto_id->setSize('100%');
        $produto_detail_produto_id->setMinLength(1);
        $produto_detail_preco_venda->setSize('100%');
        $produto_detail_quantidade->setSize('100%');
        $produto_detail_desconto->setSize('100%');        
        
        // validações
        $dt_venda->addValidation('Date', new TRequiredValidator);
        $cliente_id->addValidation('Cliente', new TRequiredValidator);
        
        // change action
        $produto_detail_produto_id->setChangeAction(new TAction([$this,'onProdutoChange']));
        
        // Adiciona campos do form mestre
        $this->form->addFields( [new TLabel('ID')], [$id], 
                                [new TLabel('Data', '#FF0000')], [$dt_venda] );
        $this->form->addFields( [new TLabel('Cliente', '#FF0000')], [$cliente_id ] );
        $this->form->addFields( [new TLabel('Obs')], [$obs] );
        
        $this->form->addContent( ['<h4>Detalhes</h4><hr>'] );
        $this->form->addFields( [ $produto_detail_unqid], [$produto_detail_id] );
        $this->form->addFields( [ new TLabel('Produto', '#FF0000') ], [$produto_detail_produto_id],
                                [ new TLabel('Quantidade', '#FF0000') ], [$produto_detail_quantidade] );
        $this->form->addFields( [ new TLabel('Preço', '#FF0000') ], [$produto_detail_preco_venda],
                                [ new TLabel('Disconto')], [$produto_detail_desconto] );
        
        $add_product = TButton::create('add_product', [$this, 'onProdutoAdd'], 'Register', 'fa:plus-circle green');
        $add_product->getAction()->setParameter('static','1');
        $this->form->addFields( [], [$add_product] );
        
        //datagrid de produtos
        $this->produto_list = new BootstrapDatagridWrapper(new TDataGrid);
        $this->produto_list->setHeight(150);
        $this->produto_list->makeScrollable();
        $this->produto_list->setId('products_list');
        $this->produto_list->generateHiddenFields();
        $this->produto_list->style = "min-width: 700px; width:100%;margin-bottom: 10px";
        
        //cria colunas
        $col_uniq   = new TDataGridColumn( 'uniqid', 'Uniqid', 'center', '10%');
        $col_id     = new TDataGridColumn( 'id', 'ID', 'center', '10%');
        $col_pid    = new TDataGridColumn( 'produto_id', 'Código', 'left', '10%');
        $col_descr  = new TDataGridColumn( 'produto_id', 'Produto', 'left', '35%');
        $col_quantidade = new TDataGridColumn( 'quantidade', 'Qtd', 'left', '10%');
        $col_preco_venda  = new TDataGridColumn( 'preco_venda', 'Preço', 'left', '15%');
        $col_disc   = new TDataGridColumn( 'desconto', 'Desconto', 'left', '15%');
        $col_subt   = new TDataGridColumn( '={quantidade} * ( {preco_venda} - {desconto} )', 'Subtotal', 'right', '15%');
        
        //Adiciona colunas na datagrid
        $this->produto_list->addColumn( $col_uniq );
        $this->produto_list->addColumn( $col_id );
        $this->produto_list->addColumn( $col_pid );
        $this->produto_list->addColumn( $col_descr );
        $this->produto_list->addColumn( $col_quantidade );
        $this->produto_list->addColumn( $col_preco_venda );
        $this->produto_list->addColumn( $col_disc );
        $this->produto_list->addColumn( $col_subt );
      
        $col_descr->setTransformer(function($value) {
            return Produto::findInTransaction('curso', $value)->descricao;
        });

        //soma o total da coluna col_subt da datagrid
        $col_subt->enableTotal('sum', 'R$ ', 2, ',', '.');

        //executa uma ação em cima do total calculado acima
        $this->produto_list->setMutationAction(new TAction([$this, 'onMutationAction']));
        
        //tira a visibilidade das colunas
        $col_id->setVisibility(false);
        $col_uniq->setVisibility(false);
        
        // cria duas ações de datagrid
        $action_edit = new TDataGridAction([$this, 'onEditItemProduto'] );
        $action_edit->setFields( ['uniqid', '*'] );
        
        $action_delete = new TDataGridAction([$this, 'onDeleteItem']);
        $action_delete->setField('uniqid');
        
        // adicione as ações ao datagrid
        $this->produto_list->addAction($action_edit, _t('Edit'), 'fa:edit blue');
        $this->produto_list->addAction($action_delete, _t('Delete'), 'fas:trash-alt red');
        
        $this->produto_list->createModel();
        
        $panel = new TPanelGroup;
        $panel->add($this->produto_list);
        $panel->getBody()->style = 'overflow-x:auto';
        $this->form->addContent( [$panel] );
        
        $format_value = function($value) {
            if (is_numeric($value)) {
                return 'R$ '.number_format($value, 2, ',', '.');
            }
            return $value;
        };
        
        $col_preco_venda->setTransformer( $format_value );
        $col_disc->setTransformer( $format_value );
        $col_subt->setTransformer( $format_value );
        
        $this->form->addHeaderActionLink( _t('Close'),  new TAction([__CLASS__, 'onClose'], ['static'=>'1']), 'fa:times red');
        $this->form->addAction( 'Salvar',  new TAction([$this, 'onSave'], ['static'=>'1']), 'fa:save green');
        $this->form->addAction( 'Limpar', new TAction([$this, 'onClear']), 'fa:eraser red');
        
        // crie o contêiner da página
        $container = new TVBox;
        $container->style = 'width: 100%';
        //$container->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $container->add($this->form);
        parent::add($container);
    }
    
    public function onLoad($param)
    {
        $data = new stdClass;
        $data->cliente_id   = $param['cliente_id'];
        $this->form->setData($data);
    }
            
    public static function onProdutoChange( $params )
    {
        if( !empty($params['produto_detail_produto_id']) )
        {
            try
            {
                TTransaction::open('curso');
                $product = new Produto($params['produto_detail_produto_id']);                              
                TForm::sendData('form_Venda', (object) ['produto_detail_preco_venda' => $product->preco_venda]);
                TTransaction::close();
            }
            catch (Exception $e)
            {
                new TMessage('error', $e->getMessage());
                TTransaction::rollback();
            }
        }
    }
           
    function onClear($param)
    {
        $this->form->clear();
    }
        
    public function onProdutoAdd( $param )
    {
        try
        {
            $this->form->validate();
            $data = $this->form->getData();
            
            if( (! $data->produto_detail_produto_id) || (! $data->produto_detail_quantidade) || (! $data->produto_detail_preco_venda) )
            {
                throw new Exception('The fields Produto, Amount and Price are required');
            }
            
            $uniqid = !empty($data->produto_detail_uniqid) ? $data->produto_detail_uniqid : uniqid();
            
            $grid_data = ['uniqid'       => $uniqid,
                          'id'           => $data->produto_detail_id,
                          'produto_id'   => $data->produto_detail_produto_id,
                          'quantidade'   => $data->produto_detail_quantidade,
                          'preco_venda'  => $data->produto_detail_preco_venda,
                          'desconto'     => $data->produto_detail_desconto];
             
            // insert row dynamically
            $row = $this->produto_list->addItem( (object) $grid_data );
            $row->id = $uniqid;
            
            TDataGrid::replaceRowById('products_list', $uniqid, $row);
            
            // clear product form fields after add
            $data->produto_detail_uniqid      = '';
            $data->produto_detail_id          = '';
            $data->produto_detail_produto_id  = '';
            $data->produto_detail_nome        = '';
            $data->produto_detail_quantidade  = '';
            $data->produto_detail_preco_venda = '';
            $data->produto_detail_desconto    = '';
            
            // send data, do not fire change/exit events
            TForm::sendData( 'form_Venda', $data, false, false );
        }
        catch (Exception $e)
        {
            $this->form->setData( $this->form->getData());
            new TMessage('error', $e->getMessage());
        }
    }
        
    public static function onEditItemProduto( $param )
    {
        $data = new stdClass;
        $data->produto_detail_uniqid      = $param['uniqid'];
        $data->produto_detail_id          = $param['id'];
        $data->produto_detail_produto_id  = $param['produto_id'];
        $data->produto_detail_quantidade  = $param['quantidade'];
        $data->produto_detail_preco_venda = $param['preco_venda'];
        $data->produto_detail_desconto    = $param['desconto'];
        
        // send data, do not fire change/exit events
        TForm::sendData( 'form_Venda', $data, false, false );
    }
        
    public static function onDeleteItem( $param )
    {
        $data = new stdClass;
        $data->produto_detail_uniqid      = '';
        $data->produto_detail_id          = '';
        $data->produto_detail_produto_id  = '';
        $data->produto_detail_quantidade  = '';
        $data->produto_detail_preco_venda = '';
        $data->produto_detail_desconto   = '';
        
        // send data, do not fire change/exit events
        TForm::sendData( 'form_Venda', $data, false, false );
        
        // remove row
        TDataGrid::removeRowById('products_list', $param['uniqid']);
    }
        
    public function onSave($param)
    {
        try
        {
            TTransaction::open('curso');
            
            $data = $this->form->getData();
            $this->form->validate();
            
            $sale = new Venda;
            $sale->fromArray((array) $data);
            $sale->store();
            
            VendaItem::where('venda_id', '=', $sale->id)->delete();
            
            if( $param['products_list_produto_id'] )
            {
                $total = 0;
                foreach( $param['products_list_produto_id'] as $key => $item_id )
                {
                    $item = new VendaItem;
                    $item->produto_id  = $item_id;
                    $item->preco_venda = (float) $param['products_list_preco_venda'][$key];
                    $item->quantidade  = (float) $param['products_list_quantidade'][$key];
                    $item->desconto    = (float) $param['products_list_desconto'][$key];
                    $item->total       = ( $item->preco_venda * $item->quantidade ) - $item->desconto;
                    
                    $item->venda_id = $sale->id;
                    $item->store();
                    $total += $item->total;
                }
            }
            $sale->total = $total;
            $sale->store(); // stores the object
            
            TForm::sendData('form_Venda', (object) ['id' => $sale->id]);
            
            TTransaction::close(); // close the transaction
            new TMessage('info', TAdiantiCoreTranslator::translate('Record saved'));            
        }
        catch (Exception $e) // in case of exception
        {
            new TMessage('error', $e->getMessage());
            $this->form->setData( $this->form->getData() ); // keep form data
            TTransaction::rollback();
        }
    }
      
    public function onEdit($param)
    {
        try
        {
            TTransaction::open('curso');
            
            if (isset($param['key']))
            {
                $key = $param['key'];
                
                $object = new Venda($key);
                $venda_items = VendaItem::where('venda_id', '=', $object->id)->load();
                
                foreach( $venda_items as $item )
                {
                    $item->uniqid = uniqid();
                    $row = $this->produto_list->addItem( $item );
                    $row->id = $item->uniqid;
                }
                $this->form->setData($object);
                TTransaction::close();
            }
            else
            {
                $this->form->clear();
            }
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    public static function onMutationAction($param)
    {
        $total = 0;
        if($param['list_data'])
        {
            foreach ($param['list_data'] as $row)
            {
               $total += (floatval($row['preco_venda']) - floatval($row['desconto'])) * floatval($row['quantidade']);
            }
        }
        TToast::show('info', 'Total da venda: R$ ' . number_format($total, 2, ',', '.'), 'bottom right');
    }
        
    public static function onClose()
    {
        parent::closeWindow();
    }
}
