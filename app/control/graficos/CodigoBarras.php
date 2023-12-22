<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Control\TWindow;
use Adianti\Database\TTransaction;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TText;
use Adianti\Wrapper\BootstrapFormBuilder;

class CodigoBarras extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Código de Barras');

        $metodo = new TCombo('metodo'); //opções de tipos de códigos de barras para o usuário escolher
        $template = new TText('template'); //mostra o template podendo ser mudado pelo usuário, filtros relativos ao produto em si

       $metodo->addItems(['C39' => 'C39', 'C39+' => 'C39+', 'C39E' => 'C39E', 'C39E+' => 'C39E+', 'C93' => 'C93', 'S25' => 'S25', 'S25+' => 'S25+', 'I25' => 'I25', 'I25+' => 'I25+', 'C128' => 'C128', 'C128A' => 'C128A', 'C128B' => 'C128B', 'C128C' => 'C128C', 'EAN2' => 'EAN2', 'EAN5' => 'EAN5', 'EAN8' => 'EAN8', 'EAN13' => 'EAN13', 'UPCA' => 'UPCA', 'UPCE' => 'UPCE', 'MSI' => 'MSI', 'MSI+' => 'MSI+', 'POSTNET' => 'POSTNET', 'PLANET' => 'PLANET', 'RMS4CC' => 'RMS4CC','KIX' => 'KIX', 'IMB' => 'IMB', 'CODABAR' => 'CODABAR', 'CODE11' => 'CODE11', 'PHARMA' => 'PHARMA', 'PHARMA2T' => 'PHARMA2T']);

        $this->form->addFields([new TLabel('Método')], [$metodo]);
        $this->form->addFields([new TLabel('Template')], [$template]);

        $template->setSize('100%', 100); //configura cx do template de 100% largura por 100px de altura
        
        //define padrão de template da etiqueta
        $modelo = "\n";
        $modelo .= '<b> Código </b> {id}'. "\n";
        $modelo .= '<b> Descrição </b> {descricao}'. "\n";
        $modelo .= "#barcode#" . "\n";
        $modelo .= '{barcode}';

        $template->setValue($modelo);
        $metodo->setValue('EAN13');

        $this->form->addAction('Gerar', new TAction([$this, 'onGenerate']), 'far:check-circle green');

        parent::add($this->form);
    }

    public function onGenerate($param)
    {
        try
        {
            $data = $this->form->getData();
            $this->form->setData($data);

            //cria vetor com as propriedades de impressão para as etiquetas:
            $properties['barcodeMethod'] = $data->metodo; //método de geração inserido pelo usuário
            $properties['leftMargin'] = 12; //margem esquerda da etiqueta
            $properties['topMargin'] = 12; //margem do topo
            $properties['labelWidth'] = 64; //largura
            $properties['labelHeight'] = 54; //altura
            $properties['spaceBetween'] = 4; //espaçamento entre as etiquetas
            $properties['rowsPerPage'] = 5; //qtd de linha por pág
            $properties['colsPerPage'] = 3; //qtd de colunas por pág
            $properties['fontSize'] = 9; //tamanho da fonte
            $properties['barcodeHeight'] = 15; // altura do cod de barras
            $properties['imageMargin'] = 0; //margem da imagem do cod de barras
            

            $generator = new AdiantiBarcodeDocumentGenerator();
            $generator->setProperties($properties); //insere os padrões escolhidos no vetor acima
            $generator->setLabelTemplate($data->template);//modelo de geração das etiquetas, neste caso pega o escolhido pelo usuário no input

            TTransaction::open('curso');
            $produtos = Produto::all();

            foreach($produtos as $produto)
            {
                $produto->barcode = str_pad($produto->id, 10, '0', STR_PAD_LEFT);
                $produto->descricao = substr($produto->descricao,0,20);
                $generator->addObject($produto);
            }

            $generator->setBarcodeContent('barcode');//insere a definição do barcode que inserimos acima para ser impresso na geração
            $generator->generate(); //gera em memória
            $generator->save('app/output/barcodes.pdf'); //salva em memória no caminho indicado

            //mostra em tela as etiquetas geradas
            $window = TWindow::create('Códigos de Barra', 0.8, 0.8);
            $object = new TElement('object');
            $object->data = 'app/output/barcodes.pdf';
            $object->type = 'application/pdf';
            $object->style = "width: 100%; height:calc(100% - 10px)";
            $window->add($object);
            $window->show();

            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getMessage());
        }

    }
}