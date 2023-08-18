<?php

use Adianti\Database\TRecord;

class Produto extends TRecord  
{
    const TABLENAME  = 'produto';
    const PRIMARYKEY = 'id';
    const IDPOLICY   = 'max'; // {max,serial}
    
    public function __construct($id = null, $callObjectLoad = true)
    {
        parent::__construct($id, $callObjectLoad);
        
        parent::addAttribute('descricao');
        parent::addAttribute('estoque');
        parent::addAttribute('preco_venda');
        parent::addAttribute('unidade');
        parent::addAttribute('local_foto');
    }
}
