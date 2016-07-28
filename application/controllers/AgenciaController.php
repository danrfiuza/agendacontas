<?php

class AgenciaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    
        $page = $this->_getParam('page', 1);
    
        $mAgencia = new Application_Model_Agencia();
        $rsAgencia =  $mAgencia->listAgenciaBanco();
    
        $paginator = Zend_Paginator::factory($rsAgencia);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
    
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    
        $this->view->assign('paginator', $paginator);
    }
    
    public function formularioAction()
    {
        $mBanco = new Application_Model_Banco();
        $rsBanco = $mBanco->fetchAll();
        
        $this->view->banco = $rsBanco;
    }
    
    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $mAgencia = new Application_Model_Agencia();
        $mAgencia->gravar($dados);
        
        $message['msg'] = 'Cadastrado com sucesso';
        $message['tipo'] = 'alert-success';
        $this->view->message = $message;
         $this->redirect("agencia/index");
    }
    
    public function excluirAction()
    {
        $dados = $this->_getParam('BANCO_IN_ID');
        $mBanco = new Application_Model_Banco();
        $mBanco->excluir($dados);
        $this->redirect("banco/index");
    }
    
    public function carregarAgenciaAction()
    {
        $this->_helper->layout->disableLayout();

        $dados = $this->_getAllParams();
        $mAgencia = new Application_Model_Agencia();
        $this->view->agencia = $mAgencia->fetchAll("BANCO_IN_ID = '{$dados['BANCO_IN_ID']}'");
    
    }

}

