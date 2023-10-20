<?php

use Adianti\Control\TPage;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Util\TImage;
use Adianti\Wrapper\BootstrapDatagridWrapper;

class DatagridImagem extends TPage
{
    private $datagrid;

    public function __construct()
     {
        parent::__construct();

        $this->datagrid = new BootstrapDatagridWrapper( new TDataGrid);
        $this->datagrid->width = '100%';

        $col_id        = new TDataGridColumn('id', 'Código', 'center', '10%');
        $col_produto   = new TDataGridColumn('produto', 'Produto', 'left', '20%');
        $col_descricao = new TDataGridColumn('descricao', 'Descrição', 'left', '40%');
        $col_preco    = new TDataGridColumn('preco', 'Preço', 'center', '10%');
        $col_imagem    = new TDataGridColumn('imagem', 'Imagem', 'center', '20%');

        $col_preco->setTransformer( function($valor, $objeto, $row){
            if (is_numeric($valor))
            {
               return 'R$ ' . number_format($valor, 2, ',', '.');
            }
        });

        $col_imagem->setTransformer( function($imagem, $object, $row){
            $obj = new TImage( $imagem );
            $obj->style = 'max-width: 120px';
            return $obj;
        });

        $this->datagrid->addColumn($col_id);
        $this->datagrid->addColumn($col_produto);
        $this->datagrid->addColumn($col_descricao);
        $this->datagrid->addColumn($col_preco);
        $this->datagrid->addColumn($col_imagem);

        $this->datagrid->createModel();

        $panel = new TPanelGroup('Datagrid com imagem');
        $panel->add($this->datagrid);

        parent::add($panel);
     }

     public function onReload()
     {
        $this->datagrid->clear();

        $item =  new stdclass;
        $item->id = 1;
        $item->produto = 'Pen Drive 128GB Sandisk';
        $item->descricao = 'Marca: SanDisk / Capacidade de armazenamento da memória: 128 GB / Interface de hardware: USB 2.0 / Características especiais: Ergonômico / Velocidade de leitura: 1 Bytes por segundo';
        $item->preco = '49.90';
        $item->imagem = 'app/images/pendrive_sandisk.jpg';        
        $this->datagrid->addItem($item);

        $item =  new stdclass;
        $item->id = 2;
        $item->produto = 'HD Externo Samsung 1TB';
        $item->descricao = 'SAMSUNG SSD T7 Unidade de estado sólido externa portátil de 1 TB, até USB 3.2 geração 2, armazenamento confiável para jogos, estudantes, profissionais, MU-PC1T0T/AM, cinza';
        $item->preco = '770.00';
        $item->imagem = 'app/images/hd.jpg';        
        $this->datagrid->addItem($item);

        $item =  new stdclass;
        $item->id = 3;
        $item->produto = 'SD Card SanDisk 32GB';
        $item->descricao = 'Cartão Extreme Sdhc e Sdxc Uhs-I Card, SanDisk, Cartões SD, Dourado, 32GB';
        $item->preco = '119.99';
        $item->imagem = 'app/images/sdcard.jpg';        
        $this->datagrid->addItem($item);

        $item =  new stdclass;
        $item->id = 4;
        $item->produto = 'Leitor De Cartão Universal Externo Multilaser';
        $item->descricao = 'Leitor de cartão universal marca Multilaser, cor branco, dimensões 40 x 120 x 180 milímetros, 6 slots, leitor de cartão 46 em 1, plug & play, sistema operacional: 98/ 2000/ xp/ vista /mac os ou superior.';
        $item->preco = '66.90';
        $item->imagem = 'app/images/leitor_de_cartao.jpg';        
        $this->datagrid->addItem($item);

        $item =  new stdclass;
        $item->id = 5;
        $item->produto = 'Headset Gamer';
        $item->descricao = 'Headset Gamer Logitech G335 com Almofadas com Espuma de Memória, Design Leve e Conexão 3,5mm para PC, PlayStation, Xbox, Nintendo Switch e Mobile - Preto';
        $item->preco = '369.90';
        $item->imagem = 'app/images/headset_gamer.jpg';        
        $this->datagrid->addItem($item);
     }

     public function show()
     {
        $this->onReload();
        parent::show();
     }
}