<?php

class ParcelamentoController extends Zend_Controller_Action
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
    
    }
    
    public function gravarAction()
    {
       
    }
    
    public function excluirAction()
    {
        
    }

    public function gerarParcelasAction()
    {
        $this->_helper->layout->disableLayout();
        $dados = $this->_getAllParams();
        
        $parcelas = $dados['MOV_IN_PARCELAS'];
        $total = $dados['MOV_DBL_TOTAL'];
        $vencimento = $dados['dia_vencimento'];
        
        $mParcela = new Application_Model_Parcelamento();
        $rsParcela = $mParcela->calcularParcelas($parcelas,$vencimento, $total);
        $this->view->aParcela = $rsParcela;
        
    }


}

