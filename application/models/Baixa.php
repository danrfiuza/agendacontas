<?php
class Application_Model_Baixa extends Zend_Db_Table  
{
    protected $_name = 'baixa'; 

    public function gravar($dados)
    {
        $dados['BAIXA_DBL_VALOR'] = $this->baixaParcela($dados['PAR_IN_ID'],$dados['BAIXA_DBL_VALOR'],$dados['BAIXA_DBL_MULTA'],$dados['BAIXA_DBL_DESCONTO'],$dados['BAIXA_DBL_JUROS']);
        $this->baixaConta($dados['CON_IN_ID'],$dados['BAIXA_DBL_VALOR'], $dados['MOV_CH_TIPO']);

        if(!empty($dados['BAIXA_IN_ID'])){
            $row = $this->fetchRow("BAIXA_IN_ID = ".$dados['BAIXA_IN_ID']);
        }else{
            $dados['BAIXA_DT_BAIXA'] = date('Y-m-d');
            $row = $this->createRow();
        }
        $row->setFromArray($dados);
        $row->save();
        
    }

    public function baixaConta($id_conta,$valorBaixa = 0,$tipoMovimento)
    {
        $mConta = new Application_Model_Conta();
        $rsConta = $mConta->fetchRow($id_conta);

        if($tipoMovimento == 'D'){//Se for uma operação de débito
            $dadosConta['CON_DBL_SALDO'] =  $rsConta['CON_DBL_SALDO'] - $valorBaixa;
        }

        if($tipoMovimento == 'C'){//Se for uma operação de Crédito
            $dadosConta['CON_DBL_SALDO'] =  $rsConta['CON_DBL_SALDO'] + $valorBaixa;
        }
        $dadosConta['CON_IN_ID'] = $id_conta;
        $mConta->gravar($dadosConta);
    }

    public function baixaParcela($id_parcela,$valorBaixa = 0,$valorMulta = 0,$valorDesconto = 0,$valorJuros = 0)
    {
        $mParcela = new Application_Model_Parcelamento();
        $rsParcela = $mParcela->listarParcelamentoId($id_parcela);
        
        $dadosParcela['PAR_IN_ID'] = $id_parcela;

        //Calcular Baixa
        $valorBaixa = abs($valorBaixa + $valorMulta - $valorDesconto);

        if($valorJuros != 0){
           $valorBaixa = $valorBaixa+($valorJuros/100);
        }
        $totalBaixa = abs($rsParcela['PAR_DBL_PARCELA'] - $valorBaixa);

        if($totalBaixa == 0){
            $dadosParcela['PAR_CH_SITUACAO'] = "F";
        }
        
        if($totalBaixa > 0 && $totalBaixa < $rsParcela['PAR_DBL_PARCELA']){
            $dadosParcela['PAR_CH_SITUACAO'] = "P";
        }
        $mParcela->gravar($dadosParcela);
        return $valorBaixa;
    }

    public function getBaixa($PAR_IN_ID){
        $select = $this->select()
        ->setIntegrityCheck(false)
        ->from(array('b' => 'baixa'), array('*'))
        ->join(array('p' => 'parcelamento'), 'b.PAR_IN_ID = p .PAR_IN_ID', array('*'))
        ->WHERE("b.PAR_IN_ID = $PAR_IN_ID");
        return  $rsBaixa = $this->fetchAll($select);
    }

}

