<?php

class BaixaController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       
    }

    public function formularioAction()
    { 
        $this->_helper->layout->disableLayout();
        $dados = $this->_getAllParams();
        $mBaixa = new Application_Model_Baixa();
        $mConta = new Application_Model_Conta();
        $mParcelamento = new  Application_Model_Parcelamento();
        if(!empty($dados['PAR_IN_ID'])){
            $row = $mBaixa->fetchRow("PAR_IN_ID = ".$dados['PAR_IN_ID']);
        }else{
            $row = $mBaixa->createRow();
        }

        $this->view->parcela = $mParcelamento->listarParcelamentoId($dados['PAR_IN_ID']);
        $this->view->row = $row;
        $this->view->aConta = $mConta->fetchAll();
    }

    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $mBaixa = new Application_Model_Baixa();
        $mBaixa->gravar($dados);
        
         $this->redirect("index/index");
    }
    
    public function excluirAction()
    {
        
    }
    


}

