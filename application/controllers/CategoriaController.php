<?php
class CategoriaController extends Zend_Controller_Action
{
    public function indexAction(){
        
    }
    
    public function formularioAction()
    {
        $dados = $this->_getAllParams();
       
        $mCategoria = new Application_Model_Categoria();
        if(!empty($dados['CAT_IN_ID'])){
            $row = $mCategoria->fetchRow("CAT_IN_ID = ".$dados['CAT_IN_ID']);
        }else{
            $row = $mCategoria->createRow();
        }
        $this->view->row = $row;
    }

    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $mCategoria = new Application_Model_Categoria();
        $res = $mCategoria->gravar($dados);
        $this->redirect("categoria/index");
    }
    
    public function excluirAction()
    {
        $dados = $this->_getParam('CAT_IN_ID');
        $mCategoria = new Application_Model_Categoria();
        $mCategoria->excluir($dados);
        $this->redirect("categoria/index");
    }

}