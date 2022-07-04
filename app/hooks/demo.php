<?php
	namespace funeraria\hooks;
    use \funeraria\lib\fpdf\FPDF;

    class demo extends FPDF {
    	
    	private $doc;
		private $nome;
		private $emal;
		private $endereco;
		private $date;
		private $celular;
		private $moeda;
		private $pagamento;
		private $quant = 0;
		private $subtotal = 0;
		private $total = 0;
		private $taxa = 0;
		private $dias;

    	function __construct($data="", $date="", $moeda="", $pagamento="") {
    		$this->doc = $data['doc'];
			$this->nome = $data['nome'];
			$this->endereco = $data['endereco'];
			$this->celular = $data['cell'];
			$this->date = $date;
			$this->moeda = $moeda;
			$this->pagamento = $pagamento;

			parent::__construct("p", "mm", "A4");
	        $this->SetFont('helvetica', '', '9');
    	}


    	#Page header
		function Header() {
			if($this->page ==1 ){
		    	$this->auxHeader($this->doc, $this->nome, $this->endereco, $this->date, $this->celular);
		    } else {
		    	$this->Ln(3.3); // célula fictícia para dar espaçamento de linha

		    	// tipo de {core}, {grossura}
				$this->SetDrawColor(104, 189, 69);
				$this->SetLineWidth(0.4);

				// titulos
				$this->Cell(9, 8, 'Nr.', 'T,B', 0);
				$this->Cell(12, 8, utf8_decode('Código'), 'T,B', 0, 'C');
				$this->Cell(34, 8, 'Item', 'T,B', 0);
				$this->Cell(60, 8, utf8_decode('Descrição'), 'T,B', 0);
				$this->Cell(15, 8, 'Qtd.', 'T,B', 0, 'C');
				$this->Cell(30, 8, utf8_decode('Preço Unit.'), 'T,B', 0, 'R');
				$this->Cell(29, 8, 'Total', 'T,B', 1, 'R');
		    }
		}

		#Aux
		function auxHeader($code, $name, $endereco, $date, $cell){
			//inicio dados do endereco
			$this->Cell(40);
			$this->Cell(0, 5, utf8_decode('MóvelCare'), 0, 1);
			$this->Cell(40);
			$this->Cell(0, 5, '##########, Q. 00, BOX 00', 0, 1);
			$this->Cell(40);
			$this->Cell(0, 5, '(+258) 82 00 00 00 / 84 00 00 000', 0, 1);
			$this->Cell(40);
			$this->Cell(0, 5, 'funeraria@movelcare.co.mz', 0, 1);

			// Logo
    		$this->Image('../../assets/img/administracao/logo/movelcare.png', 6, 10, 40);
			$this->Ln(15);

			$this->SetFont('helvetica', 'B', 11);
			$this->Cell(135, 4, $name, 0, 0, 'L');

			$this->SetFont('helvetica', 'B', 11);
			$this->Cell(25, 4, utf8_decode('Cotação#'), 0, 0, 'L');
			$this->SetFont('helvetica', '', 11);
			$this->Cell(0, 4, $code, 0, 1, 'R');
			$this->Ln(1);
			
			$this->SetFont('helvetica', '', 9);
			$this->Cell(135, 4, $endereco, 0, 0, 'L');

			$this->SetFont('helvetica', 'B', 11);
			$this->Cell(14, 4, "Data", 0, 0, 'L');
			$this->SetFont('helvetica', '', 9);
			$this->Cell(0, 4, $date, 0, 1, 'R');
			$this->Ln(1);

			$this->Cell(0, 4, $cell, 0, 1, 'L');
			$this->Ln(5);
			// fim do endereco
        }

        #Row data
        function Rowdata($item){
        	$this->Cell(189, 5, 'ORIGINAL', 0 ,1);
			// tipo de {fonte, borda, tamanho}
			$this->SetFont('helvetica', 'B', 9);

			// tipo de {core}, {grossura}
			$this->SetDrawColor(104, 189, 69);
			$this->SetLineWidth(0.4);

			// titulos
			$this->Cell(9, 8, 'Nr.', 'T,B', 0);
			$this->Cell(12, 8, utf8_decode('Código'), 'T,B', 0, 'C');
			$this->Cell(34, 8, 'Item', 'T,B', 0);
			$this->Cell(60, 8, utf8_decode('Descrição'), 'T,B', 0);
			$this->Cell(15, 8, 'Qtd.', 'T,B', 0, 'C');
			$this->Cell(30, 8, utf8_decode('Preço Unit.'), 'T,B', 0, 'R');
			$this->Cell(29, 8, 'Total', 'T,B', 1, 'R');

			// tipo de {fonte, borda, tamanho}
			$this->SetFont('helvetica', '', 8);
			$this->SetDrawColor(24, 24, 24);
			$this->SetLineWidth(0.1);
			$this->SetDash(1, 1);

			foreach ($item as $key => $value) {$key++;
				$this->Cell(9, 6, $key, 'B', 0);
				$this->Cell(12, 6, $value['codigo'], 'B', 0, 'C');
				$this->Cell(34, 6, $value['item'], 'B', 0);
				$this->Cell(60, 6, $value['descricao'], 'B', 0, 'L');
				$this->Cell(15, 6, $value['qtd'], 'B', 0, 'C');
				$this->Cell(30, 6, number_format($value['preco_un'], 2, ',', '.').' '.$this->moeda, 'B', 0, 'R');
				$this->Cell(29, 6, number_format(($value['qtd'] * $value['preco_un']), 2, ',', '.').' '.$this->moeda, 'B', 1, 'R');
				$this->quant += $value['qtd'];
				$this->subtotal += $value['qtd'] * $value['preco_un'];
				$this->dias = ($value['dias_trans'] == "-") ? '' : $value['dias_trans'];
				$taxa = ($value['dias_trans'] == "-" && $value['taxa_trans'] == 0) ? $value['taxa_trans'] : $this->taxa += $value['dias_trans'] * $value['taxa_trans'];
			}
			$this->taxa = $taxa;
			$this->total = $this->subtotal + $this->taxa;
        }

		#Page footer
		function Footer() {
			$this->SetY(-50);

			$this->auxfooter($this->quant, $this->subtotal, $this->dias, $this->taxa, $this->total);
		    // Position at 1.5 cm from bottom
		    $this->SetY(-15);
		    // Helvetica {estilo da fonte} 8
		    $this->SetFont('helvetica', '', 8);
		    // Numero da pégina
		    $this->Cell(0, 10, utf8_decode('Pág. ').$this->PageNo().' de {nb}',0,0,'C');
		}

		#Aux
	    function auxfooter($qtd, $sub, $dias, $tx, $total){
	    	//inicio dos dados do footer
	    	$this->SetFont('helvetica', '', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->SetDash(0, 0);
			$this->Cell(189, 5, 'movelcare.co.mz', 'T', 1, 'C');

			$this->SetDrawColor(0, 0, 0); // cor da linha
			$this->SetLineWidth(0.1); // especura da linha
			$this->Cell(28, 5, utf8_decode('Dados Bancários: '), 'L,T', 0, 'L');
			$this->SetTextColor(104, 189, 69);
			$this->Cell(60, 5, utf8_decode('MóvelCare'), 'T', 0);
			$this->SetTextColor(0, 0, 0); //cor da fonte
			$this->Cell(27, 5, 'Total Qtd Items:', 'T,R', 0, 'R');
			$this->Cell(15, 5, $qtd, 0, 0, 'C');
			$this->SetFont('helvetica', 'B', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(30, 5, 'Subtotal:', 'L,T', 0, 'R');
			$this->SetFont('helvetica', '', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(29, 5, number_format($sub,2,'.', ',').' '.$this->moeda, 'T,R', 1, 'R');

			$this->Cell(13, 5, 'Moeda:', 'L,B', 0);
			$this->SetTextColor(104, 189, 69); // cor da fonte
			$this->SetFont('helvetica', '', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(10, 5, $this->moeda, 'B', 0);
			$this->SetTextColor(0, 0, 0); // cor da fonte
			$this->Cell(35, 5, 'Forma de Pagamento:', 'B', 0);
			$this->SetTextColor(104, 189, 69);
			$this->Cell(40, 5, utf8_decode($this->pagamento), 'B', 0);
			$this->SetTextColor(0, 0, 0); // cor da fonte
			$this->Cell(17, 5, (($dias == '') ? '' : 'Dias:' ), 'B,R', 0, 'R');
			$this->Cell(15, 5, $dias, 0, 0, 'C');
			$this->SetFont('helvetica', 'B', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(30, 5, utf8_decode('* Taxa Diária:'), 'L', 0, 'R');
			$this->SetFont('helvetica', '', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(29, 5, number_format($tx, 2, '.', ',').' '.$this->moeda, 'R', 1, 'R');

			$this->Cell(130);
			$this->SetFont('helvetica', 'B', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(30, 5, 'Desconto Promo:', 'L', 0, 'R');
			$this->SetFont('helvetica', '', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(29, 5, number_format('0', 2, '.', ',').' '.$this->moeda, 'R', 1, 'R');

			$this->SetLineWidth(0.1); // especura da lina
			$this->Cell(115, 5, utf8_decode('* 1,800.00 '.$this->moeda.' por veículo, caso tenha a taxa diária.'), 'L,T,R', 0);
			$this->Cell(15);
			$this->SetFont('helvetica', 'B', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(30, 5, 'Desconto:', 'L', 0, 'R');
			$this->SetFont('helvetica', '', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(29, 5, number_format('0', 2, '.', ',').' '.$this->moeda, 'R', 1, 'R');

			$this->Cell(115, 6, 'Iva Incluso', 'L,B,R', 0, 'L');
			$this->Cell(15);
			$this->SetFont('helvetica', 'B', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(30, 6, 'Total:', 'L,B', 0, 'R');
			$this->SetFont('helvetica', '', 9.5); // fonte familia, bolde, tamanho da fonte
			$this->Cell(29, 6, number_format($total,2,'.', ',').' '.$this->moeda, 'B,R', 1, 'R');
			// fim dos dados do footer
		}
    }
?>