<?php

class RevistaList extends TPage
{
    private $datagrid;

    function __construct()
    {

        parent::__construct();

        $this->datagrid = new TQuickGrid;    //criacao da tabela rapida   
        $this->datagrid->addQuickColumn('ID', 'id', 'center', 50);    //criacao das colunas e seus tamanhos
        $this->datagrid->addQuickColumn('Titulo', 'titulo', 'center', 250);
        $this->datagrid->addQuickColumn('Editora', 'editora', 'center', 200);
        $this->datagrid->addQuickColumn('Edição', 'edicao', 'center', 200);
        $this->datagrid->addQuickColumn('Data de lançamento', 'dt_lcto', 'center', 200);

        $edit = new TDataGridAction(array('RevistaForm', 'onEdit'));    // botoes nas colunas com funcao de editar e excluir
        $this->datagrid->addQuickAction('Editar', $edit, 'id', 'ico_edit.png');

        $delete = new TDataGridAction(array('RevistaForm', 'delete'));
        $this->datagrid->addQuickAction('Deletar', $delete, 'id', 'ico_delete.png');

        $this->datagrid->createModel();

        parent::add($this->datagrid);
    }

    public function onReload($param = NULL)    //abertura de conexao com o banco
    {
        try {
            TTransaction::open('sample');

            $repository = new TRepository('Revista');
            $criteria = new TCriteria;
            $objects = $repository->load(new TCriteria);

            $this->datagrid->clear();

            if ($objects) {

                foreach ($objects as $object) {
                    $this->datagrid->addItem($object);
                }
            }
            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
        $this->loaded = TRUE;
    }

    public function show()
    {
        if (!$this->loaded) {
            $this->onReload();
        }
        parent::show();
    }
}

?>