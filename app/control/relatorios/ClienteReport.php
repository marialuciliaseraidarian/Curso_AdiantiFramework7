<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TCriteria;
use Adianti\Database\TFilter;
use Adianti\Database\TRepository;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TRadioGroup;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Widget\Wrapper\TDBUniqueSearch;
use Adianti\Wrapper\BootstrapFormBuilder;

class ClienteReport extends TPage
{
  private $form;
  
  public function __construct()
  {
    parent::__construct();

    $this->form = new BootstrapFormBuilder();
    $this->form->setFormTitle('Clientes');

    $nome = new TEntry('nome');
    $cidade_id = new TDBUniqueSearch('cidade_id', 'curso', 'Cidade', 'id', 'nome');
    $categoria_id = new TDBCombo('Categoria_id', 'curso', 'Categoria', 'id', 'nome');
    $output = new TRadioGroup('output');

    $this->form->addFields([new TLabel('Nome')], [$nome]);
    $this->form->addFields([new TLabel('Cidade')], [$cidade_id]);
    $this->form->addFields([new TLabel('Categoria')], [$categoria_id]);
    $this->form->addFields([new TLabel('Formato')], [$output]);

    $output->setUseButton();
    $cidade_id->setMinLength(1);

    $output->addItems(['html' => 'HTML', 'pdf' => 'PDF', 'rtf' => 'RTF', 'xls' => 'XLS']);
    $output->setValue('pdf'); //traz por padrão o pdf selecionado
    $output->setLayout('horizontal'); //define o sentido dos botões se na vertical ou horizontal

    $this->form->addAction('Gerar', new TAction([$this, 'onGenerate']), 'fa:download blue');    

    

    parent::add($this->form);
  }

  public function onGenerate($param)
  {
    try
    {
        TTransaction::open('curso');

        $data = $this->form->getData();

        $repository = new TRepository('Cliente'); //Recebe uma classe (model) como parametro e permite fazer operações em lote       
        $criteria = new TCriteria;

        if($data->nome)
        {
            $criteria->add(new TFilter('nome', 'like', "%{$data->nome}%")); // as aspas do terceiro critério do like tem que ser dupla
        }

        if($data->cidade_id)
        {
            $criteria->add(new TFilter('cidade_id', '=', $data->cidade_id));
        }

        if($data->Categoria_id)
        {
            $criteria->add(new TFilter('Categoria_id', '=', $data->Categoria_id));
        }
       
        $clientes = $repository->load($criteria);

        if($clientes)
        {
            $widths = [40, 200, 80, 120, 80];

            switch ($data->output)
            {
                case 'html':
                    $table = new TTableWriterHTML($widths);
                    break;
                case 'pdf':
                    $table = new TTableWriterPDF($widths);
                    break;
                case 'rtf':
                    $table = new TTableWriterRTF($widths);
                    break;
                case 'xls':
                    $table = new TTableWriterXLS($widths);
                    break;
            }

            if (!empty($table))
            {
                $table->addStyle('header', 'Helvetica', '16', 'B', '#ffffff', '#d49837'); //cabeçalho
                $table->addStyle('title', 'Helvetica', '10', '', '#ffffff', '#d49837'); //título
                $table->addStyle('datap', 'Helvetica', '10', '', '#5c3a02', '#fcf7ed', 'LR'); //linha de dados pares
                $table->addStyle('datai', 'Helvetica', '10', '', '#0a0600', '#fad8a0', 'LR'); //linha de dados ímpares
                $table->addStyle('footer', 'Helvetica', '10', '', '#ffffff', '#d49837'); //rodapé                
            }

            $table->setHeaderCallback( function($table){
                $table->addRow();
                $table->addCell('Clientes', 'center', 'header', 5);

                $table->addRow();
                $table->addCell('Código', 'center', 'title');
                $table->addCell('Nome', 'center', 'title');
                $table->addCell('Cetegoria', 'center', 'title');
                $table->addCell('E-mail', 'center', 'title');
                $table->addCell('Data Nasc.', 'center', 'title');
            });

            $table->setFooterCallback( function($table){
                $table->addRow();
                $table->addCell('Gerado em: ' . date('d/m/Y H:i:s'), 'center', 'footer', 5);
            });

            $colore = false; //var que irá controlar a coloração das linhas

            foreach($clientes as $cliente)
            {
                $style = $colore ? 'datap': 'datai'; //faz a alternação dos estilo entre datap e datai

                $table->addRow(); //adiciona linha na tabela
                $table->addCell($cliente->id, 'left', $style); //adiciona célula na tabela
                $table->addCell($cliente->nome, 'left', $style);
                $table->addCell($cliente->categoria->nome, 'left', $style);
                $table->addCell($cliente->email, 'left', $style);
                $table->addCell($cliente->nascimento, 'center', $style);
                
                $colore = !$colore;
            }

            $output = 'app/output/tabular.' . $data->output;

            if(!file_exists($output) OR is_writable($output))
            {
                $table->save($output);
                parent::openFile($output);
                new TMessage('info', 'Relatório gerado com sucesso!');
            }
            else
            {
                throw new Exception('Permissão negada: ' . $output);
            }            
        }
      
        $this->form->setData($data);
        TTransaction::close();
    }
    catch (Exception $e)
    {
        new TMessage('error', $e->getMessage());
        TTransaction::rollback();
    }
  }
}