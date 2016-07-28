<?php

class ContaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
    
        $page = $this->_getParam('page', 1);
    
        $mConta = new Application_Model_Conta();
        $rsConta =  $mConta->fetchAll();
    
        $paginator = Zend_Paginator::factory($rsConta);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
    
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    
        $this->view->assign('paginator', $paginator);
    }
    
    public function formularioAction()
    {
        $dados = $this->_getAllParams();
        
        $mTipoConta = new Application_Model_TipoConta();
        $mBanco = new Application_Model_Banco();
        $mAgencia = new Application_Model_Agencia();
        $mConta = new Application_Model_Conta();
        
        if(!empty($dados['CON_IN_ID'])){
            $row = $mConta->fetchRow("CON_IN_ID = ".$dados['CON_IN_ID']);
        }else{
            $row = $mConta->createRow();
        }
        
        $rsTipoConta = $mTipoConta->fetchAll();
        $rsBanco = $mBanco->fetchAll();
        $rsAgencia = $mAgencia->fetchAll("BANCO_IN_ID = '{$dados['BANCO_IN_ID']}'",'AGE_ST_DESCRICAO');
        
        $this->view->banco = $rsBanco;
        $this->view->agencia = $rsAgencia;
        $this->view->tipo_conta = $rsTipoConta;
        $this->view->row = $row;
        
    }
    
    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $mConta = new Application_Model_Conta();
        $mConta->gravar($dados);
        
         $this->redirect("conta/index");
    }
    
    public function excluirAction()
    {
        $dados = $this->_getParam('CON_IN_ID');
        $mConta = new Application_Model_Conta();
        $mConta->excluir($dados);
        $this->redirect("conta/index");
    }
    


}

