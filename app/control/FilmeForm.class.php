<?php

class FilmeForm extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();
        $this->form = new TQuickForm('form_filme');    //criacao do formulario rapido
        $this->form->setFormTitle('Cadastro de filmes');
        $this->form->class = 'tform';

        $id = new TEntry('id');    //criacao dos campos do formulario
        $titulo = new TEntry('titulo');
        $diretor = new TEntry('diretor');
        $id_suporte = new TCombo('id_suporte');
        $id_genero = new TCombo('id_genero');
        $dt_lcto = new TDate('dt_lcto');
        $duracao = new TEntry('duracao');

        $id->setEditable(FALSE);
        $duracao->setMask('999');
        $id_suporte->addItems(array(1 => 'DVD', 2 => 'Blu-Ray'));    //criacao do vetor com os dados para dentro da caixa combo
        $id_genero->addItems(array(1 => 'Ação', 2 => 'Animação', 3 => 'Aventura', 4 => 'Chanchada', 5 => 'Cinema catástrofe', 6 => 'Comédia', 7 => 'Comédia romântica', 8 => 'Comédia dramática', 9 => 'Comédia de ação', 10 => 'Cult', 11 => 'Dança', 12 => 'Documentários', 13 => 'Drama', 14 => 'Espionagem', 15 => 'Erótico', 16 => 'Fantasia', 17 => 'Faroeste (ou western)', 18 => 'Ficção científica', 19 => 'Franchise/Séries', 20 => 'Guerra', 21 => 'Machinima', 22 => 'Masala', 23 => 'Musical', 24 => 'Filme noir', 25 => 'Policial', 26 => 'Pornochanchada', 27 => 'Pornográfico', 28 => 'Romance', 29 => 'Suspense', 30 => 'Terror (ou horror)', 31 => 'Trash'));

        $this->form->addQuickField('ID', $id, 100);    //criacao da caixa de preenchimento dos campos
        $this->form->addQuickField('Titulo', $titulo, 200);
        $this->form->addQuickField('Diretor', $diretor, 200);
        $this->form->addQuickField('Suporte', $id_suporte, 100);
        $this->form->addQuickField('Genero', $id_genero, 100);
        $this->form->addQuickField('Lançamento', $dt_lcto, 100);
        $this->form->addQuickField('Duração (min)', $duracao, 100);

        $save = new TAction(array($this, 'onSave'));    //botoes para salvar e editar
        $this->form->addQuickAction('Salvar', $save, 'ico_save.png');

        $list = new TAction(array('FilmeList', 'onReload'));
        $this->form->addQuickAction('Listar', $list, 'ico_datagrid.png');

        parent::add($this->form);
    }

    public function onSave()    //metodos para salvar editar e excluir um registro
    {

        try {
            TTransaction::open('sample');    //abertura de conexao com o banco

            $object = $this->form->getData('Filme');

            $object->store();    //armazenamento do dado

            $this->form->setData($object);

            new TMessage('info', 'Registro salvo com sucesso!');    //mensagem apos conclusao

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
            $object = new Filme($key);
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
            $object = new Filme($key);
            $object->delete();

            TTransaction::close();

            new TMessage('info', 'Registro deletado com sucesso!');
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }

    }

}

?>
