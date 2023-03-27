<?php

/*
Atividade FPDF - PHP
CST Análise e Desenvolvimento de Sistemas (3º-MAT) 
Linguagem Técnica de Programação II
Alunas: Emanuely Vitória  Jadielle Cordeiro
*/

require('../fpdf/fpdf185/fpdf.php');
require('../fpdf/fpdf185/font/helvetica.php');

class PDF extends FPDF{

    function carregarNomes($arquivo){
        $linhas = file($arquivo);
        $dados = array();

        foreach($linhas as $linha){
            $dados[] = explode(';', trim($linha));
        } return $dados;
    }

    //tratamento de caracteres especiais:
    public function Cell($w, $h=0, $txt='', $border=0, $ln=0, $align='C', $fill=false, $link='') {
        $txt = utf8_decode($txt);
        parent::Cell($w, $h, $txt, $border, $ln, $align, $fill, $link);
}

    //criando a tabela:
    function criarTabela($cabecalho, $dados) {
        $l = array (42,22,128,22);
        
            for($v=0; $v < count($cabecalho); $v++){
                $this -> Cell($l[$v],9, $cabecalho[$v],1,0,'C');
            } $this -> Ln();

        //plot dos dados:
        foreach($dados as $tupla) {

            $this->Cell($l[0],10,$tupla[0],'LR');
            $this->Cell($l[1],10,$tupla[1],'LR');
            $this->Cell($l[2],10,$tupla[2],'LR');
            $this->Cell($l[3],10,number_format($tupla[3],1, '.', ''),'LR',0,'R');
            $this->Ln();
        }

        $this->Cell(array_sum($l),0,'','T');

    }

}

    $pdf = new PDF("L");

        $cabecalho = array('Nome','Curso','Disciplina','Média');

        $dados = $pdf -> carregarNomes('alunos.CSV');
        $pdf->SetFont('helvetica','',15);
        $pdf->AddPage();
        $pdf->criarTabela($cabecalho, $dados);
        $pdf->Output();
?>
