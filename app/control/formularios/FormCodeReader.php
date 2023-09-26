<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TBarCodeInputReader;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Form\TQRCodeInputReader;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormCodeReader extends TPage
{    
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Leitura de barcode e qrcode');

        $barcode = new TBarCodeInputReader('barcode'); 
        $qrcode = new TQRCodeInputReader('qrcode');

        $barcode->setSize('100%');
        $qrcode->setSize('100%');

        $barcode->setChangeAction( new TAction( [$this, 'onChange']) );

        //cria ação de visualizar após a leitura do barcode:
        $this->form->addFields( [new TLabel('Barcode')], [$barcode] );
        $this->form->addFields( [new TLabel('QRcode')], [$qrcode] );
        
        //cria a ação de enviar dados:
        $this->form->addAction('Enviar', new TAction( [$this, 'onSend']), 'far:check-circle blue');

        parent::add($this->form);
    }

    public static function onChange($param)
    {
        new TMessage('info', str_replace(',', '<br>', json_encode($param)));
    } 

    public function onSend($param)
    {
        $data = $this->form->getData();
        $this->form->setData($data);

        new TMessage('info', 'Barcode: ' . $data->barcode . '<br>QRCode: ' . $data->qrcode);
    }
}