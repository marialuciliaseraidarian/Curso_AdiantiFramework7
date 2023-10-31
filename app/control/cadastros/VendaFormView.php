<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Core\AdiantiCoreApplication;
use Adianti\Database\TTransaction;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Base\TScript;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Util\TTextDisplay;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Wrapper\BootstrapFormBuilder;

class VendaFormView extends TPage
{
    private $form;
    
    public function __construct($param)
    {
        parent::__construct();
        
        parent::setTargetContainer('adianti_right_panel');
        
        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Venda');
        
        $this->form->setColumnClasses( 2, ['col-sm-2', 'col-sm-10'] );
        
        $this->form->addHeaderActionLink('Imprimir', new TAction([$this, 'onPrint'], ['key'=>$param['key'], 'static' => '1', 'register_state' => 'false']), 'far:file-pdf red'); 
        $this->form->addHeaderActionLink('Editar', new TAction([$this, 'onEdit'], ['key'=>$param['key'], 'register_state' => 'false']), 'far:edit blue'); 
        $this->form->addHeaderActionLink('Fechar', new TAction([$this, 'onClose']), 'fa:times red');
        parent::add($this->form);
    }
    
    public function onView($param)
    {
        try
        {
            TTransaction::open('curso');
            
            $venda = new Venda( $param['key'] );
            
            $this->form->addFields( [ new TLabel('<b>Código:</b>')], [ new TTextDisplay( $venda->id, '#696969', '14px') ],
                                    [ new TLabel('<b>Cliente:</b>')], [ new TTextDisplay( $venda->cliente->nome, '#696969', '14px') ] );
            $this->form->addFields( [ new TLabel('<b>Data:</b>')], [ new TTextDisplay( $venda->dt_venda, '#696969', '14px') ], 
                                    [ new TLabel('<b>Total:</b>')], [ new TTextDisplay( $venda->total, '#696969', '14px') ] );           
            $this->form->addFields( [ new TLabel('<b>Obs:</b>')], [ new TTextDisplay( $venda->obs, '#696969', '14px') ] );
            
            $list = new BootstrapDatagridWrapper( new TDataGrid);
            $list->style = 'width:100%';
            
            $col_produto  = new TDataGridColumn('produto->descricao', 'Produto', 'left');
            $col_preco    = new TDataGridColumn('preco_venda', 'Preço', 'left');
            $col_qtde     = new TDataGridColumn('quantidade', 'Quantidade', 'center');
            $col_desconto = new TDataGridColumn('desconto', 'Desconto', 'left');
            $col_total    = new TDataGridColumn('total', 'Total', 'right');
            
            $list->addColumn( $col_produto );
            $list->addColumn( $col_preco );
            $list->addColumn( $col_qtde );
            $list->addColumn( $col_desconto );
            $list->addColumn( $col_total );
            
            $format = function($valor) {
                if (is_numeric($valor)) {
                    return 'R$ '. number_format($valor, 2, ',', '.');
                }
                return $valor;
            };
            
            $col_preco->setTransformer( $format );
            $col_desconto->setTransformer( $format );
            $col_total->setTransformer( $format );
            
            $col_total->setTotalFunction( function($valores) {
                return array_sum( (array) $valores);
            });

            $list->createModel();            
            
            $itens = VendaItem::where('venda_id', '=', $venda->id)->load();
            
            $list->addItems($itens);
            
            $panel = new TPanelGroup('Itens');
            $panel->add($list);
            
            $this->form->addContent( [$panel] );
            
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    
    public function onPrint($param)
    {
        try
        {
            $this->onView($param);
            
            // string with HTML contents
            $html = clone $this->form;
            $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();
            
            // converts the HTML template into PDF
            $dompdf = new \Dompdf\Dompdf();
            $dompdf->loadHtml($contents);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            $file = 'app/output/venda.pdf';
            
            // write and open file
            file_put_contents($file, $dompdf->output());
            
            $window = TWindow::create('Export', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $file.'?rndval='.uniqid();
            $object->type  = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    public static function onEdit($param)
    {
        unset($param['static']);
        AdiantiCoreApplication::loadPage('VendaForm', 'onEdit', $param);
    }
    
    public static function onClose($param)
    {
        TScript::create('Template.closeRightPanel()');
    }
}