<?php
class Application_Model_Usuario extends Zend_Db_Table  
{
    protected $_name = 'usuario'; 

    public function gravar($dados)
    {
        if(!empty($dados['USU_IN_ID'])){
            $row = $this->fetchRow("USU_IN_ID = ".$dados['USU_IN_ID']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        return $row->save();
    }

    public function excluir($dados)
    {
        print_r($dados['USU_IN_ID']);die;
        $row = $this->fetchRow('USU_IN_ID = '.$dados['USU_IN_ID']);
        $row->delete();
    }

}

