<?php

class filme extends TRecord
{
    const TABLENAME = 'filme';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'max';

    public function __construct($id = NULL)
    {
        parent::__construct($id);

        parent::addAttribute('titulo');
        parent::addAttribute('diretor');
        parent::addAttribute('id_suporte');
        parent::addAttribute('id_genero');
        parent::addAttribute('dt_lcto');
        parent::addAttribute('duracao');
    }

}

?>
