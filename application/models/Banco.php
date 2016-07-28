<?php
class Application_Model_Banco extends Zend_Db_Table  
{
    protected $_name = 'banco'; 
    
    public function gravar($dados)
    {
        if(!empty($dados['BANCO_IN_ID'])){
            $row = $this->fetchRow("BANCO_IN_ID = ".$dados['BANCO_IN_ID']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();
    
    }
    
    public function excluir($dados)
    {
        $row = $this->fetchRow('BANCO_IN_ID = '.$dados['BANCO_IN_ID']);
        $row->delete();
    }
}

