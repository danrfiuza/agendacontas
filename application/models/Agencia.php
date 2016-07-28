<?php
class Application_Model_Agencia extends Zend_Db_Table  
{
    protected $_name = 'agencia'; 
    
    public function gravar($dados)
    {
        if(!empty($dados['AGE_IN_ID'])){
            $row = $this->fetchRow("AGE_IN_ID = ".$dados['AGE_IN_ID']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();
    
    }
    
    public function excluir($dados)
    {
        $row = $this->fetchRow('AGE_IN_ID = '.$dados['AGE_IN_ID']);
        $row->delete();
    }
    
    public function listAgenciaBanco()
    {
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from(array('a' => 'agencia'), array('a.AGE_IN_ID', 'a.AGE_ST_DESCRICAO','a.AGE_IN_NUMERO'))
        ->join(array('b' => 'banco'), 'a.BANCO_IN_ID = b.BANCO_IN_ID', array('b.BANCO_ST_DESCRICAO'));
       return $rsAgenciaBanco = $this->fetchAll($select);
    }

}

