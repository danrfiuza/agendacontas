<?php
class UsuarioController extends Zend_Controller_Action
{
    public function init()
    {
        
    }
    
    public function indexAction()
    {
        $page = $this->_getParam('page', 1);
    
        $modelUsuario = new Application_Model_Usuario();
        $rsUsuario =  $modelUsuario->fetchAll();
    
        $paginator = Zend_Paginator::factory($rsUsuario);
        $paginator->setCurrentPageNumber($page)->setItemCountPerPage(10);
    
        Zend_Paginator::setDefaultScrollingStyle('Sliding');
        Zend_View_Helper_PaginationControl::setDefaultViewPartial('pagination.phtml');
    
        $this->view->assign('paginator', $paginator);
    }

    public function loginAction()
    {
        
    }
    
    public function formularioAction()
    {
        $dados = $this->getAllParams();
        $mPerfil = new Application_Model_Perfil();
        $mUsuario = new Application_Model_Usuario();
        if(!empty($dados['USU_IN_ID'])){
            $row = $mUsuario->fetchRow("USU_IN_ID = ".$dados['USU_IN_ID']);
        }else{
            $row = $mUsuario->createRow();
        }

        $rsPerfil = $mPerfil->fetchAll();
        $this->view->aPerfil = $rsPerfil;
        $this->view->row = $row;
    }

    public function gravarAction()
    {
        $dados = $this->_getAllParams();
        $dados['USU_ST_SENHA'] = md5($dados['USU_ST_SENHA']);
        $mUsuario = new Application_Model_Usuario();
        $id_usuario = $mUsuario->gravar($dados);

        $foto = $this->uploadFoto($id_usuario,"USU_ST_FOTO");
        $dadosUpdate['USU_ST_FOTO'] = $foto;
        $mUsuario->update($dadosUpdate,"USU_IN_ID = $id_usuario");
        $this->redirect("usuario/index");
    }

    public function uploadFoto($id_usuario,$campo)
    {
        if(isset($_FILES["$campo"]) && $_FILES["$campo"]['error'] == 0){//verifica se o campo files com name foto está settado
        //dê um print_ na constante FILES para ver todos os parâmetros que ela possui sobre o arquivo
            $origem = $_FILES["$campo"]['tmp_name']; // pega o endereço temporário onde a imagem é guardada até que seja feito o upload
            $extensao = substr($_FILES["$campo"]['name'], strrpos($_FILES["$campo"]['name'], '.')); //recupera qual a extenção do arquivo (jpg,pdf,etc)
            $destino = 'img/fotos/' . $id_usuario . $extensao; //informa a pasta destino juntamene com o novo nome do arqui
            move_uploaded_file($origem, $destino); //método do ZF para fazer o upload do arquivo: parâmetros: origem e destino
            return $id_usuario.$extensao; //
        }
    }

    public function formularioTrocarSenhaAction()
    {
        $this->_helper->layout->disableLayout();
        $dados = $this->_getAllParams();

        $this->view->id = $dados['USU_IN_ID'];
    }

    public function excluirAction()
    {
        $dados = $this->_getParam('USU_IN_ID');
        $modelUsuario = new Application_Model_Usuario();
        $modelUsuario->excluir($dados);
        $this->redirect("usuario/index");
    }

}