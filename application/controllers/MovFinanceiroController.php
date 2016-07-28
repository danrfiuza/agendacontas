<?php
class MovFinanceiroController extends Zend_Controller_Action
{
    public function init()
    {
    
    }

    public function indexAction()
    {
        $page = $this->_getParam('page', 1);
        
        $mMovimento = new Application_Model_MovFinanceiro();
        $rsMovimento =  $mMovimento->getMovFinanceiro();
        
        $paginator = Zend_Paginator::factory($rsMovimento);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
        
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
        
        $this->view->assign('paginator', $paginator);
    }

    public function formularioAction()
    {
        $id = $this->_getParam('MOV_IN_ID');

        $mMovFin = new Application_Model_MovFinanceiro();
        $mCategoria = new Application_Model_Categoria();
        if(!empty($id)){
            $row = $mMovFin->fetchRow("MOV_IN_ID = $id");
        }else{
            $row = $mMovFin->createRow();
        }
        
        $aCategoria = $mCategoria->fetchAll();

        $this->view->aCategoria = $aCategoria;
        $this->view->row = $row;
    }

    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $parcelas = $dados['MOV_IN_PARCELAS'];
        $mMovimento = new Application_Model_MovFinanceiro();
        $mParcelamento = new Application_Model_Parcelamento();
        
        $dados['MOV_IN_ID'] = $mMovimento->gravar($dados);

        $dado = array();

        for($x = 0;$x <= $parcelas;$x++){
            $dado['MOV_IN_ID']         = $dados['MOV_IN_ID'];
            $dado['PAR_IN_PARCELA']    = $dados['PAR_IN_PARCELA'][$x];
            $dado['PAR_DT_VENCIMENTO'] = implode("-",array_reverse(explode("/",$dados['PAR_DT_VENCIMENTO'][$x])));
            $dado['PAR_DBL_PARCELA']   = $dados['PAR_DBL_PARCELA'][$x];
            $mParcelamento->gravar($dado);
        }
        $this->redirect("mov-financeiro/index");
    }

    public function listarCategoriaPorTipoAction()
    {
        $this->_helper->layout->disableLayout();
        $tipo = $this->_getParam("CAT_CH_TIPO");
        $id = $this->_getParam('CAT_IN_ID');
        $mCategoria = new Application_Model_Categoria();
        $aCategoria = $mCategoria->getCategoriaPorTipo($tipo);
        
        $this->view->aCategoria = $aCategoria;
        $this->view->CAT_IN_ID = $id;
    }
}
