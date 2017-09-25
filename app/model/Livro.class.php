<?php

class livro extends TRecord
{
    const TABLENAME = 'livro';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __construct($id = NULL)
    {
        parent::__construct($id);

        parent::addAttribute('titulo');
        parent::addAttribute('editora');
        parent::addAttribute('genero');
        parent::addAttribute('isbn');
        parent::addAttribute('dt_lcto');

    }

}

?>