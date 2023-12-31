<?php

use Adianti\Database\TRecord;

/**
 * Estado Active Record
 * @author  <your-name-here>
 */
class Estado extends TRecord
{
    const TABLENAME = 'estado';
    const PRIMARYKEY= 'id';
    const IDPOLICY =  'max'; // {max, serial}
    
    
    /**
     * Constructor method
     */
    public function __construct($id = NULL, $callObjectLoad = TRUE)
    {
        parent::__construct($id, $callObjectLoad);
        parent::addAttribute('nome');
    }


}
