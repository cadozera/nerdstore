<?php

class revista extends TRecord
{
    const TABLENAME = 'revista';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __construct($id = NULL)
    {
        parent::__construct($id);

        parent::addAttribute('titulo');
        parent::addAttribute('editora');
        parent::addAttribute('id_genero');
        parent::addAttribute('dt_lcto');
        parent::addAttribute('edicao');
    }

}

?>