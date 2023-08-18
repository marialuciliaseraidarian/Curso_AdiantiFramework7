<?php
/**
 * VendaItem Active Record
 * @author  <your-name-here>
 */
class VendaItem extends TRecord
{
    const TABLENAME = 'venda_item';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    private $produto;
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('preco_venda');
        parent::addAttribute('quantidade');
        parent::addAttribute('desconto');
        parent::addAttribute('total');
        parent::addAttribute('produto_id');
        parent::addAttribute('venda_id');
    }

    public function get_produto()
    {
        if (empty($this->produto))
        {
            $this->produto = new Produto($this->produto_id);
        }
        return $this->produto;
    }

}
