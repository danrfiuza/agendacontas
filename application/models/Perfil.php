<?php
class Application_Model_Perfil extends Zend_Db_Table  
{
    protected $_name = 'perfil'; 

    public function gravar($dados)
    {
        if(!empty($dados['PERFIL_IN_ID'])){
            $row = $this->fetchRow("PERFIL_IN_ID = ".$dados['PERFIL_IN_ID']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();
    
    }
    
    public function excluir($dados)
    {
        $row = $this->fetchRow('PERFIL_IN_ID = '.$dados['PERFIL_IN_ID']);
        $row->delete();
    }
    
}

