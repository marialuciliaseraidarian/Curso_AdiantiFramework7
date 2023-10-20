<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class DatagridExporta extends TPage
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
               
        $panel = new TPanelGroup('Datagrid');        
        $panel->add($this->datagrid);

        $panel->addHeaderActionLink('Salvar PDF', new TAction( [ $this, 'exportaPDF' ], ['register_state' => 'false'] ), 'far:file-pdf red' );
        $panel->addHeaderActionLink('Salvar CSV', new TAction( [ $this, 'exportaCSV' ], ['register_state' => 'false'] ), 'fa:table green' );

        parent::add($panel);
    }
    
    public function exportaPDF($param)
    {
        try
        {
            //clona a datagrid para dentro do obj $html
            $html = clone $this->datagrid;
            /* através do obj $html extrai o conteúdo bruto da datagrid
            e acrescenta estilo bootstrap para impressão com o file_get_contents. */
            $conteudo = file_get_contents('app/resources/styles-print.html') . $html->getContents();
            $options = new \Dompdf\Options();
            $options->setChroot(getcwd());
            
            // Converte o modelo HTML em PDF definindo o papel através do setPaper
            $dompdf = new \Dompdf\Dompdf($options); 
            $dompdf->loadHtml($conteudo);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            $file = 'app/output/datagrid-exporta.pdf';
            
            file_put_contents( $file, $dompdf->output() );
            
            //Define que a abertura do pdf será em uma nova janela
            $window = TWindow::create('Exportação', 0.8, 0.8);
             //imprime o pdf em tela
            $object = new TElement('object');
            $object->data = $file;
            $object->type = 'application/pdf';
            $object->style = 'width:100%; height: calc(100% - 10px)';
            
            $window->add($object);
            $window->show();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
    }
    
    public function exportaCSV($param)
    {
        try
        {
            //Extrai dados da datagrid
            $data = $this->datagrid->getOutputData();
            
            //Verifica se retornou dados e o que fazer com os dados retornados
            if ($data)
            {
                //define o arquivo de saída
                $file = 'app/output/datagrid-exporta.csv';
                
                $handler = fopen($file, 'w');
                //percorre os dados
                foreach ($data as $row)
                {
                    //escreve cada linha percorrida para o arquivo de saída csv
                    fputcsv($handler, $row);
                }
                //força o download do arquivo
                fclose($handler);
            
                parent::openFile($file);
            }
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }
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