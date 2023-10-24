<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Validator\TRequiredValidator;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Wrapper\BootstrapFormBuilder;

class CidadeForm extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Cidade');
        $this->form->setClientValidation(true); //liga validações do navegador

        $id = new TEntry('id');
        $nome = new TEntry('nome');
        $estado = new TDBCombo('estado_id', 'curso', 'Estado', 'id', 'nome');
        $id->setEditable(FALSE); //não permiti a edição do id.

        $this->form->addFields( [new TLabel('Id', 'red')], [$id] );
        $this->form->addFields( [new TLabel('Nome')], [$nome] );
        $this->form->addFields( [new TLabel('Estado')], [$estado] );

        //validações
        $nome->addValidation('Nome', new TRequiredValidator);
        $estado->addValidation('Estado', new TRequiredValidator);

        //botão de salvar
        $this->form->addAction('Salvar', new TAction( [$this, 'onSave'] ), 'fa:save green');
        $this->form->addActionLink('Limpar Formulário', new TAction( [$this, 'onClear'] ), 'fa:eraser red');

        parent::add($this->form);
    }

    public function onClear()
    {
        $this->form->clear(true); 
    }

    public function onSave($param)
    {
        try
        {
            TTransaction::open('curso');

            $this->form->validate(); //valida se todos os campos do form estão preenchidos
            //pega os dados preenchidos pelo usuário e armazena na variável $data que é um objeto
            $data = $this->form->getData();
            //alimentar um registro novo de cidade com os dados recebido no $data:
            $cidade = new Cidade;
            //transforma o objeto $data em array para usar o método fromArray para carregar os dados a partir de um vetor
            $cidade->fromArray( (array) $data);
            //armazena na base de dados
            $cidade->store();
            //trás o id criado para a tela, isso é importante para evitar duplicidade de registro
            $this->form->setData($cidade);
            //criar mensagem de salvação de registro            
            new TMessage('info', 'Registro salvo com sucesso!');

            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getCode());
            TTransaction::rollback(); //fecha a transação com o banco após a mensagem de erro            
        }
    }

    public function onEdit($param)
    {
        try
        {
            TTransaction::open('curso');
            //verifica se está vindo na url o id, se tiver é uma edição, senão é um registro novo
            if(isset($param['key']))
            {
                $key = $param['key'];
                $cidade = new Cidade($key);
                $this->form->setData($cidade);
            }
            else
            {
              $this->form->clear(true);  
            }
            TTransaction::close();
        }
        catch (Exception $e)
        {
            new TMessage('error', $e->getCode());
            TTransaction::rollback();            
        }
    }
}