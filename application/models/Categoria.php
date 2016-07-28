<?php
class Application_Model_Categoria extends Zend_Db_Table  
{
    protected $_name = 'categoria'; 

    public function gravar($dados)
    {
        
        if(!empty($dados['CAT_IN_ID'])){
            $row = $this->fetchRow("CAT_IN_ID = ".$dados['CAT_IN_ID']);
        }else{
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();
    }

    public function excluir($dados)
    {
        $row = $this->fetchRow('CAT_IN_ID = '.$dados['CAT_IN_ID']);
        $row->delete();
    }

    public function verificaIdentificador($CAT_ST_IDENTIFICADOR)
    {
        $row = $this->fetchAll("CAT_ST_IDENTIFICADOR = '{$CAT_ST_IDENTIFICADOR}'");
        
        if($row == false){
            return true;
        }
        return false;
    }

    public function getCategoriaPorTipo($tipo)
    {
        return $this->fetchAll("CAT_CH_TIPO = '$tipo'");
    }
}

