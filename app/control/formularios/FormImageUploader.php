<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TImageCapture;
use Adianti\Widget\Form\TImageCropper;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class FormImageUploader extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder();
        $this->form->setFormTitle('Captura e corte de imagem');

        $imagecropper = new TImageCropper('imagecropper');
        $imagecapture = new TImageCapture('imagecapture');
        
        $imagecropper->setSize(300, 150); //tam. do campo no formulário
        $imagecropper->setCropSize(100, 100); //tam. do corte da imagem
        $imagecropper->setAllowedExtensions( ['gif', 'png', 'jpg', 'jpeg'] ); //extenções de imagens permitidas

        $imagecapture->setSize(300, 150); 
        $imagecapture->setCropSize(300, 300); 

        $this->form->addFields( [new TLabel('Corte de Imagem')], [$imagecropper] );
        $this->form->addFields( [new TLabel('Captura de Imagem')], [$imagecapture] );

        $this->form->addAction('Enviar', new TAction( [$this, 'onShow'] ), 'fa:check-circle orange');
        
        parent::add($this->form);
    }

    public static function onShow($param)
    {
        new TMessage('info', 'Image cropper: tmp/'. $param['imagecropper'] . '<br>' . 'Image capture: tmp/' . $param['imagecapture']);
    }
}