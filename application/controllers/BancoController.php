<?php

class BancoController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    
        $page = $this->_getParam('page', 1);
    
        $mBanco = new Application_Model_Banco();
        $rsBanco =  $mBanco->fetchAll();
    
        $paginator = Zend_Paginator::factory($rsBanco);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
    
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    
        $this->view->assign('paginator', $paginator);
    }
    
    public function formularioAction()
    {
        
    }
    
    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $mBanco = new Application_Model_Banco();
        $mBanco->gravar($dados);
        
        $message['msg'] = 'Cadastrado com sucesso';
        $message['tipo'] = 'alert-success';
        $this->view->message = $message;
         $this->redirect("banco/index");
    }
    
    public function excluirAction()
    {
        $dados = $this->_getParam('BANCO_IN_ID');
        $mBanco = new Application_Model_Banco();
        $mBanco->excluir($dados);
        $this->redirect("banco/index");
    }
    


}

