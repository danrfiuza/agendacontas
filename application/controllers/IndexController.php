<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
       $mParcelamento = new Application_Model_Parcelamento();
       $rsParcelamentoDebito = $mParcelamento->listarParcelamentoTipo('D');
       $rsParcelamentoCredito = $mParcelamento->listarParcelamentoTipo('C');
        
       $this->view->aParcelamentoDebito = $rsParcelamentoDebito;
       $this->view->aParcelamentoCredito = $rsParcelamentoCredito;
        
    }


}

