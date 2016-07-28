<?php
class Application_Model_TipoConta extends Zend_Db_Table  
{
    protected $_name = 'tipo_conta'; 
    
    public function gravar($dados)
    {
        if(!empty($dados['TIPO_CONTA_IN_ID'])){
            $row = $this->fetchRow("TIPO_CONTA_IN_ID = ".$dados['TIPO_CONTA_IN_ID']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();
    
    }
    
    public function excluir($dados)
    {
        $row = $this->fetchRow('TIPO_CONTA_IN_ID = '.$dados['TIPO_CONTA_IN_ID']);
        $row->delete();
    }
}

