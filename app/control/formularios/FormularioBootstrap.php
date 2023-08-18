<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TColor;
use Adianti\Widget\Form\TCombo;
use Adianti\Widget\Form\TDate;
use Adianti\Widget\Form\TDateTime;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TPassword;
use Adianti\Widget\Form\TSpinner;
use Adianti\Widget\Form\TText;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioBootstrap extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder;
        $this->form->setFormTitle('Formulário bootstrap');

        $id = new TEntry('id');
        $descricao = new TEntry('descricao');
        $senha = new TPassword('senha');
        $dt_criacao = new TDateTime('dt_criacao');
        $dt_expiracao = new TDate('dt_expiracao');
        $valor = new TEntry('valor');
        $cor = new TColor('cor');
        $peso = new TSpinner('peso');
        $tipo = new TCombo('tipo');
        $texto = new TText('texto');
        
        $id->setEditable(FALSE); //Não permite que o usuário manipule o id
        $cor->setSize('100%');
        $dt_criacao->setMask('dd/mm/yyyy hh:ii');//máscara de data para mostrar ao usuário
        $dt_criacao->setDatabaseMask('yyyy-mm-dd hh:ii'); //modo do envio da data ao banco de dado

        $dt_expiracao->setMask('dd/mm/yyyy'); 
        $dt_expiracao->setDatabaseMask('yyyy-mm-dd');
        
        //máscara para nº (número de casas após a vírgula, separador de centavos, separador de milhar)
        //e o true no final remove as máscara para enviar ao banco de dados.
        $valor->setNumericMask(2, ',', '.', true);
        
        $valor->setSize('100%');
        $dt_criacao->setSize('100%');
        $dt_expiracao->setSize('100%');
        $peso->setSize('100%');
        $tipo->setSize('100%');

         //insere dados no TCombo tipo:
        $tipo->addItems( [ 'a' => 'Opção A', 'b' => 'Opção B', 'c' => 'Opção C'] );

        $this->form->appendPage('Aba 1');
        
        $this->form->addFields( [new TLabel('ID')], [$id] );
        $this->form->addFields( [new TLabel('Descrição')], [$descricao] );
        $this->form->addFields( [new TLabel('Senha')], [$senha] );
        $this->form->addFields( [new TLabel('Data de Criação')], [$dt_criacao], [new TLabel('Data Expiração')], [$dt_expiracao]  );
        $this->form->addFields( [new TLabel('Valor')], [$valor], [new TLabel('Cor')], [$cor] );       
        $this->form->addFields( [new TLabel('Peso')], [$peso], [new TLabel('Tipo')], [$tipo] );        

        $this->form->appendPage('Aba 2');        
        //insere uma divisória
        $label = new TLabel('Preencha o formulário:', '#8B008B', 12, 'bi');
        //título da divisória, cor do título, tam do título, bi = bold e itálico
        $label->style = 'text-align: left; border-bottom: 1px solid #8B008B; width 100%';
        $this->form->addContent( [$label] );//insere a divisória no form        
        $this->form->addFields( [new TLabel('Texto')], [$texto] );

       //insere botão de enviar
        $this->form->addAction('Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');
        //o addAction insere o botão embaixo, e o addHeaderAction insere o botão em cima.
        
        //traz dados já preenchidos ao form:
        $dt_criacao->setValue( date('Y-m-d H:i') );

        //define o range para o peso (iniciará no 1, até 100, e vai pular de 0.1 a cada clique)
        $peso->setRange(1, 100, 0.1);

        //insere um placeholder:
        $texto->placeholder = "Observações";

        //insere um tip:
        $texto->setTip('Insira aqui suas observações');

        parent::add( $this->form );
    }

    public function onSend($param)//cria uma ação para o botão enviar
    {
        $data = $this->form->getData();
        $this->form->setData($data);

        new TMessage('info', 'Dados salvos com sucesso!');
    }
}