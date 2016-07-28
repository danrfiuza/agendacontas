<?php
class PerfilController extends Zend_Controller_Action
{
    public function init()
    {
        
    }
    
    public function  indexAction()
    {
        $dados = $this->getAllParams();

        $mPerfil = new Application_Model_Perfil();
        $rsPerfil = $mPerfil->fetchAll();

        $this->view->row = $rsPerfil;
    }
    
    public function loginAction()
    {
        
    }
    
    public function formularioAction()
    {
        $this->_helper->layout->disableLayout();

        $dados = $this->getAllParams();
        $mPerfil = new Application_Model_Perfil();
        if(!empty($dados['PERFIL_IN_ID'])){
            $row = $mPerfil->fetchRow("PERFIL_IN_ID = ".$dados['PERFIL_IN_ID']);
        }else{
            $row = $mPerfil->createRow();
        }
        $rsPerfil = $mPerfil->fetchAll();
        $this->view->row = $row;
    }
    
    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $mPerfil = new Application_Model_Perfil();
        $mPerfil->gravar($dados);
        $this->redirect("perfil/index");
    }
    
    public function excluirAction()
    {
        $id = $this->_getParam("PERFIL_IN_ID");
        $mPerfil = new Application_Model_Perfil();
        $mPerfil->excluir($id);
        $this->redirect("perfil/index");
    }
    
    
}