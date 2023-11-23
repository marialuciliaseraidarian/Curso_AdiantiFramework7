<?php

use Adianti\Control\TPage;
use Adianti\Widget\Template\THtmlRenderer;

class GraficoLinhas extends TPage
{
    private $html;

    public function __construct()
    {       
        parent::__construct();

        $this->html =  new THtmlRenderer('app/resources/google_line_chart.html');

        $data = [];
        $data[] = ['Dia', 'Prospects', 'Compras'];
        $data[] = ['01/10', 120, 100];
        $data[] = ['02/10', 97, 57];
        $data[] = ['03/10', 48, 28];
        $data[] = ['04/10', 131, 77];
        $data[] = ['05/10', 53, 33];
        $data[] = ['06/10', 204, 150];

        $this->html->enableSection('main', ['data' => json_encode($data),
                                      'width' => '100%',
                                      'height' => '500px',
                                      'title' => 'Total de vendas por dia - outubro de 2023:',
                                      'xtitle' => 'Dia do Mês',
                                      'ytitle' => 'Vendas',
                                      'uniqid' => 'uniqid()']);

        parent::add($this->html);
    }
}