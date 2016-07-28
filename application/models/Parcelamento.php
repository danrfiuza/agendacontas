<?php
class Application_Model_Parcelamento extends Zend_Db_Table  
{
    protected $_name = 'parcelamento'; 

    public function gravar($dados)
    {
        if(!empty($dados['PAR_IN_ID'])){
            $row = $this->fetchRow("PAR_IN_ID = ".$dados['PAR_IN_ID']);
        }else{
            $dados['PAR_CH_SITUACAO'] = 'A';
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();
    }

    public function excluir($dados)
    {
        $row = $this->fetchRow('PAR_IN_ID = '.$dados['PAR_IN_ID']);
        $row->delete();
    }
    /**
     * 
     * @param int $nParcelas
     * @param date $dataPrimeiraParcela
     * @param double $total
     */
    function calcularParcelas($nParcelas, $dataPrimeiraParcela = null,$total){
        $parcelas = array();

        if($nParcelas <= 0 || $total <=0){
            $nParcelas = 0;
            $valorParcela = $total;
        }else{
            $valorParcela = $total/$nParcelas;
        }

        if($dataPrimeiraParcela != null){
            $dataPrimeiraParcela = explode( "/",$dataPrimeiraParcela);
            $dia = $dataPrimeiraParcela[0];
            $mes = $dataPrimeiraParcela[1];
            $ano = $dataPrimeiraParcela[2];
        } else {
            $dia = date("d");
            $mes = date("m");
            $ano = date("Y");
        }
        $numero_parcela = 1;
        for($x = 0; $x < $nParcelas; $x++){
            $parcelas[$x]['PAR_IN_PARCELA'] = $numero_parcela + $x; //número da parcela
            $parcelas[$x]['PAR_DT_VENCIMENTO'] =  date("d/m/Y",strtotime("+".$x." month",mktime(0, 0, 0,$mes,$dia,$ano)));//data de vencimento da parcela
            $parcelas[$x]['PAR_DBL_PARCELA'] = $valorParcela;//valor da parcela
        }
        return $parcelas;
    }

    public function listarParcelamentoTipo($tipo)
    {
         $select = $this->select()
        ->setIntegrityCheck(false)
        ->from(array('p' => 'parcelamento'), array('*'))
        ->join(array('m' => 'mov_financeiro'), 'm.MOV_IN_ID = p.MOV_IN_ID', array('m.MOV_CH_TIPO','m.MOV_ST_DESCRICAO'))
        ->join(array('c' => 'categoria'), 'm.CAT_IN_ID = c.CAT_IN_ID', array('c.CAT_ST_DESCRICAO'))
        ->where("m.MOV_CH_TIPO = ?",$tipo)
        ->where("p.PAR_CH_SITUACAO <> 'F'")
        ->order("p.PAR_DT_VENCIMENTO ASC");
      return  $rsParcelamento = $this->fetchAll($select);
    }

    public function listarParcelamentoId($id)
    {
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from(array('p' => 'parcelamento'), array('*'))
        ->join(array('m' => 'mov_financeiro'), 'm.MOV_IN_ID = p.MOV_IN_ID', array('m.MOV_CH_TIPO','m.MOV_ST_DESCRICAO'))
        ->join(array('c' => 'categoria'), 'm.CAT_IN_ID = c.CAT_IN_ID', array('c.CAT_ST_DESCRICAO'))
        ->where("p.PAR_IN_ID = $id")
        ->where("p.PAR_CH_SITUACAO <> 'F'")
        ->order("p.PAR_DT_VENCIMENTO ASC");
        return  $rsParcelamento = $this->fetchRow($select);
    }
}

