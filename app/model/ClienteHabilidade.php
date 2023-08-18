<?php
/**
 * ClienteHabilidade Active Record
 * @author  <your-name-here>
 */
class ClienteHabilidade extends TRecord
{
    const TABLENAME = 'cliente_habilidade';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('cliente_id');
        parent::addAttribute('habilidade_id');
    }


}
