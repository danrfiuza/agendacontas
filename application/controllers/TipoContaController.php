<?php

class TipoContaController extends Zend_Controller_Action
{
    public function indexAction()
    {
        
    }

    public function formularioAction()
    {
        $dados = $this->_getAllParams();
        $mTipoConta = new Application_Model_TipoConta();
        
        if(!empty($dados['TIPO_CONTA_IN_ID'])){
            $row = $mTipoConta->fetchRow("TIPO_CONTA_IN_ID = ".$dados['TIPO_CONTA_IN_ID']);
        }else{
            $row = $mTipoConta->createRow();
        }
        
        $this->view->row = $row;
    }

    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $mTipoConta = new Application_Model_TipoConta();
        $mTipoConta->gravar($dados);
        
         $this->redirect("tipo-conta/index");
    }

    public function excluirAction()
    {
        $dados = $this->_getParam('TIPO_CONTA_IN_ID');
        $mTipoConta = new Application_Model_TipoConta();
        $mTipoConta->excluir($dados);
         $this->redirect("tipo-conta/index");
    }
    
}

