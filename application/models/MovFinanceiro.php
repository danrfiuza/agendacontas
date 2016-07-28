<?php
class Application_Model_MovFinanceiro extends Zend_Db_Table  
{
    protected $_name = 'mov_financeiro'; 

    public function gravar($dados)
    {
    
        if(!empty($dados['MOV_IN_ID'])){
            $row = $this->fetchRow("MOV_IN_ID = ".$dados['MOV_IN_ID']);
        }else{
            $dados['MOV_DT_DATA'] = date('Y-m-d');
            $dados['MOV_CH_SITUACAO'] = 'A';
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        return $row->save();
    }
    
    public function excluir($dados)
    {
        $row = $this->fetchRow('MOV_IN_ID = '.$dados['MOV_IN_ID']);
        $row->delete();
    }
    
    public function getMovFinanceiro(){
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from(array('m' => 'mov_financeiro'), array('*'))
        ->join(array('c' => 'categoria'), 'm.CAT_IN_ID = c.CAT_IN_ID', array('c.CAT_ST_DESCRICAO'))
        ->where("m.MOV_CH_SITUACAO <> 'F'");
      return  $rsMovimento = $this->fetchAll($select);
    }
}

