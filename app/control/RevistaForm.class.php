<?php

class RevistaForm extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();
        $this->form = new TQuickForm('form_revista');    //criacao do formulario rapido
        $this->form->setFormTitle('Cadastro de revistas');    
        $this->form->class = 'tform';

        $id = new TEntry('id');     //criacao dos campos do formulario
        $titulo = new TEntry('titulo');
        $editora = new TEntry('editora');
        $id_genero = new TCombo('id_genero');
        $dt_lcto = new TDate('dt_lcto');
        $edicao = new TEntry('edicao');

        $id->setEditable(FALSE);    //criacao do vetor com os dados para dentro da caixa combo
        $id_genero->addItems(array(1 => 'HQ', 2 => 'Mangá', 3 => 'Moda', 4 => 'Empresarial', 5 => 'Noticiosa', 6 => 'Científica', 7 => 'Temática', 8 => 'Fotonovela', 9 => 'Astrológica', 10 => 'Religiosa', 11 => 'Fofoca', 12 => 'Desenho', 13 => 'Jogos'));

        $this->form->addQuickField('ID', $id, 100);     //criacao da caixa de preenchimento dos campos
        $this->form->addQuickField('Titulo', $titulo, 400);
        $this->form->addQuickField('Editora', $editora, 200);
        $this->form->addQuickField('Genero', $id_genero, 100);
        $this->form->addQuickField('Lançamento', $dt_lcto, 100);
        $this->form->addQuickField('Edição', $edicao, 100);

        $save = new TAction(array($this, 'onSave'));    //botoes para salvar e editar
        $this->form->addQuickAction('Salvar', $save, 'ico_save.png');

        $list = new TAction(array('RevistaList', 'onReload'));
        $this->form->addQuickAction('Listar', $list, 'ico_datagrid.png');

        parent::add($this->form);
    }

    public function onSave()    //metodos para salvar editar e excluir um registro
    {

        try {
            TTransaction::open('sample');

            $object = $this->form->getData('Revista');

            $object->store();

            $this->form->setData($object);

            new TMessage('info', 'Registro salvo com sucesso!');

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
            TTransaction::rollback();
        }
    }

    public function onEdit($param)
    {

        try {
            TTransaction::open('sample');
            $key = $param['key'];
            $object = new Revista($key);
            $this->form->setData($object);
            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }

    }

    public function delete($param)
    {

        try {
            TTransaction::open('sample');
            $key = $param['key'];
            $object = new Revista($key);
            $object->delete();

            TTransaction::close();

            new TMessage('info', 'Registro deletado com sucesso!');
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }

    }

}

?>