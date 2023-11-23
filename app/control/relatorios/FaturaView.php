<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Template\THtmlRenderer;

class FaturaView extends TPage
{
    private $html;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->html = new THtmlRenderer('app/resources/fatura.html');
        
        $fatura = new stdClass;
        $fatura->id = '13123123';
        $fatura->dt_pedido = date('Y-m-d');
        $fatura->metodo = 'Paypal';
        $fatura->conta = 'john@email.com';
        $fatura->frete = 25;
        
        $cliente = new stdClass;
        $cliente->nome = 'Pedro da silva';
        $cliente->endereco = 'Rua do pedrinho, 123';
        $cliente->complemento = 'Apto 123';
        $cliente->cidade = 'Porto Alegre';
        
        $entrega = new stdClass;
        $entrega->nome = 'Jane da silva';
        $entrega->endereco = 'Rua do pedrinho, 123';
        $entrega->complemento = 'Apto 123';
        $entrega->cidade = 'Porto Alegre';
        
        $replaces = [];
        $replaces['fatura'] = $fatura;
        $replaces['cliente'] = $cliente;
        $replaces['entrega'] = $entrega;
        
        $replaces['items'] = [
            [ 'id' => '001',
              'descricao' => 'Chocolate',
              'preco' => 10,
              'qtde' => 2
            ],
            [ 'id' => '002',
              'descricao' => 'Café',
              'preco' => 5,
              'qtde' => 4
            ],
            [ 'id' => '003',
              'descricao' => 'Água',
              'preco' => 2,
              'qtde' => 10
            ]
        ];
        
        $this->html->enableSection('main', $replaces);

        $panel = new TPanelGroup('Fatura');
        $panel->add($this->html);
        
        $panel->addHeaderActionLink('Exportar', new TAction([$this, 'onExportPDF'], ['static'=>'1']), 'fa:save');
        
        parent::add($panel);
    }
    
    public function onExportPDF($param)
    {
        try
        {
            // String com conteúdo HTML.
            $html = clone $this->html;
            $contents = file_get_contents('app/resources/styles-print.html') . $html->getContents();

            $options = new \Dompdf\Options();
            $options->setChroot(getcwd());

            // Converte o modelo HTML em PDF.
            $dompdf = new \Dompdf\Dompdf($options);
            $dompdf->loadHtml($contents);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            
            $file = 'app/output/fatura.pdf';
            
            // Escreve e abre o arquivo.
            file_put_contents($file, $dompdf->output());
            
            //Abre o arquivo pdf em uma nova janela
            $window = TWindow::create('fatura', 0.8, 0.8);
            $object = new TElement('object');
            $object->data  = $file;
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
}
