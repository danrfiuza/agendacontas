<?php
class Application_Model_Conta extends Zend_Db_Table  
{
    protected $_name = 'conta'; 

    public function gravar($dados)
    {
        $dados['USU_IN_ID'] = 1;
        if(!empty($dados['CON_IN_ID'])){
            $row = $this->fetchRow("CON_IN_ID = ".$dados['CON_IN_ID']." AND USU_IN_ID = ". $dados['USU_IN_ID']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();
    
    }

}

