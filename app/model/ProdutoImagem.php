<?php
/**
 * ProdutoImagem Active Record
 * @author  <your-name-here>
 */
class ProdutoImagem extends TRecord
{
    const TABLENAME = 'produto_imagem';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('produto_id');
        parent::addAttribute('imagem');
    }


}
