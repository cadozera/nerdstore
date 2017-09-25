<?php
class FilmeList extends TPage{
    private $datagrid;
    
    function __construct(){
    
        parent::__construct();
    
        $this->datagrid = new TQuickGrid;
        $this->datagrid->addQuickColumn('ID', 'id', 'center',50);
        $this->datagrid->addQuickColumn('Titulo', 'titulo', 'center',400);
        $this->datagrid->addQuickColumn('Diretor', 'diretor', 'center',400);
        $this->datagrid->addQuickColumn('Genero', 'id_genero', 'center', 150);
        $this->datagrid->addQuickColumn('Duração (min)', 'duracao', 'center', 150);
        
        $edit = new TDataGridAction(array('FilmeForm','onEdit'));
        $this->datagrid->addQuickAction('Editar',$edit,'id','ico_edit.png');

        $delete = new TDataGridAction(array('FilmeForm','delete'));
        $this->datagrid->addQuickAction('Deletar',$delete,'id','ico_delete.png');
        
        $this->datagrid->createModel();
    
        parent::add($this->datagrid);
    }
    
    public function onReload($param = NULL){
        try{
        TTransaction::open('sample');
        
        $repository = new TRepository('Filme');
        $criteria = new TCriteria;
        $objects = $repository->load(new TCriteria);
        
        $this->datagrid->clear();
        
        if($objects){
        
            foreach($objects as $object){
                $this->datagrid->addItem($object);
            }
        }        
        TTransaction::close();
        }
        catch(Exception $e){
            new TMessage('error', $e->getMessage());
        }
        $this->loaded = TRUE;
    }
    
    public function show(){
        if(!$this->loaded){
            $this->onReload();
        }
        parent::show();
    }
    
}
?>
