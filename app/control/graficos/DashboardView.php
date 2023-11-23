<?php

use Adianti\Control\TPage;
use Adianti\Widget\Base\TElement;
use Adianti\Widget\Template\THtmlRenderer;

class DashboardView extends TPage
{
    public function __construct()
    {
        parent::__construct();

        $div = new TElement('div');
        $div->class = 'row';

        $indicador1 = new THtmlRenderer('app/resources/info-box.html');
        $indicador2 = new THtmlRenderer('app/resources/info-box.html');

        $indicador1->enableSection('main', ['title' => 'Acessos',
                                            'icon' => 'sign-in-alt',
                                            'background' =>'green',
                                            'value' => 100]);
        
        $indicador2->enableSection('main', ['title' => 'Clientes',
                                            'icon' => 'user',
                                            'background' =>'orange',
                                            'value' => 200]);

        $div->add($i1 = TElement::tag('div', $indicador1));
        $div->add($i2 = TElement::tag('div', $indicador2));
        $div->add($g1 = new GraficoBarras);
        $div->add($g2 = new GraficoLinhas);
        $div->add($g3 = new GraficoColunas);
        $div->add($g4 = new GraficoPizza);

        //adiciona classe bootstrap
        $i1->class = 'col-sm-6'; 
        $i2->class = 'col-sm-6'; 
        $g1->class = 'col-sm-6'; 
        $g2->class = 'col-sm-6';
        $g3->class = 'col-sm-6';
        $g4->class = 'col-sm-6';


        parent::add($div);
    }
}