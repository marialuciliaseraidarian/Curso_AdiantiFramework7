<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Container\THBox;
use Adianti\Widget\Form\TCheckList;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormularioCheckList extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Check List');

        //form comum
        $id = new TEntry('id');
        $nome = new TEntry('nome');
        //form check list
        $lista = new TCheckList('lista_produtos');
        //coluna, título da coluna, alinhamento, proporção da coluna:
        $lista->addColumn('id', 'ID', 'center', '10%');
        $lista->addColumn('descricao', 'Descrição', 'left', '50%');
        $lista->addColumn('preco_venda', 'preco_venda', 'left', '40%');
        //defina altura da lista
        $lista->setHeight(250);
        $lista->makeScrollable();

        //insere campo de busca
        $input = new TEntry('busca');
        $input->placeholder = 'Busca...';
        $input->setSize('100%');
        //Para habilitar a busca usamos o enableSearch passando como parâmetro o nome do campo de busca e as colunas a serem pesquisadas.
        $lista->enableSearch($input, 'id, descricao');
        //cria uma cx horizontal para inserir o input de busca acima da checklist
        $hbox = new THBox;
        //estiliza a hbox
        $hbox->style = 'border-bottom: 1px solid gray; padding-bottom: 15px';
        $hbox->add(new TLabel('Produtos'));
        $hbox->add($input)->style = 'float:right; width:30%';

        //adiciona campos no form: primeiro o label depois o objeto:
        $this->form->addFields( [new TLabel('Id')], [$id] );
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        $this->form->addContent( [$hbox] );
        $this->form->addFields( [new TLabel('Produtos')], [$lista] );
        
        //para adicionar elementos no checklist usamos o addItems que recebe um vetor de objetos 
        /* TTransaction::open('curso');
        $produto = Produto::all();
        TTransaction::close();
        para não precisarmos fazer essa transação com o banco podemos fazer como abaixo utilizando o método mágico: */
        $lista->addItems(Produto::allInTransaction('curso'));

        //adiciona um botão de ação
        $this->form->addAction('Enviar', new TAction( [$this, 'onSend'] ), 'fa:save');

        //mostra os campos na tela
        parent::add($this->form);
    }

    public function onSend($param)
    {
        //pega dados do form
        $data = $this ->form->getData();
        //mantem o form preenchido após o envio do formulário
        $this->form->setData($data);
        echo '<pre>';
        var_dump($data->id);
        var_dump($data->nome);
        var_dump($data->lista_produtos);
        echo '</pre>';
    }
}