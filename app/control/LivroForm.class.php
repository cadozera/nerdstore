<?php

class LivroForm extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();
        $this->form = new TQuickForm('form_livro');    //criacao do formulario rapido
        $this->form->setFormTitle('Cadastro de livros');
        $this->form->class = 'tform';

        $id = new TEntry('id');    //criacao dos campos do formulario
        $titulo = new TEntry('titulo');
        $editora = new TEntry('editora');
        $genero = new TCombo('genero');
        $isbn = new TEntry('isbn');
        $dt_lcto = new TDate('dt_lcto');


        $id->setEditable(FALSE);     //criacao do vetor com os dados para dentro da caixa combo
        $genero->addItems(array('Antologias', 'Audiobooks', 'Autoajuda', 'Aventura', 'Biográficos', 'Científicos', 'Contos', 'Crônicas', 'Didáticos', 'Épicos', 'Fantasia', 'Ficção científica', 'Ficção histórica', 'Guias de viagem', 'Horror', 'Infantojuvenis', 'Poesia'));

        $this->form->addQuickField('ID', $id, 100);    //criacao da caixa de preenchimento dos campos
        $this->form->addQuickField('Titulo', $titulo, 400);
        $this->form->addQuickField('Editora', $editora, 200);
        $this->form->addQuickField('Genero', $genero, 100);
        $this->form->addQuickField('ISBN', $isbn, 100);
        $this->form->addQuickField('Lançamento', $dt_lcto, 100);


        $save = new TAction(array($this, 'onSave'));    //botoes para salvar e editar    
        $this->form->addQuickAction('Salvar', $save, 'ico_save.png');

        $list = new TAction(array('LivroList', 'onReload'));
        $this->form->addQuickAction('Listar', $list, 'ico_datagrid.png');

        parent::add($this->form);
    }

    public function onSave()    //metodos para salvar editar e excluir um registro
    {

        try {
            TTransaction::open('sample');

            $object = $this->form->getData('Livro');

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
            $object = new Livro($key);
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
            $object = new Livro($key);
            $object->delete();

            TTransaction::close();

            new TMessage('info', 'Registro deletado com sucesso!');
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }

    }

}

?>