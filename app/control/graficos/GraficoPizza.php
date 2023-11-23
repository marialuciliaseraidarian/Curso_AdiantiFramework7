<?php

use Adianti\Control\TPage;
use Adianti\Widget\Template\THtmlRenderer;

class GraficoPizza extends TPage
{
    public function __construct()
    {
        parent::__construct();

        $html = new THtmlRenderer('app/resources/google_pie_chart.html');

        $data = [];
        $data[] = ['Pessoa', 'Valor'];
        $data[] = ['Pedro', 127];
        $data[] = ['Maria', 209];
        $data[] = ['João', 97];

        $html->enableSection('main', ['data' => json_encode($data),
                                      'width' => '100%',
                                      'height' => '400px',
                                      'title' => 'Total de vendas por funcionário:',
                                      'uniqid' => 'uniqid()']);

        parent::add($html);
    }
}